<style>
    table,
    th,
    td {
        border: 1px solid black !important;
        border-collapse: collapse !important;
        padding: 5px !important;
        font-family: sans-serif !important;
    }

    * {
        font-family: DejaVu Sans !important;
    }
</style>


<table style="width: 100%;">


    <tr>
        <td style="text-align: center;">
            <img width="150" src="{{asset('assets/frontassets/img/logo/logo.png')}}" alt="">
        </td>
    </tr>
    {{--  <tr>
        <td
            style="text-align: center;
       padding: 10px 0px;
       text-transform: uppercase;
       font-weight: 600;
       font-size: 25px;
       /* background: black; */
       color: black;
       border: 1px solid black !important;">
            Tongue Twister 
        </td>
    </tr>  --}}


    <table style="width: 100%;">
        <tr>
            <td style="border: 1px solid #000000;font-weight: 600;">Address:</td>
            <td style="border: 1px solid #000000;">To,</td>
        </tr>

        <tr>
            <td style="border: 1px solid #000000;">Phoenix medicaments Pvt Ltd</td>
            @if ($data->shipping_cutomerName != '')
                <td style="border: 1px solid #000000;">{{ $data->shipping_cutomerName }}</td>
            @else
                <td style="border: 1px solid #000000;">{{ $data->cutomerName }}</td>
            @endif
        </tr>

        <tr>
            <td style="border: 1px solid #000000;">F-80, F-81, Tulsi Industrial Estate</td>
            
                <td style="border: 1px solid #000000;">{{ $data->shiiping_address1 . ',' . $data->shiiping_address2 }}</td>
            
        </tr>

        <tr>
            <td style="border: 1px solid #000000;">Opp Bhagyoday Hotel,
            </td>
            @if ($data->shipping_city != '')
                <td style="border: 1px solid #000000;">{{ $data->shipping_city . '-' . $data->shipping_pincode }}
                </td>
            @else
                <td style="border: 1px solid #000000;">{{ $data->city . '-' . $data->pincode }}</td>
            @endif
        </tr>

        <tr>
            <td style="border: 1px solid #000000;">Changodhar – 382213</td>
            @if ($data->shiiping_state != '')
                <td style="border: 1px solid #000000;">{{ $data->stateName }}</td>
            @else
                <td style="border: 1px solid #000000;">{{ $data->stateName }}</td>
            @endif
        </tr>

        <tr>
            <td style="border: 1px solid #000000;"></td>
            <td style="border: 1px solid #000000;">{{ $data->couriername.'-'.$data->docketNo }}</td>
        </tr>

    </table>


    <table style="width: 100%;">

        <tr>
            <td style="text-align: center;background-color: #red;color: white;">Sr No</td>
            <td style="text-align: center;background-color: #red;color: white;">Product Name</td>
            <td style="text-align: center;background-color: #red;color: white;">Qty</td>
            <td style="text-align: center;background-color: #red;color: white;">Rate</td>
            <td style="text-align: center;background-color: #red;color: white;">Amount</td>
        </tr>

        <?php $i = 1;
        $iTotal = 0; 
        $ShippingRate = 0 ;
        ?>
        @foreach ($detail as $details)
            <?php
            // dd($details);
            {{--  $MinQty = $details->minQty;
            $Qty = $details->quantity;
            $TotalQty = $MinQty * $Qty;  --}}
            ?>
            <tr>
                <td>{{ $i }}</td>
                <td>{{ $details->productname }}</td>
                <td>{{ $details->quantity }}</td>
                {{--  <td>{{ $TotalQty }}</td>  --}}
                <td>{{ $details->rate }}</td>
                <td>Rs.{{ $details->amount }}</td>
            </tr>
            <?php
            $Amount = $details->amount;
            $ShippingRate = $data->shipping_Charges;
            $iTotal = $iTotal * 1 + $Amount * 1;
            ?>

            <?php $i++; ?>
        @endforeach
        <?php
        $total = $iTotal * 1 + $ShippingRate * 1;
        ?>

        <tr>
            <td style="border: 1px solid white;border-right: 1px solid black;" colspan="3"></td>
            <td style="text-align: center;background-color: red;color: white;" colspan="1">Shipping Charges</td>
            <td colspan="1">Rs.{{ $data->shipping_Charges }}</td>
        </tr>

        <tr>
            <td style="border: 1px solid white;border-right: 1px solid black;" colspan="3"></td>
            <td style="text-align: center;background-color: red;color: white;" colspan="1">Total</td>
            <td colspan="1">Rs.<?php echo $total; ?></td>
        </tr>

        <tr>
            <td style="border: 1px solid white;border-right: 1px solid black;" colspan="3"></td>
            <td style="text-align: center;background-color: red;color: white;" colspan="1">Discount</td>
            <td colspan="1">Rs.{{ $data->discount }}</td>
        </tr>
        {{-- <tr>
        <td style="border: 1px solid white;border-right: 1px solid black;" colspan="3"></td>
        <td style="text-align: center;background-color: red;color: white;" colspan="1">Gst</td>
        <td colspan="1">₹50.00</td>
        </tr> --}}
        <tr>
            <td style="border: 1px solid white;border-right: 1px solid black;" colspan="3"></td>
            <td style="text-align: center;background-color: red;color: white;" colspan="1">Net Amount</td>
            <td colspan="1">Rs.{{ $data->netAmount }}</td>
        </tr>
    </table>
    <?php //dd('Hello');
    ?>


</table>
