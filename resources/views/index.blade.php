@extends('layout')

@section('content')
    <h1>井上のBBS</h1>
    @include('errors.form_errors')
    {!! Form::open(array('action' => 'PostController@create', 'files' => true)) !!}
        @include('form',['posted_at' => date('Y-m-d'), 'submitButton' => '新規投稿'])
    {!! Form::close() !!}

    @include('postList')

    {{ $post_list->appends(['sort' => 'votes'])->links() }}

@endsection