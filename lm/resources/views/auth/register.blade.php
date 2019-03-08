@extends('layouts.auth')

@section('content')
    <div class="content">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <!-- Sign Up Block -->
                <div class="block block-themed block-fx-shadow mb-0">
                    <div class="block-header bg-success">
                        <h3 class="block-title">{{ __('Register') }}</h3>
                        <div class="block-options">
                            <a class="btn-block-option font-size-sm"
                               href="javascript:void(0)"
                               data-toggle="modal"
                               data-target="#one-signup-terms">View Terms</a>
                            <a class="btn-block-option"
                               href="{{route('login')}}"
                               data-toggle="tooltip"
                               data-placement="left"
                               title="Sign In">
                                <i class="fa fa-sign-in-alt"></i>
                            </a>
                        </div>
                    </div>
                    <div class="block-content">
                        <div class="p-sm-3 px-lg-4 py-lg-5">
                            <h1 class="mb-2">{{config('app.name')}}</h1>
                            <p>Please fill the following details to create a new account.</p>

                            <!-- Sign Up Form -->
                            <!-- jQuery Validation (.js-validation-signup class is initialized in js/pages/op_auth_signup.min.js which was auto compiled from _es6/pages/op_auth_signup.js) -->
                            <!-- For more info and examples you can check out https://github.com/jzaefferer/jquery-validation -->
                            <form class="js-validation-signup"
                                  action="{{ route('register') }}"
                                  method="POST">
                                @csrf

                                <div class="py-3">
                                    <div class="form-group">
                                        <input id="name"
                                               type="text"
                                               placeholder="{{ __('Name') }}"
                                               class="form-control form-control-lg form-control-alt {{ $errors->has('name') ? ' is-invalid' : '' }}"
                                               name="name"
                                               value="{{ old('name') }}"
                                               required
                                               autofocus>
                                        @if ($errors->has('name'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <input id="email"
                                               type="email"
                                               placeholder="{{ __('E-Mail Address') }}"
                                               class="form-control form-control-lg form-control-alt {{ $errors->has('email') ? ' is-invalid' : '' }}"
                                               name="email"
                                               value="{{ old('email') }}"
                                               required>

                                        @if ($errors->has('email'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <input id="password"
                                               type="password"
                                               class="form-control form-control-lg form-control-alt {{ $errors->has('password') ? ' is-invalid' : '' }}"
                                               name="password"
                                               placeholder="{{__('Password')}}"
                                               required>

                                        @if ($errors->has('password'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <input id="password-confirm"
                                               type="password"
                                               class="form-control form-control-lg form-control-alt"
                                               placeholder="{{ __('Confirm Password') }}"
                                               name="password_confirmation"
                                               required>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox"
                                                   class="custom-control-input"
                                                   id="signup-terms"
                                                   name="signup-terms">
                                            <label class="custom-control-label font-w400"
                                                   for="signup-terms">I agree to Terms &amp;
                                                Conditions</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-6 col-xl-5">
                                        <button type="submit" class="btn btn-block btn-success">
                                            <i class="fa fa-fw fa-plus mr-1"></i> {{ __('Register') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                            <!-- END Sign Up Form -->
                        </div>
                    </div>
                </div>
                <!-- END Sign Up Block -->
            </div>
        </div>
    </div>
@endsection
