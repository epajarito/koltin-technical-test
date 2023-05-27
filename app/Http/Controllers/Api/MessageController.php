<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Message\StoreRequest;
use App\Http\Resources\Api\Message\MessageCollection;
use App\Http\Resources\Api\Message\MessageResource;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index(Request $request)
    {
        $messages = Message::query()
            ->with('attachment')
            ->where('post_id', '=', request()->input('post_id'))
            ->latest()
            ->paginate()
            ->withQueryString();

        return MessageCollection::make($messages);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return MessageResource
     */
    public function store(StoreRequest $request)
    {
        $message = Message::create($request->validated());

        if( $request->hasFile('file') ){
            $url = $this->upload($request->file('file'));

            $message->attachments()->create([
                'user_id' => $request->input('user_id_sender'),
                'url' => $url
            ]);
        }

        return new MessageResource($message->load('attachment'));
    }

    private function upload(UploadedFile $uploadedFile)
    {
        $name = time() . ".{$uploadedFile->getClientOriginalExtension()}";
        return $uploadedFile->storeAs('attachments', $name,'public');
    }
}
