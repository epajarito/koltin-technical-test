@component('mail::message')
# Mensajes en base a tu inbox
Aquí te listamos los chats del día: <b>{{ now()->format('Y-m-d') }}</b>.
# Publicación: {{ $conversation->post->title }}
@php
    $sender = $conversation->sender;
@endphp
<ul>
    @foreach($conversation->chats as $message)
        <li>
            <p>
                <br>
                <b>{{ $sender->name }}</b>: {{ $message->message }}
                <br>
                <small>
                    fecha: {{ $message->created_at->format('Y-m-d H:i') }}
                </small>
            </p>
        </li>
    @endforeach
</ul>

Gracias,<br>
{{ config('app.name') }}
@endcomponent
