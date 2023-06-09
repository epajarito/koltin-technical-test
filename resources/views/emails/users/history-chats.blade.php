@component('mail::message')
# Mensajes en base a tus publicaciones:

Aquí te listamos los chats del día: <b>{{ now()->format('Y-m-d') }}</b>.

<ul>
    @foreach($messages as $message)
        <li>
            <p>
                <span>Publicación: <b>{{ $message->post->title }}</b></span>
                <br>
                <b>{{ $message->userSender->name }}</b>: {{ $message->message }}
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
