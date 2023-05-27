<?php

namespace App\Jobs;

use App\Mail\SendHistoryChats;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendHistoryIndividualChat implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $conversations;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($conversations)
    {
        $this->conversations = $conversations;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->conversations as $conversation){
            Mail::to($conversation->receiver)
                ->send(new \App\Mail\SendHistoryIndividualChat($conversation));
        }
    }
}
