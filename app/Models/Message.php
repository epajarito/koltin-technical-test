<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'message',
        'user_id_sender',
        'user_id_receiver',
        'post_id'
    ];

    public function userSender(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id_sender', 'id');
    }

    public function userReceiver(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id_receiver', 'id');
    }

    public function attachments(): MorphMany
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    public function attachment(): MorphOne
    {
        return $this->morphOne(Attachment::class, 'attachable');
    }
}
