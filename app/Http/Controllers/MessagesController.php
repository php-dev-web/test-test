<?php

namespace App\Http\Controllers;

use App\Http\Requests\MessagesRequest;
use App\Message;
use App\Task;
use App\User;
use Mail;
use App\Mail\NewMessageNotification;

class MessagesController extends Controller
{
    public function sendMessage(MessagesRequest $request, $id)
    {
    	$data = $request->except('_token');
		$task = Task::findOrFail($id);
		$user = auth()->user();

    	if ($user->hasRole('client')) {
    		$managers_email = User::whereHas('roles', function($q) {
						       $q->where('slug', 'manager');
						   }
						)->pluck('email')->toArray();

			Mail::to($managers_email)->send(new NewMessageNotification($task));
    	} elseif ($user->hasRole('manager')) {
    		Mail::to($task->user->email)->send(new NewMessageNotification($task));
            $task->manager_answered = 1;
            $task->save();
    	}

    	$data['task_id'] = $id;
    	$data['user_id'] = $user->id;

    	Message::create($data);

    	return redirect()->back()->with('success', 'Saved successfully!');
    }
}
