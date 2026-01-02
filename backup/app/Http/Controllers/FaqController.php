<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Faq;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class FaqController extends Controller
{
    public function index(Request $request)
    {
        $Faq = Faq::orderBy('faqid', 'desc')->paginate(10);

        return view('faq.index', compact('Faq'));
    }

    public function create(Request $request)
    {
        $Data = array(
            'question' => $request->question,
            'answer' => $request->answer,
            'created_at' => date('Y-m-d H:i:s'),
            'strIP' => $request->ip()
        );
        DB::table('faq')->insert($Data);

        return back()->with('success', 'Faq Created Successfully.');
    }

    public function editview(Request $request, $id)
    {
        $data = Faq::where(['iStatus' => 1, 'isDelete' => 0, 'faqid' => $id])->first();

        echo json_encode($data);
    }

    public function update(Request $request)
    {
        $update = DB::table('faq')
            ->where(['iStatus' => 1, 'isDelete' => 0, 'faqid' => $request->faqid])
            ->update([
                'question' => $request->question,
                'answer' => $request->answer,
                'updated_at' => date('Y-m-d H:i:s')
            ]);

        return back()->with('success', 'Faq Updated Successfully.');
    }


    public function delete(Request $request)
    {
        DB::table('faq')->where(['iStatus' => 1, 'isDelete' => 0, 'faqid' => $request->faqid])->delete();
        return back()->with('success', 'Faq Deleted Successfully!.');
    }
}
