    <input type="hidden" name="MAX_FILE_SIZE" value="41943040" />
    <div class="form-group">
        {!! Form::label('name', '名前:') !!}
        {!! Form::text('name', '名前を入力してください。',['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('body', '本文:') !!}
        {!! Form::textarea('body', '本文を入力してください。',['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('password', 'パスワード:') !!}
        {!! Form::text('password', null,['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('files', 'ファイルアップロード') !!}
        {!! Form::file('files[]', null,['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('posted_at', '公開日:') !!}
        {!! Form::input('date', 'posted_at', $posted_at, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::submit($submitButton,['class' => 'btn btn-primary form-control']) !!}
    </div>