<?php

namespace App\Http\Middleware;

use Closure;
use App\Task;

class TaskOwnerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $id = $request->route('my_task');

        if ($id) {
            $task = Task::findOrfail($id);
            if ($task->user_id != $request->user()->id) {
                abort(404);
            }
        }

        return $next($request);
    }
}
