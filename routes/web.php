<?php

use App\Models\Conversation;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('testing', function(){
    $conversations = Conversation::query()
        ->has('chats')
        ->with(['sender.senderChats','post','receiver'])
        ->get();
    foreach ($conversations as $conversation){
        echo "Conversation[$conversation->id] <br>";
        echo "Reibio: " . $conversation->receiver->name . "<br>";
        echo "Publicación[{$conversation->post->id}]: " . $conversation->post->title . "<br>";
        foreach($conversation->chats as $message) {
            echo "Usuario [{$conversation->sender->name}]: " . $message->message;
            echo "<br>";
            echo "Fecha de creación: " . $message->created_at->format('Y-m-d H:i') . "<br>";
        }
        echo '<br><br><br>';
    }
    dd($conversations->toArray());
});
Route::view('/{any}', 'front-end' )->where('any', '.*');
