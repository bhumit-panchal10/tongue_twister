@extends('layouts.app')
@section('title', 'Courier List')
@section('content')

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">

            {{-- Alert Messages --}}
            @include('common.alert')

            @if ($errors->any())
            {{-- <h5 style="color:red">Following errors exists in your excel file</h5>  --}}
            <ol>
                @foreach ($errors->all() as $error)
                <p style="color:red">{{ $error }}</p>
                @endforeach
            </ol>
            @endif

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Add Courier</h4>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="live-preview">
                                <form id="clear_form" onsubmit="return validateFile()" action="{{ route('courier.store') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row gy-4" style="align-items: end;">

                                        <div class="col-lg-3 col-md-3">
                                            <div>
                                                <span style="color:red;">*</span>Courier Name
                                                <input type="text" class="form-control" name="name" id="couriername"
                                                    onblur="validatecourier();" value="{{ old('name') }}"
                                                    placeholder="Enter Courier Name" autocomplete="off"
                                                    maxlength="50" required>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-md-3">
                                            <div>
                                                <span style="color:red;">*</span>Tracking URL
                                                <input type="url" class="form-control" name="tracking_url"
                                                    id="trackingurl" value="{{ old('tracking_url') }}"
                                                    placeholder="Enter Tracking URL" autocomplete="off" required>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-md-3">
                                            <button type="submit" onclick="validatesubmit();" class="btn btn-primary btn-user float-right mx-2">Save</button>
                                            <button class="btn btn-primary cancel">Clear</button>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Courier List</h5>
                        </div>
                        <div class="card-body">
                            <?php //echo date('ymd');
                            ?>
                            <table id="scroll-horizontal" class="table nowrap align-middle" style="width:100%">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Courier Name</th>
                                        <th scope="col">Tracking Url</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    @foreach ($Courier as $courier)
                                    <tr>
                                        <td class="text-center">
                                            {{ $i + $Courier->perPage() * ($Courier->currentPage() - 1) }}
                                        <td class="text-center">{{ $courier->name }}</td>
                                        <td class="text-center"><a href="{{ $courier->tracking_url }}">{{ $courier->tracking_url }}</a></td>

                                        <td>
                                            <div class="text-center">
                                                <a class="mx-1" title="Edit" href="#"
                                                    onclick="getEditData(<?= $courier->id ?>)"
                                                    data-bs-toggle="modal" data-bs-target="#showModal">
                                                    <i class="far fa-edit"></i>
                                                </a>

                                                <a class="" href="#" data-bs-toggle="modal"
                                                    title="Delete" data-bs-target="#deleteRecordModal"
                                                    onclick="deleteData(<?= $courier->id ?>);">
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
                                {{ $Courier->links() }}
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
                            <h5 class="modal-title" id="exampleModalLabel">Edit Courier</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                id="close-modal"></button>
                        </div>
                        <form onsubmit="return EditvalidateFile()" method="POST" action="{{ route('courier.update') }}"
                            autocomplete="off" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" id="courierid" value="">
                            <div class="modal-body">
                                <div class="mb-3">
                                    <span style="color:red;">*</span>Courier Name
                                    <input type="text" name="name" class="form-control"
                                        onblur="validateeditname();" placeholder="Enter Courier Name" maxlength="50" id="Editname" required>
                                </div>
                                <div class="mb-3">
                                    <div>
                                        <span style="color:red;">*</span>Tracking URL
                                        <input type="url" class="form-control" name="tracking_url"
                                            id="trackingurl_edit" value=""
                                            placeholder="Enter Tracking URL" autocomplete="off" required>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <div class="hstack gap-2 justify-content-end">
                                    <button type="submit" class="btn btn-primary mx-2" id="add-btn">Update</button>
                                    <button type="button" class="btn btn-primary mx-2"
                                        data-bs-dismiss="modal">Cancel</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
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
                                <form id="user-delete-form" method="POST" action="{{ route('courier.delete') }}">
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
    $(document).ready(function() {
        $(".cancel").on("click", function() {
            $("#clear_form").trigger('reset');
        });
    });
</script>
<script>
    function getEditData(id) {
        var url = "{{ route('courier.edit', ':id') }}";
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
                    console.log(data);
                    var obj = JSON.parse(data);
                    $('#Editname').val(obj.name);
                    $('#trackingurl_edit').val(obj.tracking_url);
                    $('#courierid').val(id);
                }
            });
        }
    }
</script>

<script>
    function deleteData(id) {
        $("#deleteid").val(id);
    }
</script>

<!-- <script>
    function validatecourier() {
        var courier = $("#couriername").val();
        var url = "{{ route('courier.validatename') }}";
        $.ajax({
            url: url,
            type: 'GET',
            data: {
                courier: courier
            },
            success: function(data) {
                console.log(data);
                if (data == 1) {
                    alert('Courier Already Exists.');
                    $("#couriername").val();
                    return false;
                }

            }
        })
    }
</script> -->

<!-- <script>
    function validateeditname() {
        var editcourier = $("#Editname").val();
        var url = "{{ route('courier.validateeditname') }}";
        $.ajax({
            url: url,
            type: 'GET',
            data: {
                editcourier: editcourier
            },
            success: function(data) {
                console.log(data);
                if (data == 1) {
                    alert('Courier Already Exists.');
                    $("#Editname").val();
                    return false;
                }
            }
        })
    }
</script> -->

{{-- <script>
        function validatesubmit() {
            var courier = validatecourier();

            if (courier == true) {
                return true;
            } else {
                return false;
            }
        }
    </script>  --}}
@endsection