<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'url',
        'user_id',
        'attachable_id',
        'attachable_type'
    ];

    public function getTypeAttribute(): string
    {
        $imageMimes = ["jpeg","png","jpg","gif","svg",'webp'];

        $parts = explode('.', $this->url);

        if(in_array(last($parts), $imageMimes)){
            return "image";
        }

        return "audio";
    }

    public function getFullUrlAttribute(): string
    {
        return asset("storage/".$this->url);
    }
}
