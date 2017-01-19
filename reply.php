<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>reply</title>
</head>
<body>
  <iframe src="reply.html" frameborder="0">
  <form action="index.php" method="post" accept-charset="utf-8">
    <div class="text-box form-group">
      <span class="form-item">名前</span>
      <input class="form-text form-control" type="text" name="name"><br>
    </div>  
    <div class="text-box form-group">
      <span class="form-item">本文</span><br>
      <textarea class="form-body" name="form_body" cols="68" rows="10"></textarea><br>
      <span class="post-btn">
        <input class="form-text" type="submit" name="form_post" value="投稿">
      </span>
    </div>
  </form>
  </iframe>
</body>
</html>