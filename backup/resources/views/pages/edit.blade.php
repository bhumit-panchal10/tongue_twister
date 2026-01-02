@extends('layouts.app')

@section('title', 'Edit Meta Data List')

@section('content')
    @foreach ($data as $pagedata)
        <div class="card mt-3">


            <div class="card-body">
                <div class="col-md-12 pt-5">
                    <div class="text-end mr-auto" style="width: 90px;    margin-left: auto;">
                        <a class="d-flex justify-content-end btn btn-outline-primary me-1 mb-1"
                            href="{{ route('pages.index') }}">Back
                        </a>
                    </div>
                </div>
                <form action="{{ route('pages.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ $pagedata->id }}"> 

                    <div class="row">
                        <div class="col-md-6 mt-2">
                            <div class="form-group {{ $errors->has('Name') ? 'has-error' : '' }} mb-2">

                                <label for="Name"><span style="color:red;">*</span>Page Name</label>

                                <input type="text" id="Name" name="Name" class="form-control"
                                    value="{{ old('Name', isset($pagedata) ? $pagedata->Name : '') }}" readonly>
                                @if ($errors->has('Name'))
                                    <em class="invalid-feedback">
                                        {{ $errors->first('Name') }}
                                    </em>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6 mt-2">

                            <div class="form-group {{ $errors->has('Title') ? 'has-error' : '' }} mb-2">

                                <label for="Title"><span style="color:red;">*</span>Page Title</label>

                                <input type="text" id="Title" name="Title" class="form-control"
                                    value="{{ old('Title', isset($pagedata) ? $pagedata->Title : '') }}" required>
                                @if ($errors->has('Title'))
                                    <em class="invalid-feedback">
                                        {{ $errors->first('Title') }}
                                    </em>
                                @endif
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-12 mt-2">
                            <div class="form-group {{ $errors->has('Description') ? 'has-error' : '' }} mb-2">
                                <label for="Description"><span style="color:red;">*</span>Meta Description</label>
                                <textarea id="Description" name="Description" rows="7" class="form-control ckeditor" required>{{ old('Description', isset($pagedata) ? $pagedata->Description : '') }}</textarea>
                                @if ($errors->has('Description'))
                                    <em class="invalid-feedback">
                                        {{ $errors->first('Description') }}
                                    </em>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer mt-3">
                        <button class="btn btn-outline-primary me-1 mb-1" type="submit">Update</button>
                    </div>
                </form>
            </div>
        </div>
    @endforeach
@endsection
@section('scripts')
    <script src="https://cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script>
@endsection
