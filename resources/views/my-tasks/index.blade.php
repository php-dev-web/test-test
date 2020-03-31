@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                	My tasks
					<a href="{{ route('client.my-tasks.create') }}" class="btn btn-primary float-right btn-sm">Create</a>
                </div>

                <div class="card-body">
                    <table class="table table-striped">
                    @if(!$tasks->isEmpty())
                      <thead>
                        <tr>
                          <th scope="col">#</th>
                          <th scope="col">Title</th>
                          <th scope="col">Text</th>
                          <th scope="col">File</th>
                          <th scope="col">Status</th>
                          <th scope="col">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($tasks as $key => $task)
                            <tr>
                              <th scope="row">{{ $tasks->firstItem() + $key }}</th>
                              <td>{{ $task->title }}</td>
                              <td>{{ Str::limit($task->text, 10) }}</td>
                              <td>
                                <img src="/uploads/tasks/{{ $task->id }}/{{ $task->file }}" width="50px">
                              </td>
                              <td>{{ $task->status == 0 ? 'Closed' : 'Active' }}</td>
                              <td>
            <a href="{{ route('client.my-tasks.show', $task->id) }}" class="btn btn-primary btn-sm">Show</a>
            <form action="{{ route('client.my-tasks.destroy', $task->id) }}" method="POST" style="display: inline-block;">
                {!! method_field('DELETE') !!}
                {{ csrf_field() }}
                <button type="submit" class="btn btn-danger btn-sm remove">Delete</button>
            </form>
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
