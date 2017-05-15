@extends('layout')

@section('content')
    <h1>井上のBBS</h1>
    @include('form',['type' => 'create'])
    @foreach($post_list as $post)
        <article class=post_box>
            <h2 class="name">
                {{ $post->name }}
            </h2>
            <div class="body">
                {{ $post->body }}
            </div>
            <div class="edit_btn"></div>
        </article>
    @endforeach
    {{ $post_list->appends(['sort' => 'votes'])->links() }}
@endsection