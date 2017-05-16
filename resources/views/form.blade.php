    <div class="form-group">
        {!! Form::label('name', '名前:') !!}
        {!! Form::text('name', null,['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('body', '本文:') !!}
        {!! Form::textarea('body', null,['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('password', 'パスワード:') !!}
        {!! Form::text('password', null,['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('posted_at', '投稿日:') !!}
        {!! Form::input('date', 'posted_at', $posted_at, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::submit($submitButton,['class' => 'btn btn-primary form-control']) !!}
    </div>