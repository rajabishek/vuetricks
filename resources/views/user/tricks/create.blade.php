@extends('layouts.app')

@section('content')

<!-- Header -->
@include('partials._header')
<!-- END Header -->

@section('styles')
@parent
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.1/css/selectize.bootstrap3.min.css">
<style type="text/css">
    #editor-content {
        position: relative;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        height: 300px;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        border-radius: 4px;
        border: 1px solid #cccccc;
    }
</style>
@endsection

@section('scripts')
    @parent
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.2.2/ace.js">
    </script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.2.2/mode-javascript.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.2.2/theme-github.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.1/js/standalone/selectize.min.js"></script>
    <script type="text/javascript">
        (function($){
            
            $("#tags").selectize({maxItems:5});
            $("#categories").selectize({maxItems:5});

            var editor = ace.edit("editor-content");
            var code = $("#code-editor");
            
            editor.setTheme("ace/theme/github");        
            var JavaScriptMode = ace.require("ace/mode/javascript").Mode;
            editor.session.setMode(new JavaScriptMode());
            editor.session.setValue(code.val());
            code.closest("form").submit(function() { 
                code.val(editor.getSession().getValue());
            });

        })(jQuery);
    </script>
@endsection

<div class="container">
    <div class="row">
        <div class="col-lg-8 col-lg-push-2 col-md-8 col-md-push-2 col-sm-12 col-xs-12">
            <div class="content-box">
                <h1 class="page-title">Create a new trick</h1>
                @include('partials._errormessages')
                {!! Form::open(['route'=>'user.tricks.store','class'=>'form-vertical','role'=>'form']) !!}
                    <div class="form-group">
                        <label for="title">Title</label>
                        {!! Form::text('title',null,['class'=>'form-control input-sm','placeholder'=>'Name this trick']) !!}
                    </div>
                    <div class="form-group">
                        <label for='description'>Description</label>
                        {!! Form::textarea('description',null,['class'=>'form-control input-sm','placeholder'=>'Give a detailed description of the trick','rows'=>'3']) !!}
                    </div>
                    <div class="form-group">
                        <label>Trick Code</label>
                        <div id="editor-content" class="content-editor"></div>
                        {!! Form::textarea('code',null,['id'=>'code-editor','style'=>'display:none;']) !!}
                    </div>
                    <div class="form-group">
                        <p>{!! Form::select('tags[]',$tagList,null,['multiple','id'=>'tags','class'=>'form-control']) !!}</p>
                    </div>
                    <div class="form-group">
                        <p>{!! Form::select('categories[]',$categoryList,null,['multiple','id'=>'categories','class'=>'form-control']) !!}</p>
                    </div>
                    <div class="form-group">
                        <div class="text-right">
                          <button type="submit" class="btn btn-sm btn-primary">Save Trick</button>
                        </div>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
