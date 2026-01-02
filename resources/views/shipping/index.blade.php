@extends('layouts.app')
@section('title', 'Shipping Rate')
@section('content')

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                {{-- Alert Messages --}}
                @include('common.alert')

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="d-flex justify-content-between card-header">
                                <h5 class="card-title mb-0">Shipping Rate</h5>
                                {{--  <a data-bs-toggle="modal" data-bs-target="#AddModal" class="btn btn-sm btn-primary">
                                    <i data-feather="plus"></i> Add New
                                </a>  --}}
                            </div>
                            <div class="card-body">
                                <?php //echo date('ymd');
                                ?>
                                <table id="scroll-horizontal" class="table nowrap align-middle" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th width="1%">No</th>
                                            <th width="2%"> Rate</th>
                                            <th width="2%"> Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($Shipping as $shipping)
                                            <tr class="text-center">
                                                <td>1</td>
                                                <td>{{ $shipping->rate }}</td>
                                                <td>
                                                    <div class="gap-2">
                                                        <a class="mx-1" title="Edit" href="#"
                                                            onclick="getEditData(<?= $shipping->id ?>)"
                                                            data-bs-toggle="modal" data-bs-target="#showModal">
                                                            <i class="far fa-edit"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
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
                                <h5 class="modal-title" id="exampleModalLabel">Edit Shipping Rate</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                    id="close-modal"></button>
                            </div>
                            <form method="POST" action="{{ route('shipping.update') }}" autocomplete="off"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id" id="id" value="">

                                <div class="modal-body">
                                    <div class="mb-3">
                                        <span style="color:red;">*</span>Rate
                                        <input type="text" class="form-control" name="rate" id="Editrate"
                                            placeholder="Enter Rate" maxlength="100" autocomplete="off" required>
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

            </div>
        </div>
    </div>
@endsection

@section('scripts')

    <script>
        function getEditData(id) {
            var url = "{{ route('shipping.edit', ':id') }}";
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
                        var obj = JSON.parse(data);
                        $("#Editrate").val(obj.rate);
                        $('#id').val(id);
                    }
                });
            }
        }
    </script>

@endsection
