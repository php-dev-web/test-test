@extends('layouts.app')

@section('content')
    <div class="container">
        <a href="{{ route('manager.tasks.index') }}" class="btn btn-info mb-3">Back</a>
        <table class="table">
            <tbody>
                <tr>
                  <th>Title</th>
                    <td>{{ $task->title }}</td>
                </tr>
                <tr>
                  <th>Text</th>
                    <td>{{ $task->text }}</td>
                </tr>
                <tr>
                  <th>File</th>
                    <td>
                        <img src="/uploads/tasks/{{ $task->id }}/{{ $task->file }}" width="150px">
                    </td>
                </tr>
            </tbody>
        </table>
        <h2 class="text-center">Messages</h2>
        @if(!$task->messages->isEmpty())
            <div class="list-group">
            @foreach($task->messages as $message)
              <a class="list-group-item list-group-item-action flex-column align-items-start">
                <div class="d-flex w-100 justify-content-between">
                  <h5 class="mb-1">
                    {{ $message->user->name }}
                      <small>
                          ({{ $message->user->hasRole('manager') ? 'manager' : 'client' }})
                      </small>
                  </h5>
                  <small>{{ $message->created_at->diffForHumans() }}</small>
                </div>
                <p class="mb-1">
                    {{ $message->text }}
                </p>
              </a>
            @endforeach
            </div>
        @endif
        <form action="{{ route('manager.tasks.sendMessage', $task->id) }}" method="POST" class="mt-3">
          @csrf
          <div class="form-group">
            <label for="message-text">Message text</label>
            <textarea class="form-control @error('message-text') is-invalid @enderror" id="text" name="text" rows="3"></textarea>
          </div>
           @error('message-text')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
           @enderror
          <div class="form-group">
            <button class="btn btn-primary">Send</button>
          </div>
        </form>
    </div>
@endsection