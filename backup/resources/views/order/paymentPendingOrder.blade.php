@extends('layouts.app')

@section('title', 'Payment Pending Order List')

@section('content')


    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                {{-- Alert Messages --}}
                @include('common.alert')

                <div class="row">
                    <div class="col-xxl-12">
                        <h5 class="mb-3"></h5>
                        <div class="card">
                            <div class="card-body">
                                <!-- Nav tabs -->


                                <div class="container-fluid">
                                    <!-- Page Heading -->
                                    <div class="card">
                                        <div class="card-body">
                                            <form method="post" id="form" action="{{ route('order.pending') }}">
                                                @csrf
                                                <div class="row  align-items-center">
                                                    <div class="col-md-3  mb-2">
                                                        <div class="d-flex align-items-center">
                                                            <input placeholder="Enter From Date" type="text"
                                                                class="form-control" id="startdatepicker" name="fromdate"
                                                                autocomplete="off"
                                                                value="<?= isset($FromDate) ? $FromDate : '' ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3  mb-2">
                                                        <div class="d-flex align-items-center">
                                                            <input placeholder="Enter To Date" type="text"
                                                                class="form-control" name="todate" autocomplete="off"
                                                                id="enddatepicker"
                                                                value="<?= isset($ToDate) ? $ToDate : '' ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 mb-2">
                                                        <div class="input-group d-flex justify-content-right">
                                                            <button type="submit" class="btn btn-primary mx-2">
                                                                Search
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-content text-muted">
                                    <div class="tab-pane active" id="PendingOrder" role="tabpanel">
                                        <div class="row">

                                            <div class="col-lg-12">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="table-responsive">

                                                            <table id="scroll-horizontal" class="table nowrap align-middle"
                                                                style="width:100%">
                                                                <thead>
                                                                    <tr>
                                                                        <th width="1%">Sr.No</th>
                                                                        <th width="3%">Order Date</th>
                                                                        <th width="4%">Customer Name</th>
                                                                        
                                                                        <th width="1%">Email</th>
                                                                        <th width="1%">Mobile</th>
                                                                        <th width="2%">City</th>
                                                                        <th width="1%">State</th>
                                                                        <th width="1%">Pincode</th>
                                                                        <th width="1%">Total</th>
                                                                        <th width="3%">Payment Status</th>
                                                                        
                                                                        <th width="2%">Action</th>
                                                                        
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                    $i = 1;
                                                                    ?>
                                                                    @foreach ($Pending as $pending)
                                                                        <tr class="text-center">
                                                                            <td>{{ $i + $Pending->perPage() * ($Pending->currentPage() - 1) }}
                                                                            </td>

                                                                            <td>{{ date('d-m-Y', strtotime($pending->created_at)) }}
                                                                            </td>

                                                                            <td>{{ $pending->shipping_cutomerName }}</td>
                                                                            
                                                                            <td>{{ $pending->shipping_email }}</td>
                                                                            <td>{{ $pending->shipping_mobile }}</td>
                                                                            <td>{{ $pending->shipping_city	 }}</td>
                                                                            <td>{{ $pending->stateName }}</td>
                                                                            <td>{{ $pending->shipping_pincode }}</td>
                                                                            
                                                                            <td>{{ $pending->netAmount }}</td>  

                                                                             <td>
                                                                                @if ($pending->iRazorpayStatus == 0)
                                                                                    Pending
                                                                                @elseif($pending->iRazorpayStatus == 1)    
                                                                                    Success
                                                                                @else
                                                                                    Failed
                                                                                @endif  
                                                                            </td>                                                            
                                                                                
                                                                            <td>
                                                                                <!--<a class="" href="#"
                                                                                    data-bs-toggle="modal" title="Dispatch"
                                                                                    data-bs-target="#showModal"
                                                                                    onclick="getEditData(<?= $pending->order_id ?>);">
                                                                                    <i class="fa-solid fa-truck fa-lg"></i>
                                                                                </a>

                                                                                <a href="{{ route('order.statustocancel', $pending->order_id) }}"
                                                                                    onclick="return confirm('Are you Sure You wanted to Cancel?');"
                                                                                    class="mx-2" title="Cancel">
                                                                                    <i class="fa-solid fa-xmark fa-xl"></i>
                                                                                </a>-->

                                                                                <a class="mx-2"
                                                                                    href="{{ route('order.orderdetail', $pending->order_id) }}"
                                                                                    title="Details">
                                                                                    <i
                                                                                        class="fa-solid fa-circle-info fa-lg"></i>
                                                                                </a>

                                                                                <a class="mx-2" target="_blank"
                                                                                    href="{{ route('order.DetailPDF', $pending->order_id) }}"
                                                                                    title="Pdf Details">
                                                                                    <i
                                                                                        class="fa-solid fa-file-pdf fa-lg"></i>
                                                                                </a>
                                                                                
                                                                                <a class="mx-2" target="_blank"
                                                                                    href="{{ route('order.DispatchPDF', $pending->order_id) }}"
                                                                                    title="Dispatch Pdf Details">
                                                                                    <i class="fa-solid fa-file-pdf fa-lg"></i>
                                                                                    <!--Dispatch Order Sticker PDF-->
                                                                                </a>
                                                                            </td>
                                                                            <tr>
                                                                                <td colspan="10" class="des-ll">
                                                                                    <div
                                                                                        class="d-flex justify-content-between">
                                                                                       
                                                                                        <a href="{{ route('order.successOrder', $pending->order_id) }}"
                                                                                            onclick="return confirm('Are you Sure You wanted to success This Payment?');"
                                                                                            class="mx-2" title="Move to success">
                                                                                            <i
                                                                                                class="fa-solid fa-check fa-xl"></i>
                                                                                            Move to success
                                                                                        </a></td>    
                                                                            </tr>
                                                                        </tr>
                                                                        <?php $i++; ?>
                                                                    @endforeach


                                                                </tbody>

                                                            </table>
                                                            <div class="d-flex justify-content-center mt-3">
                                                                {{ $Pending->appends(request()->except('page'))->links() }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade flip" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-light p-3">
                    <h5 class="modal-title" id="exampleModalLabel">Add Courier Detail</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        id="close-modal"></button>
                </div>
                <form method="POST" action="{{ route('order.statustodispatched') }}" autocomplete="off"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="order_id" id="order_id" value="">

                    <div class="modal-body">

                        <div class="mb-3">
                            <span style="color:red;">*</span>Courier
                            <select name="courier" class="form-control" id="" required>
                                <option value="">Select Courier</option>
                                @foreach ($Courier as $courier)
                                    <option value="{{ $courier->id }}">{{ $courier->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <span style="color:red;">*</span>Docket No
                            <input type="text" class="form-control" name="docketNo" id="Editname"
                                placeholder="Enter Docket No" maxlength="100" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="hstack gap-2 justify-content-end">
                            <button type="submit" class="btn btn-success" id="add-btn">Submit</button>
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
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
    </script>

    <script>
        function getEditData(id) {
            $('#order_id').val(id);
        }
    </script>
@endsection
