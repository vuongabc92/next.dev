@extends('backend::layouts._layout')

@section('body')
    <div class="_fwfl title-wrap">
        <h3 class="page-title">Privacy</h3>
    </div>
    
    <div class="_fwfl _mt20">
        {!! Form::open(['route' => 'back_page_saveprivacy', 'method' => 'post']) !!}
            @if (session('success'))
                <div class="form-group">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        {{ session('success') }}
                    </div>
                </div>
            @endif
            <div class="form-group">
                {!! Form::text('name', $privacy->name, ['class' => 'form-control', 'placeholder' => 'Page name']) !!}
            </div>
            <div class="form-group">
                {!! Form::text('slug', $slug, ['class' => 'form-control', 'placeholder' => 'Page slug', 'disabled' => '']) !!}
                <small class="form-text text-muted">Page slug will be used as page id when render on front page.</small>
            </div>
            <div class="form-group">
                <textarea name="content" class="form-control">{{ $privacy->content }}</textarea>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-secondary">Save</button>
            </div>
        {!! Form::close() !!}
    </div>
@stop

@section('script')
    <script type="text/javascript" src="{{ asset('packages/king/backend/tinymce/tinymce.min.js') }}"></script>
    <script>
        tinymce.init({
            selector: 'textarea',
            height: 150,
            plugins: 'print preview code searchreplace autolink directionality visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists textcolor wordcount imagetools contextmenu colorpicker textpattern help',
            toolbar1: 'formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify | numlist bullist outdent indent | removeformat | code',
            image_advtab: true,
            content_css: [
              '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
              '//www.tinymce.com/css/codepen.min.css'
            ]
       });//powerpaste advcode mediaembed tinymcespellchecker a11ychecker linkchecker
    </script>
@stop