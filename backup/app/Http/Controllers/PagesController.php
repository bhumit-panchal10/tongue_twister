<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pages;

class PagesController extends Controller
{
    public function index()
    {
        try{
        $data = Pages::get();
        return view('pages.index', compact('data'));
        } catch (\Exception $e) {

        report($e);
 
        return false;
    }
    }

    public function edit($id)
    {
        try{
        $data = Pages::whereId($id)->get();
        return view('pages.edit', compact('data'));
        } catch (\Exception $e) {

        report($e);
 
        return false;
    }
    }

    public function update(Request $request)
    {
        try{
        $id=$request->id;

        $updateData = array(
            'Name' => $request->Name,
            'Title' => $request->Title,
            'Description' => $request->Description,
        );
        Pages::whereId($id)->update($updateData);
        $data = Pages::whereId($id)->get();

        return redirect()->route('pages.index')->with('success', 'Data Updated Successfully');
        } catch (\Exception $e) {

        report($e);
 
        return false;
    }
    }
}
