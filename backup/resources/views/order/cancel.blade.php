@extends('layouts.app')

@section('title', 'Cancel List')

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

                                @include('order.orderTab')

                                <div class="container-fluid">
                                    <!-- Page Heading -->
                                    <div class="card">
                                        <div class="card-body">
                                            <form method="post" id="form" action="{{ route('order.cancel') }}">
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
                                                    <div class="col-md-3  mb-2">
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
                                                                        <th width="3%">Customer Name</th>
                                                                        
                                                                        <th width="1%">Email</th>
                                                                        <th width="1%">Mobile</th>
                                                                        <th width="2%">City</th>
                                                                        <th width="1%">State</th>
                                                                        <th width="1%">Pincode</th>
                                                                        <th width="1%">Total</th>
                                                                        <th width="3%">Payment Status</th>

                                                                        <th width="3%">Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                    $i = 1;
                                                                    ?>
                                                                    @foreach ($Cancel as $cancel)
                                                                        <tr class="text-center">
                                                                            <td>
                                                                                {{ $i + $Cancel->perPage() * ($Cancel->currentPage() - 1) }}
                                                                            </td>
                                                                            <td>{{ date('d-m-Y', strtotime($cancel->created_at)) }}
                                                                            </td>
                                                                            <td>
                                                                                {{ $cancel->shipping_cutomerName }}</td>
                                                                                
                                                                             <td>{{ $cancel->shipping_email }}</td>
                                                                            <td>{{ $cancel->shipping_mobile }}</td>
                                                                            <td>{{ $cancel->shipping_city	 }}</td>
                                                                            <td>{{ $cancel->stateName }}</td>
                                                                            <td>{{ $cancel->shipping_pincode }}</td>
                                                                            
                                                                            <td>{{ $cancel->netAmount }}</td>  

                                                                             <td>
                                                                                @if ($cancel->iRazorpayStatus == 0)
                                                                                    Pending
                                                                                @elseif($cancel->iRazorpayStatus == 1)    
                                                                                    Success
                                                                                @else
                                                                                    Failed
                                                                                @endif  
                                                                            </td>      

                                                                            <td>
                                                                                <a href="{{ route('order.statustopending', $cancel->order_id) }}"
                                                                                    onclick="return confirm('Are you Sure You wanted to Pending?');"
                                                                                    class="mx-2" title="Pending">
                                                                                    <i class="fa-solid fa-clock fa-lg"></i>
                                                                                </a>
                                                                                <a class="mx-2"
                                                                                    href="{{ route('order.orderdetail', $cancel->order_id) }}"
                                                                                    title="Details">
                                                                                    <i
                                                                                        class="fa-solid fa-circle-info fa-lg"></i>
                                                                                </a>

                                                                                <a class="mx-2" target="_blank"
                                                                                    href="{{ route('order.DetailPDF', $cancel->order_id) }}"
                                                                                    title="Pdf Details">
                                                                                    <i
                                                                                        class="fa-solid fa-file-pdf fa-lg"></i>
                                                                                </a>
                                                                            </td>
                                                                        </tr>
                                                                        <?php $i++; ?>
                                                                    @endforeach


                                                                </tbody>

                                                            </table>
                                                            <div class="d-flex justify-content-center mt-3">
                                                                {{ $Cancel->appends(request()->except('page'))->links() }}
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
@endsection
