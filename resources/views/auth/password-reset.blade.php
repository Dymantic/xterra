@extends('admin.base')

@section('content')
<div class="max-w-lg p-8 shadow-lg mt-20 mx-auto">
    <p class="text-3xl mb-8">Reset Your Password</p>

    <form method="POST"
          action="{{ route('password.update') }}">
        @csrf

        <input type="hidden"
               name="token"
               value="{{ $token }}">

        <div class="my-4">
            <label for="email"
                   class="form-label">Email</label>

            <input id="email"
                   type="email"
                   class="form-input @error('email') border-red-400 @enderror"
                   name="email"
                   value="{{ $email ?? old('email') }}"
                   required
                   autocomplete="email"
                   autofocus>

            @error('email')
            <span class="text-red-400"
                  role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="my-4">
            <label for="password"
                   class="form-label">Password</label>

            <input id="password"
                   type="password"
                   class="form-input  @error('password') border-red-400 @enderror"
                   name="password"
                   required
                   autocomplete="new-password">

            @error('password')
            <span class="text-red-400"
                  role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="my-4">
            <label for="password-confirm"
                   class="form-label">Confirm password</label>

            <input id="password-confirm"
                   type="password"
                   class="form-input"
                   name="password_confirmation"
                   required
                   autocomplete="new-password">
        </div>

        <div class="mt-8">
            <button type="submit"
                    class="btn btn-dark">
                Reset Password
            </button>
        </div>
    </form>
</div>
@endsection