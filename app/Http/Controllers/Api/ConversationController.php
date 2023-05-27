<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\Api\Conversation\ConversationResource;
use App\Models\Conversation;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Requests\Api\Conversation\StoreRequest;
use Illuminate\Http\Request;

class ConversationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function store(StoreRequest $request)
    {
        $conversation = Conversation::query()
            ->where(function(Builder $query) use($request) {
                $query->where('user_id_sender','=', auth()->id())
                    ->where('user_id_receiver','=', $request->input('user_id_receiver'))
                    ->where('post_id', '=', $request->input('post_id'));
            })
            ->orWhere(function (Builder $query) use($request){
                $query->where('user_id_sender','=', $request->input('user_id_receiver'))
                    ->where('user_id_receiver','=', auth()->id())
                    ->where('post_id', '=', $request->input('post_id'));
            })
            ->firstOr(function () use($request){
                return Conversation::create($request->validated());
            });

        return new ConversationResource($conversation->load(['sender','receiver','post']));
    }

    public function show(Conversation $conversation)
    {
        return new ConversationResource($conversation->load('post'));
    }
}
