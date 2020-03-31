<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\MyTasksRequest;
use App\Http\Requests\MessagesRequest;
use App\Task;
use DB;
use File;
use Auth;
use Carbon\Carbon;
use Mail;
use App\User;
use App\Mail\NewTaskNotification;
use App\Mail\TaskClosedNotification;
use Intervention\Image\ImageManagerStatic as Image;

class MyTasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = auth()->user()->tasks()->paginate(10);

        return view('my-tasks.index')->with('tasks', $tasks);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('my-tasks._form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MyTasksRequest $request)
    {
        $data = $request->except('_token');
        $data['file'] = $request->file('file')->hashName();
        $user_id = auth()->user()->id;
        $day = Carbon::now()->subDays(1)->toDateTimeString();

        $task = Task::orderBy('created_at', 'desc')->where(['user_id' => $user_id, ['created_at', '>', $day]])->first();

        if ($task) {
            return redirect()->route('client.my-tasks.index')->with('error', "You need to wait one day from {$task->created_at}!");
        }

        $managers_email = User::whereHas('roles', function($q) {
                   $q->where('slug', 'manager');
               }
            )->pluck('email')->toArray();

        $task = auth()->user()->tasks()->create($data);

        Mail::to($managers_email)->send(new NewTaskNotification($task));

        if($request->hasFile('file') && $task->id) {
            $this->imagesCopy($request, $task->id, 'tasks');
        }

        return redirect()->route('client.my-tasks.index')->with('success', 'Saved successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $task = auth()->user()->task($id)->with('messages.user.roles')->first();

        return view('my-tasks.show')->with('task', $task);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        if ($task->delete()) {
            $path = "uploads/tasks/{$id}/";
            File::deleteDirectory($path);
        }
        return redirect()->route('client.my-tasks.index')->with('success', 'Successfully deleted!');
    }

    public function closeTask($id)
    {
        $task = Task::findOrFail($id);
        if ($task->status == 0) {
            return redirect()->route('client.my-tasks.index')->with('error', "Task '{$task->title}' already closed!");
        } else {
            $task->status = 0;
            if ($task->save()) {
                $managers_email = User::whereHas('roles', function($q) {
                       $q->where('slug', 'manager');
                   }
                )->pluck('email')->toArray();
        
                Mail::to($managers_email)->send(new TaskClosedNotification($task));
    
                return redirect()->route('client.my-tasks.index')->with('success', 'Task closed!');
            }
        }
    }

    public function imagesCopy($request, $id, $folder, $cleanDir = false)
    {
        $image = $request->file('file');

        $path = "uploads/{$folder}/{$id}/";
        if(!File::isDirectory($path)){
            File::makeDirectory($path, 0777, true, true);
        }
        
        if ($cleanDir) {
            File::cleanDirectory($path);
        }

        $filename = $request->file('file')->hashName();
        
        $image_resize = Image::make($image->getRealPath());
        if ($image_resize->width() > 1000) {
            $image_resize->resize(1000, null, function ($constraint) {
                $constraint->aspectRatio();
            });
        }              

        $image_resize->save(public_path($path . $filename));
    }
}
