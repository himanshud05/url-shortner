<?php

namespace App\Http\Controllers;

use App\Models\UrlModel;
use App\Notifications\ExpireNotification;
use Illuminate\Http\Request;
use Laravel\Telescope\Telescope;

class UrlModelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
           $urlModels = UrlModel::where('user_id', auth()->id())
                ->orderBy('created_at', 'desc')
                ->paginate(10);
            return view('dashboard', compact('urlModels'));
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to retrieve URL models.'], 500);
        }
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('url.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'original_url' => 'required|url',
        ]);

        try {
            $urlModel = new UrlModel();
            $urlModel->user_id = auth()->id();
            $urlModel->original_url = $request->input('original_url');
            $urlModel->short_url = UrlModel::getShortCode();
            $urlModel->is_disabled = false; 
            $urlModel->save();
            return redirect()->route('dashboard')->with('success', 'URL created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to create URL.']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
       
        $urlModel = UrlModel::findOrFail($id);
        if ($urlModel->user_id !== auth()->id()) {
            return redirect()->back()->withErrors(['error' => 'Unauthorized action.']);
        }
        return view('url.show', compact('urlModel'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($url)
    {
        $urlModel = UrlModel::findOrFail($url);
    
        if ($urlModel->user_id !== auth()->id()) {
            return redirect()->back()->withErrors(['error' => 'Unauthorized action.']);
        }
        return view('url.edit', compact('urlModel'));   
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UrlModel $url)
    {
        $request->validate([
            'original_url' => 'required|url',
            'expires_at' => 'nullable|date',
        ]);

        try {
            $urlModel = UrlModel::findOrFail($url->id);
            $url->update([
                'original_url' => $request->input('original_url'),
                'expires_at' => $request->input('expires_at') ? \Carbon\Carbon::parse($request->input('expires_at')) : null,
                'is_disabled' => $request->has('is_disabled') ? true : false,
            ]);
           
            return redirect()->route('dashboard')->with('success', 'URL updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to update URL.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request , $url)
    {
        try {
            $urlModel = UrlModel::findOrFail($url);
            if ($urlModel->user_id !== auth()->id()) {
                return redirect()->back()->withErrors(['error' => 'Unauthorized action.']);         
            }
            $urlModel->delete();
            
            return redirect()->route('dashboard')->with('success', 'URL deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to delete URL.']);
        }
    }
    public function redirect($shortUrl)
    {
        $urlModel = UrlModel::where('short_url', $shortUrl)->firstOrFail();
        
        if ($urlModel->is_disabled) {
            return redirect()->back()->withErrors(['error' => 'This URL has been disabled.']);
        }

        if ($urlModel->expires_at && $urlModel->expires_at < now()) {
            return redirect()->back()->withErrors(['error' => 'This URL has expired.']);
        }
        Telescope::tag(function () use ($urlModel) {
            return ['short_url' => $urlModel->short_url];
        });
        $urlModel->increment('redirect_count');
        return redirect($urlModel->original_url);
    }
    public function NotifyExpiration()
    {
        $expireUrl = UrlModel::where('expires_at', '<=', now())
            ->where('is_disabled', false)
            ->get();
        foreach ($expireUrl as $url) {
            if($url->user){
                $url->user->notify(new ExpireNotification($url));
            }
        }
    }
}
