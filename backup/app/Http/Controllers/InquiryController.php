<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inquiry;
use Illuminate\Support\Facades\DB;

class InquiryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $inquiries = Inquiry::orderBy('inquiry_id', 'DESC')->where(['iStatus' => 1, 'isDelete' => 0])->paginate(25);
        return view('inquiries.index', compact('inquiries'));
    }


    public function delete(Request $request)
    {
        DB::table('inquiry')->where(['iStatus' => 1, 'isDelete' => 0, 'inquiry_id' => $request->inquiry_id])->delete();

        return redirect()->route('Inquiry.index')->with('success', 'Deleted Successfully!.');
    }
}
