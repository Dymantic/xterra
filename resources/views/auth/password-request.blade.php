@extends('admin.base')

@section('content')
<div class="max-w-lg p-8 shadow-lg mt-20 mx-auto">
    <p class="mb-4 text-xl font-bold text-gray-800">Forgot your password?</p>
    @if(session()->has('status'))
        <p>{{ session('status') }}</p>
    @else
        <p>Don't worry, it happens to everyone. Give us the email you attached to your account and we'll send you a link to change your password.</p>
    @endif

    <form action="{{ route('password.email') }}" method="POST">
        {!! csrf_field() !!}
        <div class="my-4 {{ $errors->has('email') ? ' has-error' : '' }}">
            <label for="email" class="form-label">Email: </label>
            @if($errors->has('email'))
            <span class="error-message">{{ $errors->first('email') }}</span>
            @endif
            <input type="text" name="email" value="{{ old('email') }}" class="form-input">
        </div>
        <div class="flex justify-end mt-8">
            <button type="submit" class="btn btn-dark">Send Reset Link</button>
        </div>
    </form>
</div>
@endsection