<?php

namespace Database\Seeders;

use App\Models\Message;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory()
            ->times(10)
            ->hasPosts(3)
            ->create()
            ->each(function (User $user){
                foreach ( $user->posts as $post ){

                    Message::factory()
                        ->times(3)
                        ->create([
                            'post_id' => $post->id,
                            'user_id_receiver' => $post->user_id
                        ]);
                }
            });

        \App\Models\User::factory()->create([
            'name' => "Demo User",
            'email' => "demo@servicios-online.mx",
            'password' => bcrypt('password')
        ]);
    }
}
