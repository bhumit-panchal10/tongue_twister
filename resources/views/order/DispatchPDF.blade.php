<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

</head>

<body>

    <table style="border: 1px solid black;padding: 10px; width: 100%; font-weight:bolder;font-size:25px">
        <tr>
            <td style="width:50%">To</td>
            <td style="width:50%">&nbsp;</td>
        </tr>
        <tr>
            <td>{{ $data->shipping_cutomerName }}</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>{{ $data->shiiping_address1 }}<br>
           {{ $data->shiiping_address2 }}</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>{{ $data->shipping_city . ' - ' . $data->shipping_pincode }}</td>
            <td>&nbsp;</td>
        </tr>

        <tr>
            <?php if($data->shipping_mobile){ ?>
            <td>{{ $data->shipping_mobile }}</td>
            <?php } else { ?>
            <td> {{ $data->shipping_mobile . ' , ' . $data->shipping_mobile1 }}</td>
            <?php } ?>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>{{ $data->stateName }}</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>{{ $data->country }}</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td >&nbsp;</td>
            <td style="text-align: right;">From</td>
        </tr>
        <tr>
            <td >&nbsp;</td>
            <td align="right"> <img width="100"
                    src="{{asset('assets/frontassets/img/logo/logo.png')}}" alt=""></td>
        </tr>
        <tr>
            <td>&nbsp;</td>

            <td  style="text-align: right;font-weight:100">
                Phoenix Medicaments Pvt Ltd<br>
Changodhar - 382213<br>
Phone: 8780418312


            </td>
        </tr>

    </table>


</body>

</html>
