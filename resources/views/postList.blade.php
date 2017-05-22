@foreach($post_list as $post)
    <article class="post_box clearfix">
        <h2 class="name">
            {{ $post->name }}
        </h2>
        <div class="body">
            {{ $post->body }}
        </div>
        <br>
        <div class="posted_at">
            {{ $post->posted_at }}
        </div>
        <div class="btn-wrap">
            {!! link_to(action('BbsController@replyPage', [$post->id]), '返信', ['class' => 'btn btn-info']) !!}
        </div>
        <div class="btn-wrap">
            {!! link_to(action('BbsController@editPage', [$post->id]), '編集', ['class' => 'btn btn-primary']) !!}
        </div>
        <div class="btn-wrap">
            {!! delete_form(['/', $post->id]) !!}
        </div>
        <div class="btn-wrap">
            {!! link_to(action('BbsController@replyList', [$post->id]), 'この投稿の返信を見る', ['class' => 'btn btn-success']) !!}
        </div>
    </article>
@endforeach
