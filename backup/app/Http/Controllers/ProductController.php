<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Productphotos;
use App\Models\CategoryMultiple;
use Illuminate\Support\Facades\DB;
use Image;
use App\Models\Attributes;
use App\Models\ProductAttributes;


class ProductController extends Controller
{
    public function index(Request $request)
    {
        $Product = Product::select(
            'product.productId',
            'product.categoryId',
            'product.productname',
            'product.rate',
            'product.weight',
            'product.iStatus',
            'AmountWithOutGST',
            // 'category.categoryId',
            // 'category.categoryname',
            // DB::raw("(select categoryname from category as cat where product.categoryId=cat.subcategoryid) as subcategoryname ")
            DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId ORDER BY product.productId  LIMIT 1) as photo')
        )
            ->orderBy('productId', 'desc')
            //->orderBy('product.productname', 'asc')
            ->where([ 'product.isDelete' => 0])
            ->when($request->searchProductName, function ($query) use ($request) {
				$query->where('product.productname','LIKE', '%' . $request->searchProductName .'%');
			})
			->when($request->searchCategoryId, function ($query) use ($request) {
				// $query->whereIn('product.categoryId', [$request->searchCategoryId]);
				$query->whereIn('product.productId', function ($query) use ($request) {
                    $query->select('multiplecategory.productid')
                        ->from('multiplecategory')
                        ->where('multiplecategory.categoryid', '=', $request->searchCategoryId);
                });
			})
// 			->whereIn('product.categoryId', function($query) use ($request){
// 				$query->select('category.categoryId')
// 				->from(with(new Category)->getTable())
// 				->where('category.categoryId','=',$request->searchCategoryId);
// 			})
            // ->join('category', 'product.categoryId', '=', 'category.categoryId')
            //->toSql();
            ->paginate(25);
        //     echo $request->searchCategoryId;
        //dd($Product);
        $categories = Category::where(['iStatus' => 1, 'isDelete' => 0])->orderBy("strSequence","asc")->get();
        // $Sql = DB::raw("SELECT categoryId,(select categoryname from category as cat where category.subcategoryid=cat.categoryId) as parentname,categoryname as name,photo as categoryphoto FROM `category`");
        $searchProductName = $request->searchProductName;
        $searchCategoryId = $request->searchCategoryId;
        return view('product.index', compact('Product','categories','searchProductName','searchCategoryId'));
    }

    public function createview()
    {
        $Category = Category::where('subcategoryid', 0)->orderBy('categoryId', 'desc')->get();

        return view('product.add', compact('Category'));
    }

    public function getsubcategory(Request $request)
    {
        $html = "";
        $SubCategory = Category::where(['iStatus' => 1, 'isDelete' => 0, 'subcategoryid' => $request->Category])->get();
        $html .= '<option value="" selected >Select Sub Category</option>';
        foreach ($SubCategory as $subcategory) {
            $html .= '<option value=' . $subcategory->categoryId . '>' . $subcategory->categoryname . '</option>';
        }

        echo $html;
    }
    
    public function getGST(Request $request){
        $category = Category::select('strGST')->whereIn('categoryId', $request->Category)->orderBy('strGST', 'desc')->limit(1)->first();
        echo $category->strGST;
    }
    
    public function create(Request $request)
    {
        $isFeatures = 0;
        if ($request->isFeatures == "on") {
            $isFeatures = 1;
        }
        $isTaxable = 0;
        $iGST = 0;
        $iGSTAmount = 0;
        $AmountWithGST = 0;
        if ($request->isTaxable == "on") {
            $isTaxable = 1;
            
            $iGST = $request->iGST;
            $iGSTAmount = round(($request->rate * $iGST) / 100);
            $AmountWithGST = $request->rate + $iGSTAmount;
        } else {
            $iGST = 0;
            $iGSTAmount = 0;
            $AmountWithGST = $request->rate;
        }
        
        
        $Data = array(
            // 'categoryId' => $request->categoryId,
            'subcategoryid' => $request->subcategoryid ?? 0,
            'productname' => $request->productname,
            'slugname' => $request->slugname,
            'rate' => $AmountWithGST ?? 0,
            'AmountWithOutGST' => $request->rate ?? 0,
            'iGST' => $iGST,
            'iGSTAmount' => $iGSTAmount,
            'weight' => $request->weight,
            'description' => $request->description,
            'meta_title' => $request->meta_title,
            'meta_keyword' => $request->meta_keyword,
            'meta_description' => $request->meta_description,
            'head' => $request->head,
            'body' => $request->body,
            'created_at' => date('Y-m-d H:i:s'),
            'isFeatures' => $isFeatures ?? 0,
            'isTaxable' => $isTaxable ?? 0,
            'isStock' => $request->isStock,
            'strIP' => $request->ip()
        );
        $InsetedId = DB::table('product')->insertGetId($Data);

       
            foreach ($request->file('photo') as $file) {
                $root = $_SERVER['DOCUMENT_ROOT'];
                $image = $request->file('photo');
                $imgName = time() . '_' . mt_rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
                $destinationPath = $root . '/tongue_twister/Product/Thumbnail/';
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }
                $img = Image::make($file->getRealPath());
                $img->resize(540, 720, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($destinationPath . '/' . $imgName);

                $destinationpath = $root . '/tongue_twister/Product/';
                $file->move($destinationpath, $imgName);

                $data = array(
                    'productid' => $InsetedId,
                    'strphoto' => $imgName,
                    'strIP' => $request->ip(),
                    'created_at' => date('Y-m-d H:i:s'),
                );
                DB::table('productphotos')->insert($data);
            }
        
          foreach ($request->categoryId as $category) {

                $category = array(
                    'productid' => $InsetedId,
                    'categoryid' => $category,
                    'strIP' => $request->ip(),
                    'created_at' => date('Y-m-d H:i:s'),
                );
                DB::table('multiplecategory')->insert($category);
            }

        return redirect()->route('product.index')->with('success', 'Product Created Successfully.');
    }

    public function GetSelectedSubCategory(Request $request)
    {
        //dd($request);

        $html = "";
        $SubCategory = Category::where(['iStatus' => 1, 'isDelete' => 0, 'subcategoryid' => $request->Category])->get();
        $html .= '<option value="" selected >Select Sub Category</option>';
        foreach ($SubCategory as $subcategory) {
            if ($request->SubCategory == $subcategory->categoryId) {
                $html .= '<option value=' . $subcategory->categoryId  . ' selected >' . $subcategory->categoryname . '</option>';
            } else {
                $html .= '<option value=' . $subcategory->categoryId . '>' . $subcategory->categoryname . '</option>';
            }
        }
        echo $html;
    }

    public function editview(Request $request, $id)
    {
        $Category = Category::where('subcategoryid', 0)->orderBy('categoryId', 'desc')->get();
        $product = Product::where(['iStatus' => 1, 'isDelete' => 0, 'productId' => $id])->first();
        
        $CategoryMultiple = CategoryMultiple::select(
            'multiplecategory.productid',
            'multiplecategory.categoryid',
            'category.categoryname',
            'category.categoryId'
        )
            ->orderBy('multiplecategory.id', 'DESC')
            ->join('category', 'multiplecategory.categoryid', '=', 'category.categoryId')
            ->where(['multiplecategory.iStatus' => 1, 'multiplecategory.isDelete' => 0, 'multiplecategory.productid' => $id])
            ->get();
        return view('product.edit', compact('product', 'Category', 'CategoryMultiple'));
    }

    public function getEditsubcategory(Request $request)
    {
        $html = "";
        $SubCategory = Category::where(['iStatus' => 1, 'isDelete' => 0, 'subcategoryid' => $request->Category])->get();
        $html .= '<option value="" selected >Select Sub Category</option>';
        foreach ($SubCategory as $subcategory) {
            $html .= '<option value=' . $subcategory->categoryId . '>' . $subcategory->categoryname . '</option>';
        }

        echo $html;
    }

    public function update(Request $request, $id)
    {
        $isFeatures = 0;
        if ($request->isFeatures == "on") {
            $isFeatures = 1;
        }
        $isTaxable = 0;
        $iGST = 0;
        $iGSTAmount = 0;
        $AmountWithGST = 0; 
        if ($request->isTaxable == "on" || $request->isTaxable == "1") {
            $isTaxable = 1;
            
            $iGST = $request->iGST;
            $iGSTAmount = round(($request->rate * $iGST) / 100);
            $AmountWithGST = $request->rate + $iGSTAmount;
        } else{
            $iGST = 0;
            $iGSTAmount = 0;
            $AmountWithGST = $request->rate;
        }
        // echo "<br />";
        // echo $iGST;
        // echo "<br />";
        // echo $iGSTAmount;
        // echo "<br />";
        // echo $AmountWithGST;
        // exit;
        $update = DB::table('product')
            ->where(['iStatus' => 1, 'isDelete' => 0, 'productId' => $id])
            ->update([
                // 'categoryId' => $request->categoryId,
                'subcategoryid' => $request->subcategoryid ?? 0,
                'productname' => $request->productname,
                'slugname' => $request->slugname,
                // 'rate' => $request->rate,
                'rate' => $AmountWithGST ?? 0,
                'AmountWithOutGST' => $request->rate ?? 0,
                'iGST' => $iGST,
                'iGSTAmount' => $iGSTAmount,
                'weight' => $request->weight,
                'description' => $request->description,
                'meta_title' => $request->meta_title,
                'meta_keyword' => $request->meta_keyword,
                'meta_description' => $request->meta_description,
                'head' => $request->head,
                'body' => $request->body,
                'isFeatures' => $isFeatures ?? 0,
                'isTaxable' => $isTaxable ?? 0,
                'isStock' => $request->isStock,
                'updated_at' => date('Y-m-d H:i:s')
            ]);

        
            $img = "";
            if ($request->hasFile('photo')) {
                foreach ($request->file('photo') as $file) {
                    $root = $_SERVER['DOCUMENT_ROOT'];
                    $image = $request->file('photo');
                    $imgName = time() . '_' . mt_rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
                    $destinationPath = $root . '/tongue_twister/Product/Thumbnail/';
                    if (!file_exists($destinationPath)) {
                        mkdir($destinationPath, 0755, true);
                    }
                    $img = Image::make($file->getRealPath());
                    $img->resize(540, 720, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save($destinationPath . '/' . $imgName);

                    $destinationpath = $root . '/tongue_twister/Product/';
                    $file->move($destinationpath, $imgName);

                    $data = array(
                        'productid' => $id,
                        'strphoto' => $imgName,
                        'strIP' => $request->ip(),
                        'created_at' => date('Y-m-d H:i:s'),
                    );
                    DB::table('productphotos')->insert($data);
                }
            }
        
        DB::table('multiplecategory')->where(['iStatus' => 1, 'isDelete' => 0, 'productid' => $id])->delete();

        foreach ($request->categoryId as $categorymultiple) {
            $category = array([
                'productid' => $id,
                'categoryId' => $categorymultiple,
                'strIP' => $request->ip(),
                'created_at' => date('Y-m-d H:i:s'),
            ]);
            DB::table('multiplecategory')->insert($category);
        }

        return redirect()->route('product.index')->with('success', 'Product Updated Successfully.');
    }

    //Product Index Page Delete
    public function delete(Request $request)
    {
        $delete = DB::table('productphotos')->where(['iStatus' => 1, 'isDelete' => 0, 'productid' => $request->productId])->get();

            $root = $_SERVER['DOCUMENT_ROOT'];
            $destinationpath = $root . '/tongue_twister/Product/';
            $destinationpath1 = $root . '/tongue_twister/Product/Thumbnail/';

            foreach ($delete as $deletes) {
                if (file_exists($destinationpath1 . $deletes->strphoto)) {
                    unlink($destinationpath1 . $deletes->strphoto);
                }
                if (file_exists($destinationpath . $deletes->strphoto)) {
                    unlink($destinationpath . $deletes->strphoto);
                }
            }
        
        DB::table('productphotos')->where(['iStatus' => 1, 'isDelete' => 0, 'productId' => $request->productId])->delete();

        DB::table('product')->where(['iStatus' => 1, 'isDelete' => 0, 'productId' => $request->productId])->delete();
        
        DB::table('multiplecategory')->where(['iStatus' => 1, 'isDelete' => 0, 'productid' => $request->productId])->delete();

        return redirect()->route('product.index')->with('success', 'Product Deleted Successfully!.');
    }

    //Product Image Delete In Edit Page
    public function productimage(Request $request, $id)
    {
        // dd($id);
        $delete = DB::table('productphotos')->where(['iStatus' => 1, 'isDelete' => 0, 'productphotosid' => $id])->first();

        if ($_SERVER['SERVER_NAME'] == "127.0.0.1") {
            $root = $_SERVER['DOCUMENT_ROOT'];
            $destinationpath = $root . '/Product/';
            $destinationpath1 = $root . '/Product/Thumbnail/';
            if (file_exists($destinationpath1 . $delete->strphoto)) {
                unlink($destinationpath1 . $delete->strphoto);
            }
            if (file_exists($destinationpath . $delete->strphoto)) {
                unlink($destinationpath . $delete->strphoto);
            }
        } else {
            $root = $_SERVER['DOCUMENT_ROOT'];
            $destinationpath = $root . '/tongue_twister/Product/';
            $destinationpath1 = $root . '/tongue_twister/Product/Thumbnail/';

            if (file_exists($destinationpath1 . $delete->strphoto)) {
                unlink($destinationpath1 . $delete->strphoto);
            }
            if (file_exists($destinationpath . $delete->strphoto)) {
                unlink($destinationpath . $delete->strphoto);
            }
        }
        DB::table('productphotos')->where(['iStatus' => 1, 'isDelete' => 0, 'productphotosid' => $id])->delete();

        echo 1;
    }

    //Product Photos Listing Page
    public function productphotos(Request $request, $id)
    {
        $datas = Productphotos::orderby('productphotosid', 'desc')->where(['iStatus' => 1, 'isDelete' => 0, 'productid' => $id])->paginate(5);

        return view('product.photoslist', compact('datas'));
    }

    //In Product Photos Listing Page Photo Delete
    public function productphotosdelete(Request $request)
    {
        $delete = DB::table('productphotos')->where(['iStatus' => 1, 'isDelete' => 0, 'productphotosid' => $request->productphotosid])->first();

        if ($_SERVER['SERVER_NAME'] == "127.0.0.1") {
            $root = $_SERVER['DOCUMENT_ROOT'];
            $destinationpath = $root . '/Product/';
            $destinationpath1 = $root . '/Product/Thumbnail/';
            if ($delete->strphoto) {
                unlink($destinationpath1  . $delete->strphoto);
            }
            if ($delete->strphoto) {
                unlink($destinationpath  . $delete->strphoto);
            }
        } else {
            $root = $_SERVER['DOCUMENT_ROOT'];
            $destinationpath = $root . '/tongue_twister/Product/';
            $destinationpath1 = $root . '/tongue_twister/Product/Thumbnail/';
            if ($delete->strphoto) {
                unlink($destinationpath1  . $delete->strphoto);
            }
            if ($delete->strphoto) {
                unlink($destinationpath  . $delete->strphoto);
            }
        }

        DB::table('productphotos')->where(['iStatus' => 1, 'isDelete' => 0, 'productphotosid' => $request->productphotosid])->delete();
        return back()->with('success', 'Product Photo Deleted Successfully!.');
    }
    
    public function product_attribute(Request $request, $id)
    {
        $Product = Product::orderBy('productId', 'desc')
            ->where(['product.iStatus' => 1, 'product.isDelete' => 0, 'product.productId' => $id])
            ->first();
            
        $ProductAttributes = ProductAttributes::select(
            'product_attributes.id',
            'product_attributes.product_id',
            'product_attributes.product_attribute_id',
            'product_attributes.product_attribute_weight',
            'product_attributes.product_attribute_price',
            'product_attributes.product_attribute_price_without_gst',
            'product_attributes.product_attribute_photo',
            'attributes.name'
        )
            ->orderBY('product_attributes.id', 'desc')
            ->where(['product_id' => $id])
            ->leftjoin('attributes', 'product_attributes.product_attribute_id', '=', 'attributes.id')
            ->paginate(25);
        // dd($ProductAttributes);
        $Attribute = Attributes::get();

        return view('product.attribute', compact('Product','Attribute', 'ProductAttributes', 'id'));
    }

    public function product_attribute_store(Request $request)
    {
        // dd($request);
        $img = "";
        if ($request->hasFile('product_attribute_photo')) {
            $root = $_SERVER['DOCUMENT_ROOT'];
            $image = $request->file('product_attribute_photo');
            $img = time() . '.' . $image->getClientOriginalExtension();
            $destinationpath = $root . '/tongue_twister/ProductAttribute/';
            if (!file_exists($destinationpath)) {
                mkdir($destinationpath, 0755, true);
            }
            $image->move($destinationpath, $img);
        }
        $Product = Product::orderBy('productId', 'desc')
            ->where(['product.iStatus' => 1, 'product.isDelete' => 0,"productId" => $request->productid])
            ->first();
        
        $product_attribute_gst = 0;
        $iGSTAmount = 0;
        $AmountWithGST = 0;
        if ($Product->isTaxable == "1") {
            $product_attribute_gst = $Product->iGST;
            $iGSTAmount = round(($request->product_attribute_price * $product_attribute_gst) / 100);
            $AmountWithGST = $request->product_attribute_price + $iGSTAmount;
        } else {
            $product_attribute_gst = 0;
            $iGSTAmount = 0;
            $AmountWithGST = $request->product_attribute_price;
        }
        $Data = array(
            'product_id' => $request->productid ?? 0,
            'product_attribute_id' => $request->product_attribute_id ?? 0,
            'product_attribute_weight' => $request->product_attribute_weight,
            'product_attribute_price' => $AmountWithGST,
            'product_attribute_gst' => $product_attribute_gst,
            'product_attribute_gst_amount' => $iGSTAmount,
            'product_attribute_price_without_gst' => $request->product_attribute_price,
            'product_attribute_photo' => $img,
            'created_at' => date('Y-m-d H:i:s'),
        );
        $InsetedId = DB::table('product_attributes')->insertGetId($Data);

        return redirect()->route('product.product_attribute', $request->productid)->with('success', 'Product Attribute Created Successfully.');
    }

    public function product_attribute_editview(Request $request, $id)
    {
        $ProductAttributes = ProductAttributes::where(['id' => $id])->first();

        echo json_encode($ProductAttributes);
    }

    public function product_attribute_update(Request $request)
    {
        // dd($request);
        $img = "";
        if ($request->hasFile('product_attribute_photo')) {
            $root = $_SERVER['DOCUMENT_ROOT'];
            $image = $request->file('product_attribute_photo');
            $img = time() . '.' . $image->getClientOriginalExtension();
            $destinationpath = $root . '/tongue_twister/ProductAttribute/';
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
        
        $product_attributes = DB::table('product_attributes')->where(['id' => $request->id])->first();
        
        $Product = Product::orderBy('productId', 'desc')
            ->where(['product.iStatus' => 1, 'product.isDelete' => 0,"productId" => $product_attributes->product_id])
            ->first();
        $product_attribute_gst = 0;
        $iGSTAmount = 0;
        $AmountWithGST = 0;
        if ($Product->isTaxable == "1") {
            $product_attribute_gst = $Product->iGST;
            $iGSTAmount = round(($request->product_attribute_price * $product_attribute_gst) / 100);
            $AmountWithGST = $request->product_attribute_price + $iGSTAmount;
        } else {
            $product_attribute_gst = 0;
            $iGSTAmount = 0;
            $AmountWithGST = $request->product_attribute_price;
        }

        $update = DB::table('product_attributes')
            ->where(['id' => $request->id])
            ->update([
                'product_attribute_id' => $request->product_attribute_id ?? 0,
                'product_attribute_weight' => $request->product_attribute_weight,
                // 'product_attribute_price' => $request->product_attribute_price,
                'product_attribute_price' => $AmountWithGST,
                'product_attribute_gst' => $product_attribute_gst,
                'product_attribute_gst_amount' => $iGSTAmount,
                'product_attribute_price_without_gst' => $request->product_attribute_price,
                'product_attribute_photo' => $img,
                'updated_at' => date('Y-m-d H:i:s')
            ]);

        return back()->with('success', 'Product Attribute Updated Successfully.');
    }

    public function product_attribute_delete(Request $request)
    {
        // dd($request);
        $delete = DB::table('product_attributes')->where(['id' => $request->id])->first();
        
        $root = $_SERVER['DOCUMENT_ROOT'];
        $destinationpath = $root . '/tongue_twister/ProductAttribute/';

        if ($delete->product_attribute_photo) {
            unlink($destinationpath  . $delete->product_attribute_photo);
        }
        
        DB::table('product_attributes')->where(['id' => $request->id])->delete();

        return back()->with('success', 'Product Attribute Deleted Successfully!.');
    }
    
    public function updateStatus($product_id, $status)
    {
        

        try {
            DB::beginTransaction();

            // Update Status
            Product::where('productId', $product_id)->update(['iStatus' => $status]);

            // Commit And Redirect on index with Success Message
            DB::commit();
            return redirect()->route('product.index')->with('success', 'Status Updated Successfully!');
        } catch (\Throwable $th) {

            // Rollback & Return Error Message
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
