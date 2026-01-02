@extends('layouts.app')
@section('title', 'Product Review')
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
                                <h5 class="card-title mb-0">Product Review</h5>
                                
                            </div>
                            <div class="card-body">
                                <?php //echo date('ymd');
                                ?>
                                <table id="scroll-horizontal" class="table nowrap align-middle" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th >Sr No</th>
                                            <th >Product Name</th>
                                            <th >Name</th>
                                            <th >Email</th>
                                            <th >Message</th>
                                            <th >Rating</th>
                                            <th >Status</th>
                                            <th >Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php $i = 1; ?>

                                        @foreach ($review as $value)
                                            <tr>
                                                <td>{{ $i }} </td>
                                                <td>{{ $value->productName }}</td>
                                                <td>{{ $value->author }}</td>
                                                <td>{{ $value->email }}</td>
                                                <td>{{ $value->comment }}</td>
                                                <td>{{ $value->rating }}</td>
                                                
                                                <td>@if($value->status == 0)
                                                    {{ 'Pending' }}
                                                    @elseif($value->status == 1)
                                                    {{ 'Accepted' }}
                                                    @else 
                                                    {{ 'Rejected' }}
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="gap-2">
                                                        <a class="mx-1" title="Edit" href="#"
                                                            onclick="getEditData(<?= $value->id ?>)"
                                                            data-bs-toggle="modal" data-bs-target="#showModal">
                                                            <i class="far fa-edit"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php $i++; ?>
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
                                <h5 class="modal-title" id="exampleModalLabel">Edit Review</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                    id="close-modal"></button>
                            </div>
                            <form method="POST" action="{{ route('review.update') }}" autocomplete="off"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id" id="id" value="">

                                <div class="modal-body">
                                    <div class="mb-3">
                                        <span style="color:red;">*</span>Rate
                                        <select class="form-control" name="review_status" id="Editreview_status">
                                            <option value="0">Pending</option>
                                            <option value="1">Accepted</option>
                                            <option value="2">Rejected</option>
                                        </select >
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
     $('#Editrate').on('input', function(){
        let inputValue = $(this).val();
        let parts = inputValue.replace(/[^\d.]/g, '').split('.');
        if (parts.length > 1) {
          parts[1] = parts[1].slice(0, 2);
        }
        $(this).val(parts.join('.'));

      });
        function getEditData(id) {
            var url = "{{ route('review.edit', ':id') }}";
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
                        $('#Editreview_status').val(obj.status);
                        $('#id').val(id);
                    }
                });
            }
        }
    </script>

@endsection
