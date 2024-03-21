@extends('layouts.master-without-nav')

@section('title')
    PIN PAD
@endsection

@section('css')
    <style>
        .code-input {
            width: 60px;
            height: 70px;
            font-size: 24px;
            text-align: center;
            margin: 5px;
            border: 2px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
    </style>
@endsection

@section('body')

    <body>
    @endsection

    @section('content')

        <div class="account-pages my-5 pt-sm-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card overflow-hidden">
                            <div class="bg-primary-subtle">
                                <div class="row">
                                    <div class="col-7">
                                        <div class="text-primary p-4">
                                            <h5 class="text-primary">Inicio de Sesión </h5>
                                            <p> Ingresa tu PIN para poder continuar </p>
                                        </div>
                                    </div>
                                    <div class="col-5 align-self-end">
                                        <img src="{{ URL::asset('build/images/profile-img.png') }}" alt="" class="img-fluid">
                                    </div>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <div>
                                    <a href="index">
                                        <div class="avatar-md profile-user-wid mb-4">
                                            <span class="avatar-title rounded-circle bg-light">
                                                <img src="{{ URL::asset('build/images/logo.svg') }}" alt="" class="rounded-circle" height="34">
                                            </span>
                                        </div>
                                    </a>
                                </div>
                                <div class="p-2">
                                    <form method="POST" action="{{ route('login.pin') }}">
                                        @csrf

                                        <div class="mb-3" align="center">
                                            <input type="password" name="digit1" class="code-input" maxlength="1" required>
                                            <input type="password" name="digit2" class="code-input" maxlength="1" required>
                                            <input type="password" name="digit3" class="code-input" maxlength="1" required>
                                            <input type="password" name="digit4" class="code-input" maxlength="1" required>
                                        </div>

                                        {{--  <div class="text-center">
                                            <button class="btn btn-primary w-md waves-effect waves-light"
                                                type="submit"> Ingresar </button>
                                        </div>  --}}
                                        <div class="mt-3 d-grid">
                                            <button class="btn btn-primary waves-effect waves-light" type="submit"> Ingresar </button>
                                        </div>

                                    </form>
                                </div>

                            </div>
                        </div>
                        <div class="mt-5 text-center">
                            <p>© <script> document.write(new Date().getFullYear()) </script>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    @endsection
