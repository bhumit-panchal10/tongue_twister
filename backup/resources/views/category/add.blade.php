@extends('layouts.app')

@section('title', 'Add Category')

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
                            <h4 class="mb-sm-0">Add Category</h4>
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
                                    <form id="form_clear" method="POST" onsubmit="return validateFile()"
                                        action="{{ route('category.store') }}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row gy-4">

                                            <div class="col-lg-4 col-md-6">
                                                <div>
                                                    <span style="color:red;">*</span>Parent Name
                                                    <input type="text" class="form-control"
                                                        placeholder="Enter Parent Name" name="categoryname"
                                                        autocomplete="off" value="{{ old('categoryname') }}" maxlength="50" required>
                                                </div>
                                            </div>

                                            <div class="col-lg-4 col-md-6">
                                                <div>
                                                    <span style="color:red;"></span> Category
                                                    <select class="form-control" name="subcategoryid">
                                                        <option selected disabled value="">Select Category Name
                                                        </option>
                                                        @foreach ($Category as $category)
                                                            <option value="{{ $category->categoryId }}"
                                                                {{ old('subcategoryid') == $category->categoryId ? 'selected' : '' }}>
                                                                {{ $category->categoryname }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>


                                            <div class="col-lg-4 col-md-6">
                                                <div>
                                                    <span style="color:red;">*</span>Photo
                                                    <input type="file" class="form-control" name="photo" id="strPhoto"
                                                        required>
                                                </div>
                                                <div id="viewimg">
                                                    @error('photo')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-lg-4 col-md-6">
                                                <div>
                                                    <span style="color:red;">*</span>Slug Name
                                                    <input type="text" class="form-control"
                                                        placeholder="Enter Slug Name" name="slugname" autocomplete="off"
                                                        value="{{ old('slugname') }}" maxlength="50" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-6">
                                                <div>
                                                    <span style="color:red;">*</span>GST
                                                    <input type="text" maxlength="2" class="form-control" placeholder="Enter GST" name="strGST" autocomplete="off" value="{{ old('strGST') }}" required>
                                                </div>
                                            </div>
                                            
                                            <div class="col-lg-4 col-md-6">
                                                <div>
                                                    <span style="color:red;">*</span>Sequence No.
                                                    <input type="text" class="form-control" maxlength="10" minlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');" placeholder="Enter Sequence No." name="strSequence" autocomplete="off" value="{{ old('strSequence') }}" required>
                                                </div>
                                            </div>

                                            <div class="col-lg-6 col-md-6">
                                                <span style="color:red;"></span>Meta Title</label>
                                                <textarea class="form-control" name="meta_title" id="meta_title" rows="6"></textarea>

                                            </div>

                                            <div class="col-lg-6 col-md-6">
                                                <span style="color:red;"></span>Meta Description</label>
                                                <textarea class="form-control" name="meta_description" id="meta_description" rows="6"></textarea>
                                            </div>


                                        </div>
                                        <div class="card-footer mt-5" style="float: right;">
                                            <button type="submit"
                                                class="btn btn-primary btn-user float-right mb-3 mx-2">Save
                                            </button>
                                            <button class="btn btn-primary float-right mr-3 mb-3 mx-2 cancel">Clear
                                            </button>
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
    $(document).ready(function(){
        $(".cancel").on("click",function(){
            $("#form_clear").trigger("reset");
            $("#viewimg").html("");
        });
    });
</script>

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
