<?php

namespace App\Console\Commands;

use App\Jobs\SendHistoryDailyMessages;
use App\Mail\SendHistoryChats;
use App\Models\Post;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendDailyChats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'chats:send-history-daily-messages';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando para el envio de los chats en base a tu publicacion(s) del día.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $users = User::query()
            ->has('dailyMessages')
            ->with(['dailyMessages.userSender','dailyMessages.post'])
            ->get();

        SendHistoryDailyMessages::dispatch($users);

    }
}
