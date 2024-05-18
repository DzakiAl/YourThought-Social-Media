<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('post.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg'],
            'video' => ['nullable', 'mimetypes:video/mp4,video/avi,video/mpeg,video/quicktime'],
            'caption' => ['required', 'string']
        ]);

        // Handle file uploads
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $this->handleFileUpload($request->file('image'), 'public/post_images');
        }

        $videoPath = null;
        if ($request->hasFile('video')) {
            $videoPath = $this->handleFileUpload($request->file('video'), 'public/post_videos');
        }

        // Create new post entry
        $post = new Post();
        $post->image = $imagePath ? 'post_images/' . basename($imagePath) : null;
        $post->video = $videoPath ? 'post_videos/' . basename($videoPath) : null;
        $post->caption = $data['caption'];
        $post->user_id = $request->user()->id;
        $post->save();

        return redirect()->route('profile.index', $post);
    }

    /**
     * Handle the file upload and return the stored file path.
     */
    private function handleFileUpload($file, $directory)
    {
        $originalName = $file->getClientOriginalName();
        $nameWithoutExtension = pathinfo($originalName, PATHINFO_FILENAME);
        $extension = $file->getClientOriginalExtension();

        $i = 1;
        $uniqueName = $originalName;
        while (Storage::exists($directory . '/' . $uniqueName)) {
            $uniqueName = $nameWithoutExtension . '_' . $i . '.' . $extension;
            $i++;
        }

        return $file->storeAs($directory, $uniqueName);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        // Delete the image and video from storage if they exist
        if ($post->image && Storage::exists('public/' . $post->image)) {
            Storage::delete('public/' . $post->image);
        }

        if ($post->video && Storage::exists('public/' . $post->video)) {
            Storage::delete('public/' . $post->video);
        }

        // Delete the post
        $post->delete();

        return redirect()->route('profile.index');
    }
}