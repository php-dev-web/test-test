@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                	Tasks
                </div>

                <div class="card-body">
                    <table class="table table-striped">
                    @if(!$tasks->isEmpty())
                      <thead>
                        <tr>
                          <th scope="col">#</th>
                          <th scope="col">Username</th>
                          <th scope="col">Title</th>
                          <th scope="col">Text</th>
                          <th scope="col">File</th>
                          <th scope="col"><a href="?orderBy=status"  data-sort="status">Status</a></th>
                          <th scope="col"><a href="?orderBy=manager_answered"  data-sort="manager_answered">Answered</a></th>
                          <th scope="col">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($tasks as $key => $task)
                            <tr>
                              <th scope="row">{{ $tasks->firstItem() + $key }}</th>
                              <td>{{ $task->user->name }}</td>
                              <td>{{ $task->title }}</td>
                              <td>{{ Str::limit($task->text, 10) }}</td>
                              <td>
                                <img src="/uploads/tasks/{{ $task->id }}/{{ $task->file }}" width="50px">
                              </td>
                              <td>{{ $task->status == 0 ? "Closed" : 'Active' }}</td>
                              <td>{{ $task->manager_answered ? 'Yes' : 'No' }}</td>
                              <td>
                                <a href="{{ route('manager.tasks.show', $task->id) }}" class="btn btn-primary btn-sm">Show</a>
                              </td>
                            </tr>
                        @endforeach
                      </tbody>
                      @else
                        <td colspan="5" class="text-center">Tasks not found</td>
                      @endif
                    </table>
                    {{ $tasks->links() }}
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
