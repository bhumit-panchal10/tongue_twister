@extends('layouts.app')

@section('title', 'Payment Report')

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
                            <div class="card-header d-flex justify-content-between">
                                <h5 class="card-title mb-0">Payment Report</h5>
                            </div>
                            <div class="card-body">
                                <!-- Nav tabs -->

                                <div class="container-fluid">
                                    <!-- Page Heading -->
                                    <div class="card">
                                        <div class="card-body">
                                            <form method="post" id="form" action="{{ route('report.paymentReport') }}">
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
                                                            <a class="btn btn-primary mx-2" href="{{ route('report.paymentReport') }}">
                                                                Cancel
                                                            </a>
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
                                                                        <th class="all">Sr.No</th>
                                                                        <th class="all">Order Date</th>
                                                                        <th class="all">Customer Name</th>
                                                                        <th class="all">Email</th>
                                                                        <th class="all">Mobile</th>
                                                                        <th class="all">City</th>
                                                                        <th class="all">State</th>
                                                                        <th class="all">Pincode</th>
                                                                        <th class="all">Total</th>
                                                                        <th class="all">Payment Status</th>
                                                                        <th class="all">Courier Name</th>
                                                                        <th class="all">Docket No</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                    $i = 1;
                                                                    $Total = 0;
                                                                    ?>
                                                                    @foreach ($Dispatched as $dispatched)
                                                                        <tr class="text-center">
                                                                            <td>
                                                                                {{ $i + $Dispatched->perPage() * ($Dispatched->currentPage() - 1) }}
                                                                            </td>
                                                                            <td>{{ date('d-m-Y', strtotime($dispatched->created_at)) }}
                                                                            </td>
                                                                            <td>{{ $dispatched->shipping_cutomerName }}</td>
                                                                            
                                                                            <td>{{ $dispatched->shipping_email }}</td>
                                                                            <td>{{ $dispatched->shipping_mobile }}</td>
                                                                            <td>{{ $dispatched->shipping_city	 }}</td>
                                                                            <td>{{ $dispatched->stateName }}</td>
                                                                            <td>{{ $dispatched->shipping_pincode }}</td>
                                                                            <td>{{ $dispatched->netAmount }}</td>   
                                                                            <td>
                                                                                @if ($dispatched->isPayment == 0)
                                                                                    Pending
                                                                                @elseif($dispatched->isPayment == 1)    
                                                                                    Success
                                                                                @else
                                                                                    Failed
                                                                                @endif  
                                                                            </td>   
                                                                            <td>{{ $dispatched->name }}</td>
                                                                            <td>{{ $dispatched->docketNo }}</td>
                                                                        </tr>
                                                                        <?php 
                                                                        $Total += $dispatched->netAmount;
                                                                        $i++; ?>
                                                                    @endforeach
                                                                    <tr>
                                                                        <td colspan="8">
                                                                            Total
                                                                        </td>
                                                                        <td>
                                                                            {{ $Total }}
                                                                        </td>
                                                                    </tr>


                                                                </tbody>

                                                            </table>
                                                            <div class="d-flex justify-content-center mt-3">
                                                                {{ $Dispatched->appends(request()->except('page'))->links() }}
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
                defaultDate: new Date()
            });
        });

        $(function() {
            $("#enddatepicker").datepicker({
                dateFormat: 'd-m-yy',
                defaultDate: new Date()
            });
        });
    </script>
@endsection
