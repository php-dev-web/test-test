@extends('layouts.app')

@section('content')
<div class="container">

	<form action="{{ route('client.my-tasks.store') }}" method="POST" enctype="multipart/form-data">

		@csrf
	
		<div class="form-group">
		  <label for="title">{{ __('Title') }}</label>
		  <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" id="title" placeholder="Title" value="{{ old('title') }}">
		  @error('title')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
		</div>

		<div class="form-group">
		  <label for="text">{{ __('Text') }}</label>
		  <textarea class="form-control @error('text') is-invalid @enderror" name="text" id="text" cols="10" rows="5" placeholder="Text">{{ old('text') }}</textarea>
		   @error('text')
				<span class="invalid-feedback" role="alert">
				    <strong>{{ $message }}</strong>
				</span>
		   @enderror
		</div>

		<div class="form-group">
			<div class="custom-file">
				<input type="file" class="custom-file-input @error('file') is-invalid @enderror" id="file" name="file" accept=".png, .jpg, .jpeg">
				<label class="custom-file-label" for="file">{{ __('Choose file...') }}</label>
				@error('file')
				    <span class="invalid-feedback" role="alert">
				        <strong>{{ $message }}</strong>
				    </span>
				@enderror
  			</div>
  		</div>

		<div class="form-group">
			<button class="btn btn-primary">Save</button>
			<a href="{{ route('client.my-tasks.index') }}" class="btn btn-info">Back</a>
		</div>
	
	</form>

</div>
 @endsection