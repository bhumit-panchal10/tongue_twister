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
            <td>To</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>{{ $data->shipping_cutomerName }}</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>{{ $data->shiiping_address1 }}</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td style="width:60%">{{ $data->shiiping_address2 }}</td>
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
            <td colspan="2"></td>
            <td style="text-align: center;">From</td>
        </tr>
        <tr>
            <td colspan="2"></td>
            <th rowspan="4"> <img width="100"
                    src="{{asset('assets/frontassets/img/logo/logo.png')}}" alt=""></th>
        </tr>
        <tr>
            <td></td>

            <td colspan="2" rowspan="18" style="text-align: right;">
                <!--+91 90165 81643-->
            </td>
        </tr>

    </table>


</body>

</html>
