@extends('layout')

@section('content')

    <h1>投稿編集画面</h1>

    <hr/>

@include('errors.form_errors')

    {!! Form::model($post, ['method' => 'PATCH', 'url' => ['/', $post->id], 'files' => true]) !!}
        @include('form', ['posted_at' => $post->posted_at->format('Y-m-d'), 'submitButton' => '編集'])
    {!! Form::close() !!}
@endsection
