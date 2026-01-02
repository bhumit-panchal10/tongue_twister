<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Testimonial;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TestimonialController extends Controller
{
    public function index(Request $request)
    {
        $Testimonial = Testimonial::orderBy('id', 'desc')->paginate(10);

        return view('testimonial.index', compact('Testimonial'));
    }

    public function create(Request $request)
    {
        $Data = array(
            'name' => $request->name,
            'description' => $request->description,
            'created_at' => date('Y-m-d H:i:s'),
            'strIP' => $request->ip()
        );
        DB::table('testimonial')->insert($Data);

        return back()->with('success', 'Testimonial Created Successfully.');
    }

    public function editview(Request $request, $id)
    {
        $data = Testimonial::where(['iStatus' => 1, 'isDelete' => 0, 'id' => $id])->first();

        echo json_encode($data);
    }

    public function update(Request $request)
    {
        $update = DB::table('testimonial')
            ->where(['iStatus' => 1, 'isDelete' => 0, 'id' => $request->id])
            ->update([
                'name' => $request->name,
                'description' => $request->description,
                'updated_at' => date('Y-m-d H:i:s')
            ]);

        return back()->with('success', 'Testimonial Updated Successfully.');
    }


    public function delete(Request $request)
    {
        DB::table('testimonial')->where(['iStatus' => 1, 'isDelete' => 0, 'id' => $request->id])->delete();

        return back()->with('success', 'Testimonial Deleted Successfully!.');
    }
}
