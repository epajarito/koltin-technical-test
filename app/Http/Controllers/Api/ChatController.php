<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Chat\StoreRequest;
use App\Http\Resources\Api\Chat\ChatCollection;
use App\Http\Resources\Api\Chat\ChatResource;
use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

class ChatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index(Request $request)
    {
        $chats = Chat::query()
            ->with(['user','conversation','attachment'])
            ->where('conversation_id', '=', request()->input('conversation_id'))
            ->latest()
            ->paginate()
            ->withQueryString();

        return ChatCollection::make($chats);
    }

    public function store(StoreRequest $request)
    {
        $chat = Chat::create($request->validated());

        if( $request->hasFile('file') ) {
            $url = $this->upload($request->file('file'));

            $chat->attachments()->create([
                'user_id' => $request->input('user_id'),
                'url' => $url
            ]);
        }

        return new ChatResource($chat->load('attachment'));
    }

    private function upload(UploadedFile $uploadedFile)
    {
        $name = time() . ".{$uploadedFile->getClientOriginalExtension()}";
        return $uploadedFile->storeAs('attachments', $name,'public');
    }
}
