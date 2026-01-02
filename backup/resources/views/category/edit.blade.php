@extends('layouts.app')

@section('title', 'Edit Category')

@section('content')

    <script src="https://cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script>

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                {{-- Alert Messages --}}
                @include('common.alert')

                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0">Edit Category</h4>
                            <div class="page-title-right">
                                <a href="{{ route('category.index') }}"
                                    class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                                    Back
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
                                    <form method="POST" onsubmit="return validateFile()"
                                        action="{{ route('category.update', $data->categoryId) }}"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="row gy-4">

                                            <div class="col-lg-4 col-md-6">
                                                <div>
                                                    <span style="color:red;">*</span>Category Name
                                                    <input type="text" class="form-control" placeholder="Enter Name"
                                                        name="categoryname" autocomplete="off"
                                                        value="{{ $data->categoryname }}" maxlength="50" required>
                                                </div>
                                            </div>

                                            <div class="col-lg-4 col-md-6">
                                                <div>
                                                    <span style="color:red;"></span>Sub Category
                                                    <select class="form-control" name="subcategoryid">
                                                        <option selected disabled value="">Select Category Name
                                                        </option>
                                                        @foreach ($Category as $category)
                                                            <option value="{{ $category->categoryId }}"
                                                                {{ $data->subcategoryid == $category->categoryId ? 'selected' : '' }}>
                                                                {{ $category->categoryname }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>


                                            <div class="col-lg-4 col-md-6">
                                                <div>
                                                    <span style="color:red;">*</span>Photo
                                                    <input type="file" class="form-control" name="photo" id="strPhoto"
                                                        value="{{ $data->photo }}">
                                                    <input type="hidden" name="hiddenPhoto" class="form-control"
                                                        value="{{ old('photo') ? old('photo') : $data->photo }}"
                                                        id="hiddenPhoto">
                                                    <div id="viewimg">
                                                        <img src="{{ asset('Category') . '/' . $data->photo }}"
                                                            alt="" height="70" width="70">
                                                        @error('photo')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-4 col-md-6">
                                                <div>
                                                    <span style="color:red;">*</span>Slug Name
                                                    <input type="text" class="form-control"
                                                        placeholder="Enter Slug Name" name="slugname" autocomplete="off"
                                                        value="{{ $data->slugname }}" maxlength="50" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-6">
                                                <div>
                                                    <span style="color:red;">*</span>GST
                                                    <input type="text" maxlength="2" class="form-control" placeholder="Enter GST" name="strGST" autocomplete="off" value="{{ $data->strGST }}" required>
                                                </div>
                                            </div>
                                            
                                            <div class="col-lg-4 col-md-6">
                                                <div>
                                                    <span style="color:red;">*</span>Sequence No.
                                                    <input type="text" class="form-control" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');" placeholder="Enter Sequence No." name="strSequence" autocomplete="off" maxlength="10" value="{{ $data->strSequence }}" required>
                                                </div>
                                            </div>

                                            <div class="col-lg-6 col-md-6">
                                                <span style="color:red;"></span>Meta Title</label>
                                                <textarea class="form-control" name="meta_title" id="meta_title" rows="6">{{ $data->meta_title }}</textarea>

                                            </div>

                                            <div class="col-lg-6 col-md-6">
                                                <span style="color:red;"></span>Meta Description</label>
                                                <textarea class="form-control" name="meta_description" id="meta_description" rows="6">{{ $data->meta_description }}</textarea>
                                            </div>


                                        </div>
                                        <div class="card-footer mt-5" style="float: right;">
                                            <button type="submit"
                                                class="btn btn-primary btn-user float-right mb-3 mx-2">Update</button>
                                            <a class="btn btn-primary float-right mr-3 mb-3 mx-2"
                                                href="{{ route('category.index') }}">Cancel</a>
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

    <script>
        function validateFile() {
            var allowedExtension = ['jpeg', 'jpg', 'png', 'webp'];
            var fileExtension = document.getElementById('strPhoto').value.split('.').pop().toLowerCase();
            var isValidFile = false;
            var image = document.getElementById('strPhoto').value;

            for (var index in allowedExtension) {

                if (fileExtension === allowedExtension[index]) {
                    isValidFile = true;
                    break;
                }
            }
            if (image != "") {
                if (!isValidFile) {
                    alert('Allowed Extensions are : *.' + allowedExtension.join(', *.'));
                }
                return isValidFile;
            }

            return true;
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
