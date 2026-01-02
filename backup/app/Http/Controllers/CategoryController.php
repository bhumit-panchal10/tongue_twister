<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        
         $Category = DB::table('category')
            ->select(
                'categoryId',
                DB::raw('(SELECT categoryname FROM category AS cat WHERE category.subcategoryid = cat.categoryId) AS parentname'),
                'strSequence',
                'categoryname AS name',
                'photo AS categoryphoto',
                'strGST',
                'iStatus'
            )
            ->orderBy('strSequence', 'asc')
            ->paginate(25);
      

        return view('category.index', compact('Category'));
    }

    public function create(Request $request)
    {
        $Category = Category::where('subcategoryid', 0)->orderBy('categoryId', 'desc')->get();
        return view('category.add', compact('Category'));
    }

    public function store(Request $request)
    {
        //dd($request);
        if ($_SERVER['SERVER_NAME'] == "127.0.0.1") {
            $img = "";
            if ($request->hasFile('photo')) {
                $root = $_SERVER['DOCUMENT_ROOT'];
                $image = $request->file('photo');
                $img = time() . '.' . $image->getClientOriginalExtension();
                $destinationpath = $root . '/Category/';
                if (!file_exists($destinationpath)) {
                    mkdir($destinationpath, 0755, true);
                }
                $image->move($destinationpath, $img);
            }
        } else {
            $img = "";
            if ($request->hasFile('photo')) {
                $root = $_SERVER['DOCUMENT_ROOT'];
                $image = $request->file('photo');
                $img = time() . '.' . $image->getClientOriginalExtension();
                $destinationpath = $root . '/tongue_twister/Category/';
                if (!file_exists($destinationpath)) {
                    mkdir($destinationpath, 0755, true);
                }
                $image->move($destinationpath, $img);
            }
        }

        $Data = array(
            'subcategoryid' => $request->subcategoryid ?? 0,
            'categoryname' => $request->categoryname,
            'slugname' => $request->slugname,
            'strSequence' => $request->strSequence,
            'strGST' => $request->strGST,
            'photo' => $img,
            'created_at' => date('Y-m-d H:i:s'),
            'strIP' => $request->ip(),
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
        );
        //dd($Data);
        DB::table('category')->insert($Data);

        return redirect()->route('category.index')->with('success', 'Category Created Successfully.');
    }

    public function editview(Request $request, $id)
    {
        $Category = Category::orderBy('categoryId', 'desc')->get();
        $data = Category::where(['iStatus' => 1, 'isDelete' => 0, 'categoryId' => $id])->first();
        //dd($data);
        return view('category.edit', compact('data', 'Category'));
    }

    public function update(Request $request, $id)
    {
        //dd($request);

        if ($_SERVER['SERVER_NAME'] == "127.0.0.1") {
            $img = "";
            if ($request->hasFile('photo')) {
                $root = $_SERVER['DOCUMENT_ROOT'];
                $image = $request->file('photo');
                $img = time() . '.' . $image->getClientOriginalExtension();
                $destinationpath = $root . '/Category/';
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
        } else {
            $img = "";
            if ($request->hasFile('photo')) {
                $root = $_SERVER['DOCUMENT_ROOT'];
                $image = $request->file('photo');
                $img = time() . '.' . $image->getClientOriginalExtension();
                $destinationpath = $root . '/tongue_twister/Category/';
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
        }

        $update = DB::table('category')
            ->where(['iStatus' => 1, 'isDelete' => 0, 'categoryId' => $id])
            ->update([
                'subcategoryid' => $request->subcategoryid ?? 0,
                'categoryname' => $request->categoryname,
                'strSequence' => $request->strSequence,
                'slugname' => $request->slugname,
                'strGST' => $request->strGST,
                'photo' => $img,
                'meta_title' => $request->meta_title,
                'meta_description' => $request->meta_description,
                'updated_at' => date('Y-m-d H:i:s')
            ]);

        return  redirect()->route('category.index')->with('success', 'Category Updated Successfully.');
    }


    public function delete(Request $request)
    {
        $delete = DB::table('category')->where(['iStatus' => 1, 'isDelete' => 0, 'categoryId' => $request->categoryId])->first();

        $root = $_SERVER['DOCUMENT_ROOT'];
        $destinationpath = $root . '/tongue_twister/Category/';
        if ($delete->photo) {
            unlink($destinationpath  . $delete->photo);
        }
        DB::table('category')->where(['iStatus' => 1, 'isDelete' => 0, 'categoryId' => $request->categoryId])->delete();
        
        // $Product = DB::table('product')->where(['iStatus' => 1, 'isDelete' => 0, 'categoryId' => $request->categoryId])->get();
        
        // DB::table('product')->where([ 'isDelete' => 0, 'categoryId' => $request->categoryId])->delete();
        
        // $deleteproductphotos = DB::table('productphotos')->where(['iStatus' => 1, 'isDelete' => 0, 'productid' => $Product->productId])->get();
        
        // $root = $_SERVER['DOCUMENT_ROOT'];
        // $destinationpathproduct = $root . '/Product/';
        // $destinationpathproduct1 = $root . '/Product/Thumbnail/';

        // foreach ($deleteproductphotos as $deleteproductphoto) {
        //     if (file_exists($destinationpathproduct1 . $deleteproductphoto->strphoto)) {
        //         unlink($destinationpathproduct1 . $deleteproductphoto->strphoto);
        //     }
        //     if (file_exists($destinationpathproduct . $deleteproductphoto->strphoto)) {
        //         unlink($destinationpathproduct . $deleteproductphoto->strphoto);
        //     }
        // }
        
        // DB::table('productphotos')->where(['iStatus' => 1, 'isDelete' => 0, 'productId' => $Product->productId])->delete();
        

        return back()->with('success', 'Category Deleted Successfully!.');
    }
    
     public function updateStatus($category_id, $status)
    {
        try {
            DB::beginTransaction();

            // Update Status
            Category::where('categoryId', $category_id)->update(['iStatus' => $status]);

            // Commit And Redirect on index with Success Message
            DB::commit();
            return redirect()->back()->with('success', 'Status Updated Successfully!');
        } catch (\Throwable $th) {

            // Rollback & Return Error Message
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
