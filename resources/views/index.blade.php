<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>井上のBBS</title>
</head>
<body>
    <h1>井上のBBS</h1>
    @foreach($posts as $post)
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
</body>
</html>