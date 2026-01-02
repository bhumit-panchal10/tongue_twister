<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attributes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AttributeController extends Controller
{
    public function index(Request $request)
    {
        $Attribute = Attributes::orderBy('id', 'desc')->paginate(env('PER_PAGE_COUNT'));

        return view('attribute.index', compact('Attribute'));
    }

    public function create(Request $request)
    {
        // dd($request);
        $Data = array(
            'name' => $request->name,
            'slug' => $request->slug,
            'display_as' => $request->display_as,
            'created_at' => date('Y-m-d H:i:s'),
        );
        //dd($Data);
        DB::table('attributes')->insert($Data);

        return back()->with('success', 'Attribute Created Successfully.');
    }

    public function editview(Request $request, $id)
    {
        $data = Attributes::where(['id' => $id])->first();

        echo json_encode($data);
    }

    public function update(Request $request)
    {
        $update = DB::table('attributes')
            ->where(['id' => $request->id])
            ->update([
                'name' => $request->name,
                'slug' => $request->slug,
                'display_as' => $request->display_as,
                'updated_at' => date('Y-m-d H:i:s')
            ]);

        return back()->with('success', 'Attribute Updated Successfully.');
    }


    public function delete(Request $request)
    {
        DB::table('attributes')->where(['id' => $request->id])->delete();

        return back()->with('success', 'Attribute Deleted Successfully!.');
    }
}
