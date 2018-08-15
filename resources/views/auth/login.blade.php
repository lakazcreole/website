@extends('layouts.app')

@section('content')
<div class="container m-auto flex">
    <div class="max-w-sm w-full mx-auto">
        <h1 class="text-grey uppercase tracking-wide text-lg my-10 text-center">Login</h1>
        <form method="POST" action="{{ route('login') }}">
            <div class="bg-grey-lightest shadow-lg rounded-lg p-5">
                @csrf
                <div class="mb-5">
                    <label for="email" class="block font-semibold text-grey-darker text-sm mb-2">Email address</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="w-full p-2 rounded border border-grey-light text-grey-darker" required autofocus>
                    @if ($errors->has('email'))
                        <div class="mt-2 text-sm text-red-light">
                            {{ $errors->first('email') }}
                        </div>
                    @endif
                </div>
                <div class="mb-5">
                    <label for="password" class="block font-semibold text-grey-darker text-sm mb-2">Password</label>
                    <input type="password" name="password" value="{{ old('password') }}" class="w-full p-2 rounded border border-grey-light text-grey-darker" required autofocus>
                    @if ($errors->has('password'))
                        <div class="mt-2 text-sm text-red-light">
                            {{ $errors->first('password') }}
                        </div>
                    @endif
                </div>
                <label>
                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember me
                </label>
            </div>
            <div class="flex my-10">
                <div class="w-1/2 px-4">
                    <a href="{{ route('password.request') }}" class="no-underline block w-full px-3 py-3 rounded-full border-2 border-grey text-grey-darker text-center">Forgot your password?</a>
                </div>
                <div class="w-1/2 px-4">
                    <button type="submit" class="block w-full px-3 py-3 rounded-full text-grey-lightest bg-orange border-2 border-orange hover:bg-orange-light hover:border-orange-light">Login</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
