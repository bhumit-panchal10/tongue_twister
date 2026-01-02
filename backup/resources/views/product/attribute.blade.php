@extends('layouts.app')
@section('title', 'Attribute List')
@section('content')

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                {{-- Alert Messages --}}
                @include('common.alert')

                @if ($errors->any())
                    {{--  <h5 style="color:red">Following errors exists in your excel file</h5>  --}}
                    <ol>
                        @foreach ($errors->all() as $error)
                            <p style="color:red">{{ $error }}</p>
                        @endforeach
                    </ol>
                @endif

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header" style="display: flex;justify-content: space-between;">
                                <h5 class="card-title mb-0">Add Product Attribute</h5>
                                <a href="#" data-bs-toggle="modal" title="Delete" data-bs-target="#AddModal"
                                    class="btn btn-sm btn-primary">
                                    <i data-feather="plus"></i> Add New
                                </a>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="modal fade flip" id="AddModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-light p-3">
                                <h5 class="modal-title" id="exampleModalLabel">Add Product Attribute</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                    id="close-modal"></button>
                            </div>
                            <form action="{{ route('product.product_attribute_store') }}" method="post"
                                onsubmit="return validateFile()" enctype="multipart/form-data">
                                @csrf

                                <div class="modal-body">

                                    <input type="hidden" name="productid" value="{{ $id }}">
                                    <div class="mb-3">
                                        <span style="color:red;">*</span>Attribute
                                        <select class="form-control" name="product_attribute_id" id="">
                                            <option value="">Select Attribute</option>
                                            @foreach ($Attribute as $attribute)
                                                <option value="{{ $attribute->id }}">{{ $attribute->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <span style="color:red;">*</span>Attribute Value
                                        <input type="text" class="form-control" name="product_attribute_weight"
                                            placeholder="Enter Attribute Value" maxlength="50" autocomplete="off" required>
                                    </div>

                                    <div class="mb-3">
                                        <span style="color:red;">*</span>Attribute Price
                                        <input type="text" class="form-control" name="product_attribute_price"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                            placeholder="Enter Attribute Price" maxlength="10" autocomplete="off" required>
                                    </div>

                                    <div class="mb-3">
                                        <span style="color:red;"></span>Attribute Photo
                                        <input class="form-control" type="file" name="product_attribute_photo"
                                            id="strPhoto">
                                        <div id="viewimg">

                                        </div>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <div class="hstack gap-2 justify-content-end">
                                        <button type="submit" class="btn btn-primary mx-2" id="add-btn">Submit
                                        </button>
                                        <button type="button" class="btn btn-primary mx-2" data-bs-dismiss="modal">Cancel
                                        </button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Product Name :- {{ $Product->productname }}</h5>
                            </div>
                            <div class="card-body">

                                <table id="scroll-horizontal" class="table nowrap align-middle" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">Product Attribute Name</th>
                                            <th scope="col">Product Attribute Photo</th>
                                            <th scope="col">Product Attribute Value</th>
                                            <th scope="col">Product Attribute Price Without GST</th>
                                            <th scope="col">Product Attribute Price</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        @foreach ($ProductAttributes as $data)
                                            <tr class="text-center">
                                                <td>{{ $i + $ProductAttributes->perPage() * ($ProductAttributes->currentPage() - 1) }}
                                                </td>
                                                <td>{{ $data->name }}</td>
                                                <td>
                                                    <?php if($data->product_attribute_photo){ ?>
                                                    <img src="{{ asset('ProductAttribute') . '/' . $data->product_attribute_photo }}"
                                                        style="width: 50px;height: 50px;">
                                                    <?php }else{ ?>
                                                    <img src="{{ asset('assets/images/noimage.png') }}"
                                                        style="width: 50px;height: 50px;">
                                                    <?php } ?>
                                                </td>
                                                <td>{{ $data->product_attribute_weight }}</td>
                                                <td>{{ $data->product_attribute_price_without_gst }}</td>
                                                <td>{{ $data->product_attribute_price }}</td>
                                                <td>
                                                    <div class=" gap-2">
                                                        <a class="mx-1" title="Edit" href="#"
                                                            onclick="getEditData(<?= $data->id ?>)" data-bs-toggle="modal"
                                                            data-bs-target="#showModal">
                                                            <i class="far fa-edit"></i>
                                                        </a>

                                                        <a class="" href="#" data-bs-toggle="modal"
                                                            title="Delete" data-bs-target="#deleteRecordModal"
                                                            onclick="deleteData(<?= $data->id ?>);">
                                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                                        </a>

                                                    </div>
                                                </td>
                                            </tr>
                                            <?php $i++; ?>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-center mt-3">
                                    {{ $ProductAttributes->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!--Edit Modal Start-->
                @foreach ($ProductAttributes as $datas)
                    <div class="modal fade flip" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header bg-light p-3">
                                    <h5 class="modal-title" id="exampleModalLabel">Edit Product Attribute</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                        id="close-modal"></button>
                                </div>
                                <form method="POST" action="{{ route('product.product_attribute_update') }}"
                                    autocomplete="off" onsubmit="return EditvalidateFile()"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="id" id="product_attribute_id" value="">

                                    <div class="modal-body">

                                        <div class="mb-3">
                                            <span style="color:red;">*</span>Attribute
                                            <select class="form-control" name="product_attribute_id" id="EditAttribute"
                                                >
                                                <option disabled value="">Select Attribute</option>
                                                @foreach ($Attribute as $attribute)
                                                    <option value="{{ $attribute->id }}"
                                                        {{ $data->product_attribute_id == $attribute->id ? 'selected' : '' }}>
                                                        {{ $attribute->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <span style="color:red;">*</span>Attribute Value
                                            <input type="text" class="form-control" name="product_attribute_weight"
                                                id="Editproduct_attribute_weight" placeholder="Enter Attribute Value"
                                                maxlength="50" autocomplete="off" required>
                                        </div>

                                        <div class="mb-3">
                                            <span style="color:red;">*</span>Attribute Price
                                            <input type="text" class="form-control" name="product_attribute_price"
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                                id="Editproduct_attribute_price" placeholder="Enter Attribute Price"
                                                maxlength="10" autocomplete="off" required>
                                        </div>

                                        <div class="mb-3">
                                            <span style="color:red;"></span>Attribute Photo
                                            <input type="file" name="product_attribute_photo" class="form-control" id="Editphoto">
                                            <input type="hidden" name="hiddenPhoto" class="form-control"
                                                id="hiddenPhoto">
                                            <div id="PHOTOID">

                                            </div>
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <div class="hstack gap-2 justify-content-end">
                                            <button type="submit" class="btn btn-primary mx-2"
                                                id="add-btn">Update</button>
                                            <button type="button" class="btn btn-primary mx-2"
                                                data-bs-dismiss="modal">Cancel</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
                <!--Edit Modal End -->


                <!--Delete Modal Start -->
                <div class="modal fade zoomIn" id="deleteRecordModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                    id="btn-close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mt-2 text-center">
                                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                                        colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px">
                                    </lord-icon>
                                    <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                                        <h4>Are you Sure ?</h4>
                                        <p class="text-muted mx-4 mb-0">Are you Sure You want to Remove this Record
                                            ?</p>
                                    </div>
                                </div>
                                <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                                    <a class="btn btn-primary mx-2" href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('user-delete-form').submit();">
                                        Yes,
                                        Delete It!
                                    </a>
                                    <button type="button" class="btn w-sm btn-primary mx-2"
                                        data-bs-dismiss="modal">Close</button>
                                    <form id="user-delete-form" method="POST"
                                        action="{{ route('product.product_attribute_delete') }}">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="id" id="deleteid" value="">

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Delete modal End -->

            </div>
        </div>
    </div>
@endsection

@section('scripts')

    <script>
        function getEditData(id) {
            var url = "{{ route('product.product_attribute_editview', ':id') }}";
            url = url.replace(":id", id);
            if (id) {
                $.ajax({
                    url: url,
                    type: 'GET',
                    data: {
                        id,
                        id
                    },
                    success: function(data) {
                        //console.log(data);
                        var obj = JSON.parse(data);
                        $("#EditAttribute").val(obj.product_attribute_id);
                        $("#Editproduct_attribute_weight").val(obj.product_attribute_weight);
                        // $("#Editproduct_attribute_price").val(obj.product_attribute_price);
                        $("#Editproduct_attribute_price").val(obj.product_attribute_price_without_gst);
                        $('#hiddenPhoto').val(obj.product_attribute_photo);

                        var html = "";
                        if (obj.product_attribute_photo == null) {
                            html =
                                '<img src = "/tongue_twister/assets/images/noimage.png" width = "50px" height = "50px" > ';
                        } else {
                            html =
                                '<img src="/tongue_twister/ProductAttribute/' + obj.product_attribute_photo +
                                '" id="hiddenPhoto" width="50px" height = "50px" > ';
                        }
                        $('#PHOTOID').html(html);
                        $('#product_attribute_id').val(id);
                    }
                });
            }
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

    {{-- Edit photo --}}
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
        $("#Editphoto").change(function() {
            html =
                '<img src="' + readURL(this) +
                '"   id="hello" width="70px" height = "70px" > ';
            $('#PHOTOID').html(html);
        });
    </script>

    <script>
        function EditvalidateFile() {
            //alert('hello');
            var allowedExtension = ['jpeg', 'jpg', 'png', 'webp'];
            var fileExtension = document.getElementById('Editphoto').value.split('.').pop().toLowerCase();
            var isValidFile = false;
            var image = document.getElementById('Editphoto').value;
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


    <script>
        function deleteData(id) {
            $("#deleteid").val(id);
        }
    </script>




@endsection
