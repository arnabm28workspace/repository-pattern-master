@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
    <div class="app-title">
        <div>
            <h1><i class="fa fa-tags"></i> {{ $pageTitle }}</h1>
        </div>
    </div>
    @include('admin.partials.flash')
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="tile">
                <h3 class="tile-title">{{ $subTitle }}</h3>
                <form action="{{ route('admin.blogs.update') }}" method="POST" role="form" enctype="multipart/form-data">
                    @csrf
                    <div class="tile-body">
                        <div class="form-group" id="category_type">
                          <label>Category Type<span style="color:red; font-size:55%">★</span></label>
                          <select name="category_type" class="form-control" style="width: 100%;">
                            @foreach($categorytypes as $categorytype)
                                <?php 
                                if($targetBlog->category_id == $categorytype->id)
                                { ?>
                                <option value="{{$categorytype->id}}" selected>{{$categorytype->name}}</option>
                                <?php 
                                }else{
                                ?>
                                <option value="{{$categorytype->id}}">{{$categorytype->name}}</option>
                                <?php 
                                }
                                ?>
                            @endforeach
                          </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="name">Blog Title <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" id="name" value="{{ old('name', $targetBlog->blog_title) }}"/>
                            <input type="hidden" name="id" value="{{ $targetBlog->id }}">
                            @error('name') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="description">Description</label>
                            <textarea class="form-control" rows="4" name="description" id="description">{{ old('description', $targetBlog->blog_description) }}</textarea>
                            <input name="image" type="file" id="upload" onchange="" hidden>
                        </div>
                        <div class="form-group">
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" id="status" name="status"
                                    {{ $targetBlog->status == 1 ? 'checked' : '' }}
                                    />Publish
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-2">
                                    @if ($targetBlog->image != null)
                                        <figure class="mt-2" style="width: 80px; height: auto;">
                                            <img src="{{ asset('storage/'.$targetBlog->image) }}" id="blogImage" class="img-fluid" alt="img">
                                        </figure>
                                    @endif
                                </div>
                                <div class="col-md-10">
                                    <label class="control-label">Blog Image</label>
                                    <input class="form-control @error('image') is-invalid @enderror" type="file" id="image" name="image"/>
                                    @error('image') {{ $message }} @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tile-footer">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update Blog</button>
                        &nbsp;&nbsp;&nbsp;
                        <a class="btn btn-secondary" href="{{ route('admin.blogs.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection