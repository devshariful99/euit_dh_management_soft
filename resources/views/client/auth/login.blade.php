@extends('client.layouts.app', ['pageSlug' => 'al'])
@section('title', 'Client Login')
@push('css')
    <link rel="stylesheet" href="{{ asset('admin/css/admin_login.css') }}">
@endpush
@section('content')
    <div class="overlay py-5">
        <form method="post" action="{{ route('client.login') }}">
            @csrf
            <div class="con">
                <header class="head-form">
                    <h2>{{ __('Log In') }}</h2>
                    <p>{{ __('Login here using your email and password') }}</p>
                </header>
                <br>
                <div class="field-set">
                    <div class="input-group">
                        <span class="input-item">
                            <i class="fa-regular fa-envelope"></i>
                        </span>
                        <input class="form-input" name="email" id="txt-input" type="text" placeholder="email" required>
                        @error('email')
                            <br>
                            <span class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <br>
                    <div class="input-group">
                        <span class="input-item">
                            <i class="fa fa-key"></i>
                        </span>
                        <input class="form-input" type="password" placeholder="Password" id="pwd" name="password"
                            required>
                        <span>
                            <i class="fa fa-eye" aria-hidden="true" type="button" id="eye"></i>
                        </span>
                        @error('password')
                            <br>
                            <span class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>


                    <br>

                    <button class="log-in" type="submit"> {{ __('Log In') }} </button>
                </div>
            </div>
        </form>
    </div>
@endsection
@push('js')
    <script>
        function show() {
            var p = document.getElementById('pwd');
            p.setAttribute('type', 'text');
        }

        function hide() {
            var p = document.getElementById('pwd');
            p.setAttribute('type', 'password');
        }

        var pwShown = 0;

        document.getElementById("eye").addEventListener("click", function() {
            if (pwShown == 0) {
                pwShown = 1;
                show();
            } else {
                pwShown = 0;
                hide();
            }
        }, false);
    </script>
@endpush
