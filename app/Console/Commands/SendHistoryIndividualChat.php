<?php

namespace App\Console\Commands;

use App\Models\Conversation;
use Illuminate\Console\Command;
use App\Jobs\SendHistoryIndividualChat as SendHistoryIndividualChatJob;

class SendHistoryIndividualChat extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'chats:send-history-individual-chats';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando para el envio de los chats individuales del día.';

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
        $conversations = Conversation::query()
            ->has('chats')
            ->with(['sender','post','receiver','chats'])
            ->get();

        SendHistoryIndividualChatJob::dispatch($conversations);
    }
}
