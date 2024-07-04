@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
    <div class="app-title">
        <div>
            <h1><i class="fa fa-cogs"></i> {{ $pageTitle }}</h1>
        </div>
    </div>
    @include('admin.partials.flash')
    <div class="row user">
        <!-- <div class="col-md-3">
            <div class="tile p-0">
                <ul class="nav flex-column nav-tabs user-tabs">
                    <li class="nav-item"><a class="nav-link active" href="#general" data-toggle="tab">General</a></li>
                </ul>
            </div>
        </div> -->
        <div class="col-md-8 mx-auto">
            <div class="tab-content">
                <div class="tab-pane active" id="general">
                    <div class="tile">
                        <form action="{{ route('admin.attribute.update') }}" method="POST" role="form">

                            @csrf
                            <input type="hidden" name="id" value="{{ $attribute->id }}">
                             <h3 class="tile-title">{{ $subTitle }}</h3>
                            <hr>
                            <div class="tile-body">
                                <div class="form-group">
                                    <label class="control-label" for="code">Label</label>
                                    <input
                                        class="form-control"
                                        type="text"
                                        placeholder="Enter attribute label"
                                        id="label"
                                        name="label"
                                        value="{{ old('name', $attribute->label) }}"
                                    />
                                    @error('label') {{ $message ?? '' }} @enderror
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="name">Name</label>
                                    <input
                                        class="form-control"
                                        type="text"
                                        placeholder="Enter attribute name"
                                        id="colname"
                                        name="colname"
                                        value="{{ old('name', $attribute->colname) }}"
                                    />
                                    @error('colname') {{ $message ?? '' }} @enderror
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="field_type">Frontend Type</label>
                                    @php $types = ['select' => 'Select Box', 'radio' => 'Radio Button', 'text' => 'Text Field', 'text_area' => 'Text Area']; @endphp
                                    <select name="field_type" id="field_type" class="form-control">
                                        @foreach($types as $key => $label)
                                            <option value="{{ $key }}" <?php if($attribute->field_type==$key){ echo "selected";} ?>>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    @error('field_type') {{ $message ?? '' }} @enderror
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="name">Values</label>
                                    <input
                                        class="form-control"
                                        type="text"
                                        placeholder="Enter attribute Values"
                                        id="popup_vals"
                                        name="popup_vals"
                                        value="{{ old('name', $attribute->popup_vals) }}"
                                    />
                                </div>
                                <div class="form-group">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="checkbox" id="is_filterable" name="is_filterable" <?php if($attribute->is_filterable==1){ echo "checked";}?> />Filterable
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="checkbox" id="is_required" name="is_required" <?php if($attribute->is_required==1){ echo "checked";} ?> />Required
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="tile-footer">
                                <div class="row d-print-none mt-2">
                                    <div class="col-12 text-right">
                                        <button class="btn btn-success" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update Attribute</button>
                                        <a class="btn btn-danger" href="{{ route('admin.attribute.index') }}"><i class="fa fa-fw fa-lg fa-arrow-left"></i>Go Back</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection