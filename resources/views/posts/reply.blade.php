@extends('layout')

@section('content')

    <h1>返信フォーム</h1>

    <hr/>

    @include('errors.form_errors')

    {!! Form::open(array('action' => 'PostController@replyPost'), [$post->id]) !!}
        @include('form', ['posted_at' => date('Y-m-d'), 'submitButton' => '返信'])
    {!! Form::close() !!}
@endsection

