@extends('layouts.app')

@section('title', 'Add Blog')

@section('content')

    <style>
        .error {
            color: red
        }
    </style>

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                {{-- Alert Messages --}}
                @include('common.alert')

                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0">Add Blog</h4>
                            <div class="page-title-right">
                                <a href="{{ route('blog.index') }}"
                                    class="d-none d-sm-inline-block btn btn-sm btn btn-success shadow-sm">
                                    <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="live-preview">
                                    <form method="POST" id="myForm" onsubmit="return validateFile()"
                                        action="{{ route('blog.store') }}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row gy-4">

                                            <div class="col-lg-8 col-md-6">
                                                <div>
                                                    <span style="color:red;">*</span>Title
                                                    <input type="text" class="form-control" maxlength="250"
                                                        placeholder="Enter Title" name="strTitle" id="strTitle"
                                                        autocomplete="off" value="{{ old('strTitle') }}" required>
                                                    @error('strTitle')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>


                                            <div class="col-lg-4 col-md-6">
                                                <div>
                                                    <span style="color:red;">*</span>Photo
                                                    <input type="file" class="form-control" name="strPhoto"
                                                        id="strPhoto" required accept="image/*">
                                                </div>
                                                <div id="viewimg">
                                                    @error('strPhoto')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-lg-12 col-md-6">
                                                <span style="color:red;">*</span>Description</label>
                                                <textarea class="form-control ckeditor" name="strDescription" id="description" rows="6"></textarea>
                                                @error('strDescription')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="col-lg-6 col-md-6">
                                                <div>
                                                    <span style="color:red;"></span>Meta Title
                                                    <textarea class="form-control" name="metaTitle" id="metaTitle" rows="4"></textarea>

                                                    @error('metaTitle')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-lg-6 col-md-6">
                                                <div>
                                                    <span style="color:red;"></span>Meta Keyword
                                                    <textarea class="form-control" name="metaKeyword" id="metaKeyword" rows="4"></textarea>

                                                    @error('metaKeyword')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-lg-12 col-md-6">
                                                <div>
                                                    <span style="color:red;"></span>Meta Description
                                                    <textarea class="form-control" name="metaDescription" id="metaDescription" rows="4"></textarea>

                                                    @error('metaDescription')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-lg-6 col-md-6">
                                                <div>
                                                    <span style="color:red;"></span>Head
                                                    <textarea class="form-control" name="head" id="head" rows="4"></textarea>

                                                    @error('head')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>


                                            <div class="col-lg-6 col-md-6">
                                                <div>
                                                    <span style="color:red;"></span>Body
                                                    <textarea class="form-control" name="body" id="body" rows="4"></textarea>

                                                    @error('body')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                        </div>
                                        <div class="card-footer mt-5" style="float: right;">
                                            <button type="submit"
                                                class="btn btn-success btn-user float-right mb-3">Save</button>
                                            <a class="btn btn-success float-right mr-3 mb-3"
                                                href="{{ route('blog.index') }}">Cancel</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('scripts')

    <script src="https://cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script>

    <script>
        function validateFile() {
            var allowedExtension = ['jpeg', 'jpg', 'png', 'webp'];
            var fileExtension = document.getElementById('strPhoto').value.split('.').pop().toLowerCase();

            var isValidFile = false;

            for (var index in allowedExtension) {

                if (fileExtension === allowedExtension[index]) {
                    isValidFile = true;
                    break;
                }
            }

            if (!isValidFile) {
                alert('Allowed Extensions are : *.' + allowedExtension.join(', *.'));
            }

            return isValidFile;
        }
    </script>

    {{-- Add photo --}}

    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#hello').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#strPhoto").change(function() {
            html =
                '<img src="' + readURL(this) +
                '"   id="hello" width="70px" height = "70px" > ';
            $('#viewimg').html(html);

        });
    </script>

    
@endsection
