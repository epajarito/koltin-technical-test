<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->longText('message');
            $table->unsignedBigInteger('user_id_sender');
            $table->unsignedBigInteger('user_id_receiver');
            $table->foreignIdFor(\App\Models\Post::class)->constrained()->cascadeOnDelete();
            $table->timestamps();

            $table
                ->foreign('user_id_sender')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();

            $table
                ->foreign('user_id_receiver')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }
}
