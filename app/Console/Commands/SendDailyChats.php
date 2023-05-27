<?php

namespace App\Console\Commands;

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
    protected $signature = 'chats:send-all-chat-from-current-day';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando para el envio de los chats del día';

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
            ->with('dailyMessages.userSender')->get();
        foreach ($users as $user){
            Mail::to($user)->send(new SendHistoryChats($user->dailyMessages));
        }

    }
}
