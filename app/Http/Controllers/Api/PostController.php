<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\Post\StoreRequest;
use App\Http\Resources\Api\Post\PostCollection;
use App\Http\Resources\Api\Post\PostResource;
use App\Models\Movie;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\UploadedFile;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->only(['store','show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $posts = Post::latest('created_at')
            ->with('messages.userSender')
            ->paginate();

        return PostCollection::make($posts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $data['image'] = $this->upload($request->file('image'));
        $post = Post::create($data);

        return response()->noContent();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return PostResource
     */
    public function show(Post $post)
    {
        return new PostResource($post->load('messages'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
    }

    private function upload(UploadedFile $uploadedFile)
    {
        $name = time() . ".{$uploadedFile->getClientOriginalExtension()}";
        return $uploadedFile->storeAs('images', $name,'public');
    }
}
