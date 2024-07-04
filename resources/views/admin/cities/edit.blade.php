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
                <form action="{{ route('admin.cities.update') }}" method="POST" role="form" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ $city->id }}">
                    <div class="form-group">
                        <label class="control-label" for="name">Country <span class="m-l-5 text-danger"> *</span></label>
                        <select class="form-control @error('country_id') is-invalid @enderror" name="country_id" id="country_id">
                        @if(count($countries))
                        @foreach($countries as $country)
                        <option value="{{$country->id}}" <?php if($country->id==$city->country_id){ echo "selected";} ?>>{{$country->name}}</option>
                        @endforeach
                        @endif
                        </select>
                        @error('country_id') {{ $message }} @enderror
                    </div>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="name">Name <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" id="name" value="{{ old('name', $city->name) }}"/>
                            
                            @error('name') {{ $message }} @enderror
                        </div>
                        
                    </div>
                    <div class="tile-footer">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update City</button>
                        &nbsp;&nbsp;&nbsp;
                        <a class="btn btn-secondary" href="{{ route('admin.country.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection