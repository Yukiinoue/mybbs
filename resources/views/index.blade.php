@extends('layout')

@section('content')
    <h1>井上のBBS</h1>
    @include('errors.form_errors')
    {!! Form::open(array('action' => 'PostController@create')) !!}
        @include('form',['posted_at' => date('Y-m-d'), 'submitButton' => '新規投稿'])
    {!! Form::close() !!}
    @foreach($post_list as $post)
        <article class=post_box>
            <h2 class="name">
                {{ $post->name }}
            </h2>
            <div class="body">
                {{ $post->body }}
            </div>
            {!! link_to(action('BbsController@replyPage', [$post->id]), '返信', ['class' => 'btn btn-info']) !!}
            {!! link_to(action('BbsController@editPage', [$post->id]), '編集', ['class' => 'btn btn-primary']) !!}

            <br/>
            <br/>

            {!! delete_form(['/', $post->id]) !!}
        </article>
    @endforeach
    {{ $post_list->appends(['sort' => 'votes'])->links() }}
@endsection