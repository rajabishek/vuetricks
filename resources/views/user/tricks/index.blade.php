@extends('layouts.app')

@section('content')

<!-- Header -->
@include('partials._header')
<!-- END Header -->

<div class="container">

    @include('partials._successmessage')

    <div class="row push-down">
        <div class="col-lg-8 col-md-6 col-sm-6 col-xs-12">
            <h1 class="page-title">My Tricks</h1>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 text-right">
            <a href="{{ route('user.tricks.create')}}" class="btn btn-sm btn-success"><span class="glyphicon glyphicon-plus"></span> Create New</a>
        </div>
    </div>

    @include('partials.tricks._grid', compact('tricks'))    
</div>
@endsection
