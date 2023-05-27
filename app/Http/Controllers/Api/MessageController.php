<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Message\StoreRequest;
use App\Http\Resources\Api\Message\MessageCollection;
use App\Http\Resources\Api\Message\MessageResource;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index(Request $request)
    {
        $messages = Message::query()
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

        return new MessageResource($message);
    }
}
