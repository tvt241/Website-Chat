<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected function getCreatedAtForHumansAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    protected $fillable = [
        'message',
        'user_id',
        'user_to',
    ];
}
