<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
	protected $table = 'tasks';

    protected $fillable = [
        'title', 'user_id', 'text', 'file', 'status', 'manager_answered'
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'task_id');
    }

}
