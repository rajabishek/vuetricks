@extends('layouts.app')

@section('content')

<!-- Header -->
@include('partials._header')
<!-- END Header -->

<div class="container">
    <div class="row">
        <div class="col-md-8">
            @include('partials._banner')
        </div>
        <div class="col-md-4">
            <div class="row">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <h3 class="panel-title">Sign Up</h3>
                    </div>
                    <div class="panel-body">
                        <form role="form" method="POST" action="{{ route('auth.getRegister') }}">
                            <fieldset>
                                {!! csrf_field() !!}

                                <div class="form-group {{set_error('username', $errors)}}">
                                    <label for="username">Username</label>
                                    <input type="text" class="form-control input-sm" name="username" value="{{ old('username') }}" id="name">
                                    {!! get_error('username', $errors) !!}
                                </div>

                                <div class="form-group {{set_error('email', $errors)}}">
                                    <label for="email">Email-Address</label>
                                    <input type="email" class="form-control input-sm" name="email" value="{{ old('email') }}" id="email">
                                    {!! get_error('email', $errors) !!}
                                </div>

                                <div class="form-group {{set_error('password', $errors)}}">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control input-sm" name="password">
                                    {!! get_error('password', $errors) !!}
                                </div>

                                <div class="form-group {{set_error('password_confirmation', $errors)}}">
                                    <label for="password_confirmation">Confirm Password</label>
                                    <input type="password" class="form-control input-sm" name="password_confirmation">
                                    {!! get_error('password_confirmation', $errors) !!}
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-sm btn-success">Register</button>
                                    <a class="btn btn-sm btn-info" href="{{ route('auth.github') }}">Register with Github</a>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
