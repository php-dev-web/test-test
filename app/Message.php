<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'messages';

    protected $fillable = [
        'task_id', 'user_id', 'text', 'manager_answered'
    ];
    
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function hasAnswer()
    {

    }

}
