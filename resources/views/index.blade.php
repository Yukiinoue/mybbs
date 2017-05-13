@extends('layout')

@section('content')
    <h1>井上のBBS</h1>
    @foreach($post_list as $post)
        <article>
            <h2>
                <a href="{{ url('posts', $post->id)}}">
                    {{ $post->name }}
                </a>
            </h2>
            <div class="body">
                {{ $post->body }}
            </div>
        </article>
    @endforeach
    {{ $post_list->appends(['sort' => 'votes'])->links() }}
@endsection