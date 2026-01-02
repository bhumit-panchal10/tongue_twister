<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Offer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class OfferController extends Controller
{
    public function index(Request $request)
    {
        $Offer = Offer::orderBy('id', 'desc')->paginate(env('PER_PAGE_COUNT'));

        return view('offer.index', compact('Offer'));
    }

    public function create(Request $request)
    {
        // $validation = Validator::make($request->all(), [
        //     // 'startdate' => 'date|before_or_equal:enddate',
        //     'startdate' => 'required|date|after:tomorrow',
        //     // 'enddate' => 'date',
        //     'enddate' => 'required|date|after:startdate'
        // ]);

        // if (strtotime($request->todate) > strtotime($request->fromdate)) {

        $Data = array(
            'text' => $request->text,
            'type' => $request->type,
            'offercode' => $request->offercode,
            'minvalue' => $request->minvalue,
            'startdate' => date('Y-m-d', strtotime($request->fromdate)),
            'enddate' => date('Y-m-d', strtotime($request->todate)),
            'created_at' => date('Y-m-d H:i:s'),
            'strIP' => $request->ip()
        );
        //dd($Data);
        DB::table('offer')->insert($Data);

        return back()->with('success', 'Offer Created Successfully.');
        // } else {
        //     return redirect()->back()->withInput()->with('error', 'EndDate Must Be Greater Than StartDate.');
        // }
    }

    public function editview(Request $request, $id)
    {
        $data = Offer::where(['iStatus' => 1, 'isDelete' => 0, 'id' => $id])->first();
        // dd($data);
        $getData = array(
            'text'    => $data->text,
            'type' => $data->type,
            'offercode' => $data->offercode,
            'minvalue' => $data->minvalue,
            'startdate' => date('d-m-Y', strtotime($data->startdate)),
            'enddate' => date('d-m-Y', strtotime($data->enddate))
        );
        // dd($getData);
        echo json_encode($getData);
    }

    public function update(Request $request)
    {
        $update = DB::table('offer')
            ->where(['iStatus' => 1, 'isDelete' => 0, 'id' => $request->id])
            ->update([
                'text' => $request->text,
                'type' => $request->type,
                'offercode' => $request->offercode,
                'minvalue' => $request->minvalue,
                'startdate' => date('Y-m-d', strtotime($request->fromdate)),
                'enddate' => date('Y-m-d', strtotime($request->todate)),
                'updated_at' => date('Y-m-d H:i:s')
            ]);

        return back()->with('success', 'Offer Updated Successfully.');
    }


    public function delete(Request $request)
    {
        DB::table('offer')->where(['iStatus' => 1, 'isDelete' => 0, 'id' => $request->id])->delete();

        return back()->with('success', 'Offer Deleted Successfully!.');
    }
}
