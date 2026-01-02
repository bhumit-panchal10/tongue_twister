@extends('layouts.app')

@section('title', 'Add Product')

@section('content')


<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">

            {{-- Alert Messages --}}
            @include('common.alert')

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Add Product</h4>
                        <div class="page-title-right">
                            <a href="{{ route('product.index') }}"
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
                                <form id="clear_form" method="POST" onsubmit="return validateFile()"
                                    action="{{ route('product.store') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row gy-4">

                                        <div class="col-lg-4 col-md-6">
                                            <div>
                                                <span style="color:red;">*</span>Category Name
                                                <select onchange="validatecategory();" class="form-control"
                                                    id="categoryId" data-choices
                                                    data-choices-removeItem name="categoryId[]" required multiple>
                                                    <option value="">Select Category Name </option>
                                                    @foreach ($Category as $category)
                                                    <option value="{{ $category->categoryId }}"
                                                        {{ old('categoryId') == $category->categoryId ? 'selected' : '' }}>
                                                        {{ $category->categoryname }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6">
                                            <div>
                                                <span style="color:red;">*</span>GST
                                                <select class="form-control"
                                                    id="iGST" name="iGST" required>
                                                    <option value="">Select GST</option>
                                                    <option value="5">5</option>
                                                    <option value="12">12</option>
                                                    <option value="18">18</option>
                                                    <option value="28">28</option>
                                                </select>
                                            </div>
                                        </div>

                                        <!--<div class="col-lg-4 col-md-6">-->
                                        <!--    <div>-->
                                        <!--        <span style="color:red;"></span>Sub Category Name-->
                                        <!--        <select class="form-control" name="subcategoryid" id="subcategoryid">-->
                                        <!--            <option value="" selected disabled>Select Sub Category-->
                                        <!--            </option>-->

                                        <!--        </select>-->
                                        <!--    </div>-->
                                        <!--</div>-->

                                        <div class="col-lg-4 col-md-6">
                                            <div>
                                                <span style="color:red;">*</span>Product Name
                                                <input type="text" class="form-control" placeholder="Enter  Name"
                                                    name="productname" autocomplete="off"
                                                    value="{{ old('productname') }}" maxlength="50" required>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-md-6">
                                            <div>
                                                <span style="color:red;">*</span>Slug Name
                                                <input type="text" class="form-control" placeholder="Enter Slug Name"
                                                    name="slugname" autocomplete="off" maxlength="50" value="{{ old('slugname') }}"
                                                    required>
                                            </div>
                                        </div>


                                        <div class="col-lg-4 col-md-6">
                                            <div>
                                                <span style="color:red;">*</span>Multiple Photo (Upto 5)
                                                <input type="file" class="form-control" name="photo[]" multiple
                                                    id="strPhoto" required>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-6">
                                            <div>
                                                <span style="color:red;">*</span>Rate
                                                <input type="text" class="form-control" placeholder="Enter Rate"
                                                    onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"
                                                    maxlength="5" name="rate" autocomplete="off"
                                                    value="{{ old('rate') }}" required>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-6">
                                            <div>
                                                <span style="color:red;">*</span>Weight
                                                <input type="text" class="form-control" placeholder="Enter Weight"
                                                    name="weight" maxlength="5" autocomplete="off" value="{{ old('weight') }}"
                                                    required>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-6">
                                            <div class="mt-4">
                                                <input type="checkbox" name="isFeatures" id="isFeatures"> Is Features
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <input class="" type="checkbox" name="isTaxable" id="isTaxable">
                                                Is Taxable
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-6">
                                            <div>
                                                <span style="color:red;">*</span>Stock Status</label>
                                                <select class="form-control" name="isStock" id="isStock" required>
                                                    {{-- <option value="">Select Stock Status</option>  --}}
                                                    <option selected value="1">In Stock</option>
                                                    <option value="0">Out Of Stock</option>
                                                </select>
                                                @error('isStatus')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-lg-12 col-md-6">
                                            <span style="color:red;"></span>Description</label>
                                            <textarea class="form-control ckeditor" name="description" id="description" rows="6"></textarea>
                                            @error('description')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-lg-12 col-md-6">
                                            <span style="color:red;"></span>Meta Title</label>
                                            <input type="text" class="form-control" name="meta_title" id="meta_title" />
                                        </div>

                                        <div class="col-lg-6 col-md-6">
                                            <span style="color:red;"></span>Meta Keyword</label>
                                            <textarea class="form-control" name="meta_keyword" id="meta_keyword" rows="6"></textarea>
                                        </div>

                                        <div class="col-lg-6 col-md-6">
                                            <span style="color:red;"></span>Meta Description</label>
                                            <textarea class="form-control" name="meta_description" id="meta_description" rows="6"></textarea>
                                        </div>

                                        <div class="col-lg-6 col-md-6">
                                            <span style="color:red;"></span>Head</label>
                                            <textarea class="form-control" name="head" id="head" rows="6"></textarea>
                                        </div>

                                        <div class="col-lg-6 col-md-6">
                                            <span style="color:red;"></span>Body</label>
                                            <textarea class="form-control" name="body" id="body" rows="6"></textarea>
                                        </div>


                                    </div>
                                    <div class="card-footer mt-5" style="float: right;">
                                        <button type="submit"
                                            class="btn btn-primary btn-user float-right mb-3 mx-2">Save</button>
                                        <button class="btn btn-primary float-right mr-3 mb-3 mx-2 cancel">Clear</button>
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
    $(document).ready(function() {

        $(".cancel").on("click", function() {
            $("#clear_form").trigger("reset");
            CKEDITOR.instances['description'].setData('');
            // $("#description").html("");
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

<script>
    function validatecategory() {
        // var Category = $('#categoryId').val();
        // var url = "{{ route('product.getsubcategory') }}";
        // $.ajax({
        //     url: url,
        //     type: 'GET',
        //     data: {
        //         Category,
        //         Category
        //     },
        //     success: function(data) {
        //         console.log(data);
        //         $("#subcategoryid").html(data);
        //     }
        // });
        getGST();
    }

    function getGST() {
        var Category = $('#categoryId').val();

        var url = "{{ route('product.getGST') }}";
        $.ajax({
            url: url,
            type: 'GET',
            data: {
                Category,
                Category
            },
            success: function(data) {
                console.log(data);
                $("#iGST").val(data);
            }
        });
    }
</script>

@endsection