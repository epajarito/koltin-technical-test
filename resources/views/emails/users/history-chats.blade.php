@component('mail::message')
# Introduction

Aquí te listamos los chats del día {{ now()->format('Y-m-d') }}.

<ul>
    @foreach($messages as $message)
        <li>
            <p>
                <b>{{ $message->userSender->name }}</b>: {{ $message->message }}
                <br>
                <small>
                    fecha: {{ $message->created_at->format('Y-m-d H:i') }}
                </small>
            </p>
        </li>
    @endforeach
</ul>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
