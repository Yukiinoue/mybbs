@extends('layout')

@section('content')

    <h1>返信フォーム</h1>

    <hr/>

    @include('errors.form_errors')

    {!! Form::open(array('action' => 'PostController@replyCreate', 'files' => true)) !!}
        @include('form', ['posted_at' => date('Y-m-d'), 'submitButton' => '返信'])
        <input type="hidden" name="id" value="{{$post->id}}">
    {!! Form::close() !!}
@endsection

