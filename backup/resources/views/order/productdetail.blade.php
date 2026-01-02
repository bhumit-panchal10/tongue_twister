@extends('layouts.app')
@section('title', 'Product Detail List')
@section('content')

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                {{-- Alert Messages --}}
                @include('common.alert')

                <div class="row">
                    <div class="col-lg-12">

                        <div class="card">
                            <div class="d-flex justify-content-between card-header w-100">

                                <div class="">
                                    <h5 class="card-title mb-0 fw-bold text-black"
                                        style="font-size: 18px;
                                    font-weight: bold !important;
                                    text-transform: uppercase;">
                                        Customer Detail</h5>
                                </div>
                                <div class="">
                                    <a target="_blank" class="mx-2" href="{{ route('order.DetailPDF', $id) }}"
                                        title="Pdf Details">
                                        <i class="fa-solid fa-file-pdf fa-xl"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                <table id="scroll-horizontal" class="table nowrap align-middle" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th width="2%">Name</th>
                                            <th width="2%">Mobile</th>
                                            <th width="2%">Email</th>
                                            <th width="2%">Address</th>
                                            <th width="2%">State</th>
                                            <th width="2%">City</th>
                                            <th width="2%">Pincode</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="text-center">
                                            <td>{{ $data->shipping_cutomerName }}</td>
                                            <td>{{ $data->shipping_mobile }}</td>
                                            <td>{{ $data->shipping_email }}</td>
                                            <td>{{ $data->shiiping_address1 . ',' . $data->shiiping_address2 }}</td>
                                            <td>{{ $data->stateName }}</td>
                                            <td>{{ $data->shipping_city }}</td>
                                            <td>{{ $data->shipping_pincode }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>

                        <div class="card">
                            <div class="d-flex justify-content-start card-header">
                                <h5 class="card-title mb-0 fw-bold text-black"
                                    style="font-size: 18px;
                                font-weight: bold !important;
                                text-transform: uppercase;">
                                    Product Detail</h5>
                            </div>
                            <div class="card-body">
                                <table id="scroll-horizontal" class="table nowrap align-middle" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th width="1%">No</th>
                                            <th width="5%">Product Name</th>
                                            <th width="2%">Photo</th>
                                            <th width="1%">Weight</th>
                                            <th width="1%">Qty</th>
                                            <th width="1%">Rate</th>
                                            <th width="1%">Net Amount</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php $i = 1;
                                        $iTotal = 0; ?>
                                        @foreach ($detail as $details)
                                            <tr class="text-center">
                                                <td>{{ $i }}</td>
                                                <td>{{ $details->productname }}</td>
                                                <td>
                                                    <a href='{{asset('Product/Thumbnail/').'/'.$details->photo }}' target='_blank'>
                                                            <img src="{{ asset('Product/Thumbnail/') . '/' . $details->photo }}" style="width: 50px;height: 50px;" alt="">
                                                    </a> 
                                                </td>
                                                <td>{{ $details->weight }}</td>
                                                <td>{{ $details->quantity }}</td>
                                                <td>{{ $details->rate }}</td>
                                                <td class="text-end">Rs.{{ $details->amount }}</td>
                                            </tr>
                                            <?php $i++; ?>

                                            <?php
                                            $Amount = $details->amount;
                                            $ShippingRate = $data->shipping_Charges;
                                            $iTotal = $iTotal * 1 + $Amount * 1;
                                            ?>
                                        @endforeach
                                        <?php
                                        $total = $iTotal * 1 + $ShippingRate * 1;
                                        ?>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th class="text-end">Sub Total:- &nbsp;</th>
                                            <th class="text-end">Rs.{{ $iTotal }}</th>
                                        </tr>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th class="text-end">Shipping Charges:-  &nbsp;</th>
                                            <th class="text-end">(+) Rs.{{ $data->shipping_Charges }}</th>
                                        </tr>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th class="text-end">Total:- &nbsp;</th>
                                            <th class="text-end"> Rs.{{ $total }}</th>
                                        </tr>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th class="text-end">Discount:- &nbsp;</th>
                                            <th class="text-end">(-) Rs.{{ $data->discount ?? 0}}</th>
                                        </tr>
                                        
                                        
                                        
                                        
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th class="text-end">Total:- &nbsp;</th>
                                            <th class="text-end">Rs.{{ $data->netAmount }}</th>
                                        </tr>
                                    </tbody>

                                </table>
                            </div>

                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('scripts')


@endsection
