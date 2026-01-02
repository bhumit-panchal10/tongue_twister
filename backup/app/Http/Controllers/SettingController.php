<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    public function index(Request $request)
    {
        $Setting = Setting::orderBy('id', 'desc')->paginate(10);

        return view('setting.index', compact('Setting'));
    }

   
    public function editview(Request $request, $id)
    {
        $data = Setting::where(['iStatus' => 1, 'isDelete' => 0, 'id' => $id])->first();

        echo json_encode($data);
    }

    public function update(Request $request)
    {
        // dd($request);
        $img = "";
        if ($request->hasFile('logo')) {
            $root = $_SERVER['DOCUMENT_ROOT'];
            $image = $request->file('logo');
            $img = time() . '.' . $image->getClientOriginalExtension();
            $destinationpath = $root . '/tongue_twister/Setting/';
            if (!file_exists($destinationpath)) {
                mkdir($destinationpath, 0755, true);
            }
            $image->move($destinationpath, $img);
            $oldImg = $request->input('hiddenPhoto') ? $request->input('hiddenPhoto') : null;

            if ($oldImg != null || $oldImg != "") {
                if (file_exists($destinationpath . $oldImg)) {
                    unlink($destinationpath . $oldImg);
                }
            }
        } else {
            $oldImg = $request->input('hiddenPhoto');
            $img = $oldImg;
        }
        $update = DB::table('setting')
            ->where(['id' => $request->id])
            ->update([
                'sitename' => $request->sitename,
                'logo' => $img,
                'email' => $request->email,
                'created_at' => date('Y-m-d H:i:s'),
                'strIP' => $request->ip(),
            ]);

        return back()->with('success', 'Setting Updated Successfully.');
    }
}
