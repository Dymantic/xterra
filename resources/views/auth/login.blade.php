@extends('admin.base')

@section('content')
    <div class="max-w-lg mx-auto p-8 bg-white shadow-lg mt-20">
        <form action="/admin/login"
              method="POST">
            {!! csrf_field() !!}
            <p class="uppercase font-bold text-gray-800 text-xl">Login</p>
            <div class="my-4 {{ $errors->has('email') ? ' has-error' : '' }}">
                <label class="form-label"
                       for="email">Email: </label>
                @if($errors->has('email'))
                    <span class="error-message">{{ $errors->first('email') }}</span>
                @endif
                <input type="text"
                       name="email"
                       value="{{ old('email') }}"
                       class="form-input">
            </div>
            <div class="my-4 {{ $errors->has('password') ? ' has-error' : '' }}">
                <label class="form-label"
                       for="password">Password: </label>
                @if($errors->has('password'))
                    <span class="error-message">{{ $errors->first('password') }}</span>
                @endif
                <input type="password"
                       name="password"
                       value="{{ old('password') }}"
                       class="form-input">
            </div>
            <div>
                <label class="form-label"
                       for="remember">Remember me</label>
                <input type="checkbox"
                       name="remember_me"
                       id="remember">

            </div>

            <div class="flex justify-between items-center mt-8">
                <button class="btn btn-dark" type="submit">Login</button>
                <a class="text-gray-600 hover:text-gray-800 hover:underline" href="{{ route('password.request') }}">Forgot password?</a>
            </div>
        </form>
    </div>
@endsection