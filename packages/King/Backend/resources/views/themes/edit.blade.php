@extends('backend::layouts._layout')
@section('body')
    <div class="_fwfl title-wrap">
        <h3 class="page-title">Theme edit</h3>
    </div>
    
    <div class="_fwfl _mt20">
        <form action="#" method="post">
            <div class="form-group">
                <label for="themeName">Theme name</label>
                <input type="text" class="form-control" id="themeName" placeholder="Theme name">
            </div>
            <div class="form-group">
                <label for="themeSlug">Theme slug</label>
                <input type="text" class="form-control" id="themeSlug" placeholder="Theme slug">
            </div>
            <div class="form-group">
                <label for="themeSlug">Thumbnail</label>
                <label class="custom-file">
                    <input type="file" id="file" class="custom-file-input" required>
                    <span class="custom-file-control"></span>
                </label>
            </div>
            <div class="form-group">
                <label for="themeSlug">Theme slug</label>
                <input type="text" class="form-control" id="themeSlug" placeholder="Theme slug">
            </div>
            
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@stop