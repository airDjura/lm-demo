@extends('layouts.auth')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 col-xl-5">
            <!-- Sign In Block -->
            <div class="block block-themed block-fx-shadow mb-0">
                <div class="block-header">
                    <h3 class="block-title">{{ __('Login') }}</h3>
                    <div class="block-options">
                        <a class="btn-block-option font-size-sm" href="{{ route('password.request') }}">Forgot password?</a>
                        <a class="btn-block-option"
                           href="{{ route('register') }}"
                           data-toggle="tooltip"
                           data-placement="left"
                           title="New Account">
                            <i class="fa fa-user-plus"></i>
                        </a>
                    </div>
                </div>
                <div class="block-content">
                    <div class="p-sm-3 px-lg-4 py-lg-5">
                        <h1 class="mb-2">{{ config('app.name') }}</h1>
                        <p>Welcome, please login.</p>

                        <!-- Sign In Form -->
                        <!-- jQuery Validation (.js-validation-signin class is initialized in js/pages/op_auth_signin.min.js which was auto compiled from _es6/pages/op_auth_signin.js) -->
                        <!-- For more info and examples you can check out https://github.com/jzaefferer/jquery-validation -->
                        <form class="js-validation-signin"
                              action="{{ route('login') }}"
                              method="POST">
                            @csrf
                            <div class="py-3">
                                <div class="form-group">
                                    <input id="email"
                                           type="email"
                                           placeholder="{{ __('Email') }}"
                                           class="form-control form-control form-control-alt form-control-lg {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                           name="email"
                                           value="{{ old('email') }}"
                                           required
                                           autofocus>
                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <input id="password"
                                           placeholder="{{ __('Password') }}"
                                           type="password"
                                           class="form-control form-control-alt form-control-lg {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                           name="password"
                                           required>

                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input class="custom-control-input"
                                               type="checkbox"
                                               name="remember"
                                               id="remember" {{ old('remember') ? 'checked' : '' }}>

                                        <label class="custom-control-label font-w400" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6 col-xl-5">
                                    <button type="submit" class="btn btn-block btn-primary">
                                        <i class="fa fa-fw fa-sign-in-alt mr-1"></i> {{ __('Login') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                        <!-- END Sign In Form -->
                    </div>
                </div>
            </div>
            <!-- END Sign In Block -->
        </div>
    </div>
@endsection
