<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // public function messages()
    // {
    //     return $this->hasMany(Message::class)->latest();
    // }

    // public function messagesTo()
    // {
    //     return $this->hasMany(Message::class, "user_to")->latest();
    // }

    // public function latestMessage($messages, $messagesTo)
    // {
    //     $message = collect();
    //     foreach ($messages as $m) {
    //         if ($m->user_to == auth()->id()) {
    //             $message = $m;
    //             break;
    //         }
    //     }
    //     foreach ($messagesTo as $m) {
    //         if ($m->user_id == auth()->id()) {
    //             if ($m->id > $message->id){
    //                 $message = $m;
    //                 break;
    //             }
    //         }
    //     }
    //     return $message;
    // }
    public function latestMessage()
    {
        return Message::query()
            ->where([
                ["user_id", auth()->id()],
                ["user_to", $this->id]
            ])
            ->orWhere([
                ["user_id", $this->id],
                ["user_to", auth()->id()]
            ])
            ->latest()
            ->first();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
