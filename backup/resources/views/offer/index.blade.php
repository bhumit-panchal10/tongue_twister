@extends('layouts.app')
@section('title', 'Offer List')
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
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header"
                            style="display: flex;
                            justify-content: space-between;">
                            <h5 class="card-title mb-0">Add Offer</h5>
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
                            <h5 class="modal-title" id="exampleModalLabel">Add Offer</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                id="close-modal"></button>
                        </div>
                        <form id="clear_form" onsubmit="return validateFile()" action="{{ route('offer.store') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf

                            <div class="modal-body">

                                <div class="mb-3">
                                    <span style="color:red;">*</span>Text
                                    <input type="text" class="form-control" name="text" placeholder="Enter Text"
                                        maxlength="50" autocomplete="off" required>
                                </div>

                                <div class="mb-3">
                                    <span style="color:red;">*</span>Offer Code
                                    <input type="text" class="form-control" name="offercode"
                                        placeholder="Enter Offer code" maxlength="10" autocomplete="off" required>
                                </div>
                                <div class="mb-3">
                                    <span style="color:red;">*</span>Percentage (%) off
                                    <input type="text" class="form-control" name="type" placeholder="Enter Type"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                        maxlength="2" autocomplete="off" required>
                                </div>
                                <div class="mb-3">
                                    <span style="color:red;">*</span>Min Value
                                    <input type="text" class="form-control" name="minvalue"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                        placeholder="Enter Min Value" autocomplete="off" required maxlength="10">
                                </div>
                                <div class="mb-3">
                                    <span style="color:red;">*</span>From Date
                                    <input placeholder="Enter From Date" type="text" class="form-control"
                                        id="startdatepicker" name="fromdate" autocomplete="off" required>
                                </div>
                                <div class="mb-3">
                                    <span style="color:red;">*</span>To Date
                                    <input placeholder="Enter To Date" type="text" class="form-control"
                                        name="todate" autocomplete="off" id="enddatepicker" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <div class="hstack gap-2 justify-content-end">
                                    <button type="submit" onclick="return validateData();" class="btn btn-primary mx-2"
                                        id="add-btn">Submit</button>
                                    <button class="btn btn-primary mx-2 cancel">Clear</button>
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
                            <h5 class="card-title mb-0">Offer List</h5>
                        </div>
                        <div class="card-body">
                            <?php //echo date('ymd');
                            ?>
                            <table id="scroll-horizontal" class="table nowrap align-middle" style="width:100%">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col"> Text</th>
                                        <th scope="col"> Percentage (%) off</th>
                                        <th scope="col"> Offer Code</th>
                                        <th scope="col"> Min Value</th>
                                        <th scope="col">From Date</th>
                                        <th scope="col">To Date</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    @foreach ($Offer as $data)
                                    <tr class="text-center">
                                        <td>{{ $i + $Offer->perPage() * ($Offer->currentPage() - 1) }}
                                        </td>
                                        <td>{{ $data->text }}</td>
                                        <td>{{ $data->type }}</td>
                                        <td>{{ $data->offercode }}</td>
                                        <td>{{ $data->minvalue }}</td>
                                        <td>{{ date('d-m-Y', strtotime($data->startdate)) }}</td>
                                        <td>{{ date('d-m-Y', strtotime($data->enddate)) }}</td>
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
                                {{ $Offer->links() }}
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
                            <h5 class="modal-title" id="exampleModalLabel">Edit Offer</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                id="close-modal"></button>
                        </div>
                        <form onsubmit="return EditvalidateFile()" method="POST"
                            action="{{ route('offer.update') }}" autocomplete="off" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" id="offerid" value="">

                            <div class="modal-body">

                                <div class="mb-3">
                                    <span style="color:red;">*</span>Text
                                    <input type="text" class="form-control" name="text" id="Edittext"
                                        placeholder="Enter Text" maxlength="100" autocomplete="off" required>
                                </div>

                                <div class="mb-3">
                                    <span style="color:red;">*</span>Offer Code
                                    <input type="text" class="form-control" name="offercode" id="Editoffercode"
                                        placeholder="Enter Offer Code" maxlength="10" autocomplete="off" required>
                                </div>

                                <div class="mb-3">
                                    <span style="color:red;">*</span>Percentage (%) off
                                    <input type="text" class="form-control" name="type" id="Edittype"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                        placeholder="Enter Type" maxlength="2" autocomplete="off" required>
                                </div>

                                <div class="mb-3">
                                    <span style="color:red;">*</span>Min Value
                                    <input type="text" class="form-control" name="minvalue" id="Editminvalue"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                        placeholder="Enter Min Value" maxlength="10" autocomplete="off" required>
                                </div>


                                <div class="mb-3">
                                    <span style="color:red;">*</span>From Date
                                    <input placeholder="Enter From Date" type="text" class="form-control"
                                        id="Editstartdatepicker" name="fromdate" autocomplete="off" required>
                                </div>
                                <div class="mb-3">
                                    <span style="color:red;">*</span>To Date
                                    <input placeholder="Enter To Date" type="text" class="form-control"
                                        name="todate" autocomplete="off" id="Editenddatepicker" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <div class="hstack gap-2 justify-content-end">
                                    <button type="submit" onclick="return EditvalidateData();"
                                        class="btn btn-primary mx-2" id="add-btn">Update</button>
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
                                <form id="user-delete-form" method="POST" action="{{ route('offer.delete') }}">
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
        //alert(id);
        var url = "{{ route('offer.edit', ':id') }}";
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
                    $("#Edittext").val(obj.text);
                    $("#Edittype").val(obj.type);
                    $("#Editoffercode").val(obj.offercode);
                    $("#Editminvalue").val(obj.minvalue);
                    $("#Editstartdatepicker").val(obj.startdate);
                    $("#Editenddatepicker").val(obj.enddate);

                    $('#offerid').val(id);
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

<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

<script>
    $(function() {
        $("#startdatepicker").datepicker({
            dateFormat: 'd-m-yy',
            //minDate: 0
        });
    });

    $(function() {
        $("#enddatepicker").datepicker({
            dateFormat: 'd-m-yy',
            //minDate: 0
        });
    });

    $(function() {
        $("#Editstartdatepicker").datepicker({
            dateFormat: 'd-m-yy',
            //minDate: 0
        });
    });

    $(function() {
        $("#Editenddatepicker").datepicker({
            dateFormat: 'd-m-yy',
            //minDate: 0
        });
    });
</script>

<script>
    function validateData() {
        var startdatetime = $('#startdatepicker').val();
        var enddatetime = $('#enddatepicker').val();

        if (enddatetime < startdatetime) {
            alert("EndDate Must Be Greater Than StartDate.")

            $('#startdatepicker').val("");
            $('#enddatepicker').val("");
            return false;
        } else {
            return true;
        }
    }
</script>

<script>
    function EditvalidateData() {
    var editstartdatetime = $('#Editstartdatepicker').val();
    var editenddatetime = $('#Editenddatepicker').val();

    // Convert date strings to Date objects
    var startDate = new Date(editstartdatetime.split('-').reverse().join('-'));
    var endDate = new Date(editenddatetime.split('-').reverse().join('-'));

    if (endDate < startDate) {
        alert("EndDate Must Be Greater Than StartDate.");
        $('#Editstartdatepicker').val("");
        $('#Editenddatepicker').val("");
        return false;
    } else {
        return true;
    }
}

</script>
@endsection