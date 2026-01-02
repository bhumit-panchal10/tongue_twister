@extends('layouts.app')
@section('title', 'Setting List')
@section('content')

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                {{-- Alert Messages --}}
                @include('common.alert')

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <h5 class="card-title mb-0">Setting List</h5>
                            </div>
                            <div class="card-body">

                                <table id="scroll-horizontal" class="table nowrap align-middle" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">Site Name</th>
                                            <th scope="col">Logo</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        @foreach ($Setting as $data)
                                            <tr class="text-center">
                                                <td>{{ $i + $Setting->perPage() * ($Setting->currentPage() - 1) }}
                                                </td>
                                                <td>{{ $data->sitename }}</td>
                                                <td>
                                                    <img src="{{ asset('/Setting') . '/' . $data->logo }}"
                                                        style="width: 50px;height: 50px;">
                                                </td>
                                                <td>{{ $data->email }}</td>
                                                <td>
                                                    <div class=" gap-2">
                                                        <a class="mx-1" title="Edit" href="#"
                                                            onclick="getEditData(<?= $data->id ?>)" data-bs-toggle="modal"
                                                            data-bs-target="#showModal">
                                                            <i class="far fa-edit"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php $i++; ?>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-center mt-3">
                                    {{ $Setting->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!--Edit Modal Start-->
                <div class="modal fade flip" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-light p-3">
                                <h5 class="modal-title" id="exampleModalLabel">Edit Settings</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                    id="close-modal"></button>
                            </div>
                            <form onsubmit="return EditvalidateFile()" method="POST"
                                action="{{ route('setting.update') }}" autocomplete="off" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id" id="settingid" value="">

                                <div class="modal-body">

                                    <div class="mb-3">
                                        <span style="color:red;">*</span>Site Name
                                        <input type="text" class="form-control" name="sitename" id="Editsitename"
                                            placeholder="Enter Site Name" autocomplete="off" required>
                                    </div>

                                    <div class="mb-3">
                                        <span style="color:red;">*</span>Logo
                                        <input type="file" name="logo" class="form-control" id="Editphoto">
                                        <input type="hidden" name="hiddenPhoto" class="form-control" id="hiddenPhoto">
                                        <div id="PHOTOID">

                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <span style="color:red;">*</span>Email
                                        <input type="text" class="form-control" name="email" id="Editemail"
                                            placeholder="Enter Email" required>
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
                <!--Edit Modal End -->

            </div>
        </div>
    </div>
@endsection

@section('scripts')

    <script>
        function getEditData(id) {
            //alert(id);
            var url = "{{ route('setting.edit', ':id') }}";
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
                        $("#Editsitename").val(obj.sitename);
                        $("#Editemail").val(obj.email);

                        $('#hiddenPhoto').val(obj.logo);
                        var html = "";
                        if (obj.logo) {
                            html =
                                '<img src="/tongue_twister/Setting/' + obj.logo +
                                '" id="hiddenPhoto" width="50px" height = "50px" > ';
                        }
                        $('#PHOTOID').html(html);
                        $('#settingid').val(id);
                    }
                });
            }
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



@endsection
