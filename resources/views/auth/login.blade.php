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
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">Sign In</h3>
                        <a href="{{ url('/password/reset') }}" style="color:white; float:right; font-size: 85%; position: relative; top:-18px">Forgot Your Password?</a>
                    </div>
                    <div class="panel-body">
                        <form role="form" method="POST" action="{{ route('auth.getLogin') }}">
                            <fieldset>
                                {!! csrf_field() !!}
                                <div class="form-group {{set_error('username', $errors)}}">
                                    <label for="username">Username</label>
                                    <input type="text" class="form-control input-sm" name="username" value="{{ old('username') }}" id="username">
                                    {!! get_error('username', $errors) !!}
                                </div>
                                <div class="form-group {{set_error('password', $errors)}}">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control input-sm" name="password">
                                    {!! get_error('password', $errors) !!}
                                </div>
                                <div class="form-group">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="remember"> Remember Me
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-sm btn-success">Login</button>
                                    <a class="btn btn-sm btn-info" href="{{ route('auth.github') }}">Login with Github</a>
                                </div>
                                <hr style="margin-top:10px;margin-bottom:10px;">
                                <div class="form-group">
                                    <div style="font-size:85%">
                                        Don't have an account! 
                                        <a href="{{ route('auth.getRegister') }}">Sign Up</a>
                                    </div>
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
