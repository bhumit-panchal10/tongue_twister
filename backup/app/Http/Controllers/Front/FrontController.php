<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Customer;
use App\Models\CustomerCouponApplyed;
use App\Models\Gallery;
use App\Models\Offer;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\Pages;
use App\Models\ProductAttributes;
use App\Models\Productphotos;
use App\Models\Testimonial;
use App\Models\Shipping;
use App\Models\Faq;
use App\Models\State;
use App\Models\Wishlist;
use App\Models\Banner;
use App\Models\CategoryMultiple;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use PhpOffice\PhpSpreadsheet\Calculation\Token\Stack;
use App\Models\MetaData;

class FrontController extends Controller
{
    public function __construct()
    {
        // dd('__construct');
        Cache::flush();
    }

    public function index(Request $request)
    {
        //  dd($request);
        $seo = MetaData::where('id', '=', '1')->first();
        $AllCategory = Category::orderBy('categoryId', 'desc')->where(['iStatus' => 1, 'isDelete' => 0])->get();
        $Faq = Faq::orderBy('faqid', 'desc')->where(['iStatus' => 1, 'isDelete' => 0])->get();


        $Category = Category::orderBy('strSequence', 'asc')
            ->where(['iStatus' => 1, 'isDelete' => 0])
            ->get();
        // dd($Category);
        $Banner = Banner::select(
            'product.productname',
            'product.productId',
            'product.slugname',
            'banner.bannerId',
            'banner.strPhoto',
            'banner.iProductId',
            DB::raw('(SELECT slugname FROM category inner join multiplecategory on category.categoryId=multiplecategory.categoryid where multiplecategory.productid=product.productId ORDER BY product.productId  LIMIT 1) as categoryslug')
        )
            ->orderBy('banner.bannerId', 'desc')
            ->where(['banner.iStatus' => 1, 'banner.isDelete' => 0])
            ->leftjoin('product', 'banner.iProductId', '=', 'product.productId')
            ->get();

        $Product = Product::select(
            'product.productId',
            'product.productname',
            'product.rate',
            'product.weight',
            'product.description',
            'product.isStock',
            'product.slugname',
            DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId ORDER BY product.productId  LIMIT 1) as photo'),
            DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId ORDER BY product.productId LIMIT 1,1) as backphoto'),
            DB::raw('(SELECT slugname FROM category inner join multiplecategory on category.categoryId=multiplecategory.categoryid where multiplecategory.productid=product.productId ORDER BY product.productId  LIMIT 1) as categoryslug'),
            DB::raw('(SELECT category.categoryId FROM category inner join multiplecategory on category.categoryId=multiplecategory.categoryid where multiplecategory.productid=product.productId ORDER BY product.productId  LIMIT 1) as categoryId')
        )
            ->orderBy('productId', 'desc')->take(8)
            ->where(['iStatus' => 1, 'isDelete' => 0])
             ->whereIn('productId', function ($query) {
                $query->select('productid')
                    ->from('multiplecategory')
                    ->where('isDelete', 0)
                    ->where('iStatus', 1);
            })
            ->get();
        // dd($Product);
        // $AllCategory = Category::orderBy('categoryId', 'desc')->where(['iStatus' => 1, 'isDelete' => 0])->get();
        $Testimonial = Testimonial::orderBy('id', 'desc')->where(['iStatus' => 1, 'isDelete' => 0])->get();
        // $Industry = Industry::orderBy('industryid', 'desc')->where(['iStatus' => 1, 'isDelete' => 0])->get();
        // $OurClient = OurClient::orderBy('id', 'desc')->where(['iStatus' => 1, 'isDelete' => 0])->get();
        $ToDate = date('d-m-Y');
        $Offers = Offer::where(['iStatus' => 1, 'isDelete' => 0])
            ->where('enddate', '>=', date('Y-m-d 23:59:59', strtotime($ToDate)))->get();
        DB::commit();

        $tranding=Product::where(['product.iStatus' => 1, 'product.isDelete' => 0,'isFeatures'=>1])->count();
        return view('Front.index', compact('seo','Category', 'Product', 'Testimonial', 'AllCategory', 'Offers', 'Banner','tranding','Faq'));
    }

    public function about(Request $request)
    {
        $seo = MetaData::where('id', '=', '2')->first();
        $data = Pages::where('id', '=', '5')->first();
        $Faq = Faq::orderBy('faqid', 'desc')->where(['iStatus' => 1, 'isDelete' => 0])->get();
        $Testimonial = Testimonial::orderBy('id', 'desc')->where(['iStatus' => 1, 'isDelete' => 0])->get();
        $ToDate = date('d-m-Y');

        $Offers = Offer::where(['iStatus' => 1, 'isDelete' => 0])
            ->where('enddate', '>=', date('Y-m-d 23:59:59', strtotime($ToDate)))->get();
        DB::commit();
        return view('Front.about', compact('seo','data','Faq','Testimonial','Offers'));
    }


    public function contactus(Request $request)
    {
        $seo = MetaData::where('id', '=', '3')->first();
        return view('Front.contact', compact('seo'));
    }

    public function contact_us(Request $request)
    {
       $request->validate(
            [
                'name' => 'required',
                'email' => 'required',
                'mobile' => 'required|digits:10',
//                'captcha' => 'required|captcha'
            ]
        );
                
                $data = array(
                'name' => $request->name,
                'email' => $request->email,
                'mobileNumber' => $request->mobile,
                'message' => $request->message,
                "strIp" => $request->ip(),
                "created_at" => date('Y-m-d H:i:s')
            );
            // dd($data);
            DB::table('inquiry')->insert($data);

            $SendEmailDetails = DB::table('sendemaildetails')
                ->where(['id' => 4])
                ->first();
            // dd($SendEmailDetails);

            // $msg = array(
            //     'FromMail' => $SendEmailDetails->strFromMail,
            //     'Title' => $SendEmailDetails->strTitle,
            //     'ToEmail' => "dev1.apolloinfotech@gmail.com",
            //     'Subject' => $SendEmailDetails->strSubject
            // );
            $root = $_SERVER['DOCUMENT_ROOT'];
            $file = file_get_contents($root . '/tongue_twister/mailers/contactemail.html', 'r');
            //$file = file_get_contents("https://getdemo.in/mas_solutions/mailers/welcome-company.html", "r");
            $file = str_replace('#name', $data['name'], $file);
            $file = str_replace('#email', $data['email'], $file);
            $file = str_replace('#mobile', $data['mobileNumber'], $file);
            $file = str_replace('#message', $data['message'], $file);
            // dd($file);
            $setting = DB::table("setting")->select('email')->first();
            $toMail = $setting->email; // "shahkrunal83@gmail.com";//
            // $toMail = "dev2.apolloinfotech@gmail.com";

            $to = $toMail;
            $subject = $SendEmailDetails->strSubject;
            // dd($subject);
            $message = $file;
            // dd($message);
            $header = "From:" . $SendEmailDetails->strFromMail . "\r\n";
            //$header .= "Cc:afgh@somedomain.com \r\n";
            $header .= "MIME-Version: 1.0\r\n";
            $header .= "Content-type: text/html\r\n";

            $retval = mail($to, $subject, $message, $header);

            // $html = view('emails.contactemail', compact($data));
            // dd($file);
            // $mail = Mail::send('emails.contactemail', ['data' => $data], function ($message) use ($msg) {
            //     $message->from($msg['FromMail'], $msg['Title']);
            //     $message->to($msg['ToEmail'])->subject($msg['Subject']);
            // });
            DB::commit();
            // return back();
            // return view('Front.contactthankyou');
            return redirect()->route('contactthankyou');
    }

    public function product(Request $request, $id = null)
    {
        $seo = MetaData::where('id', '=', '32')->first();
        $HeaderSearch = $request->headersearch;
        $Category = Category::orderBy('categoryId', 'desc')->get();

        if ($id == null) {
            $Product = Product::select(
                'product.productId',
                'product.productname',
                'product.rate',
                'product.weight',
                'product.description',
                'product.isFeatures',
                'product.isStock',
                'product.slugname',
                DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId ORDER BY product.productId  LIMIT 1) as photo'),
                DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId ORDER BY product.productId LIMIT 1,1) as backphoto'),
                DB::raw('(SELECT slugname FROM category inner join multiplecategory on category.categoryId=multiplecategory.categoryid where multiplecategory.productid=product.productId ORDER BY product.productId  LIMIT 1) as categoryslug'),
                DB::raw('(SELECT category.categoryId FROM category inner join multiplecategory on category.categoryId=multiplecategory.categoryid where multiplecategory.productid=product.productId ORDER BY product.productId  LIMIT 1) as categoryId'),
            )
                ->orderBy('productId', 'desc')
                ->where(['product.iStatus' => 1, 'product.isDelete' => 0, 'product.isFeatures' => 0])
                 ->whereIn('categoryId', function ($query) {
                        $query->select('categoryId')
                            ->from('category')
                            ->where('isDelete', 0)
                            ->where('iStatus', 1);
                    })
                ->when($HeaderSearch, fn ($query, $HeaderSearch) => $query
                    ->where('product.productname', 'LIKE', '%' . $HeaderSearch . '%'))
                ->paginate(16);
            // dd($Product);
            $ProductCount = $Product->count();
        } else {
            $Product = Product::select(
                'product.productId',
                'product.productname',
                'product.rate',
                'product.weight',
                'product.description',
                'product.isFeatures',
                'product.isStock',
                'product.slugname',
                DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId ORDER BY product.productId  LIMIT 1) as photo'),
                DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId ORDER BY product.productId LIMIT 1,1) as backphoto'),
                DB::raw('(SELECT slugname FROM category inner join multiplecategory on category.categoryId=multiplecategory.categoryid where multiplecategory.productid=product.productId ORDER BY product.productId  LIMIT 1) as categoryslug'),
                DB::raw('(SELECT category.categoryId FROM category inner join multiplecategory on category.categoryId=multiplecategory.categoryid where multiplecategory.productid=product.productId ORDER BY product.productId  LIMIT 1) as categoryId'),
            )
                ->orderBy('productId', 'desc')
                ->where(['product.iStatus' => 1, 'product.isDelete' => 0, 'product.isFeatures' => 0, 'category.slugname' => $id, 'category.slugname' => $id,"category.iStatus"=>1 ,"category.isDelete"=>0])
                ->when($HeaderSearch, fn ($query, $HeaderSearch) => $query
                    ->where('product.productname', 'LIKE', '%' . $HeaderSearch . '%'))
                ->join('multiplecategory', 'product.productId', '=', 'multiplecategory.productid')
                ->join('category', 'multiplecategory.categoryid', '=', 'category.categoryId')
                ->paginate(16);
            $ProductCount = $Product->count();
        }
        // dd($Product);
        DB::commit();
        return view('Front.product', compact('Product', 'Category', 'id', 'ProductCount','seo'));
    }


    public function refreshCaptcha()
    {
        return response()->json(['captcha' => captcha_img()]);
    }

    public function productpopupview(Request $request, $id)
    {
        echo $this->ProductDetails($id);
    }

    public function ProductDetails($id)
    {
        $Product = Product::select(
            'product.productId',
            'product.productname',
            'product.rate',
            'product.weight',
            'product.description',
            'product.isStock',
            DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId  LIMIT 1) as photo'),
            DB::raw('(SELECT category.categoryId FROM category inner join multiplecategory on category.categoryId=multiplecategory.categoryid where multiplecategory.productid=product.productId ORDER BY product.productId  LIMIT 1) as categoryId'),
        )
            ->orderBy('productId', 'desc')
            ->where(['iStatus' => 1, 'isDelete' => 0, 'productId' => $id])
             ->whereIn('product.productId', function ($query) {
                    $query->select('multiplecategory.productid')
                        ->from('category')
                        ->join('multiplecategory','multiplecategory.productid','=','product.productId')
                        ->where('category.isDelete', 0)
                        ->where('category.iStatus', 1);
                })
            ->first();
        // dd($Product);
        $Attribute = ProductAttributes::select(
            'product_attributes.id',
            'product_attributes.product_id',
            'product_attributes.product_attribute_id',
            'product_attributes.product_attribute_weight',
            // 'product.productId',
        )
            ->where(['product_attributes.product_id' => $Product->productId])
            ->get();

        $Productphotos = Productphotos::where(['iStatus' => 1, 'isDelete' => 0, 'productid' => $id])->get();
        DB::commit();
        return view('Front.productpopupview', compact('Product', 'Productphotos', 'Attribute'));
    }

    public function checkout(Request $request)
    {
        $Coupon = $request->session()->get('data');

        $session = Session::get('customerid');

        $cartItems = \Cart::getContent();
        $Shipping = Shipping::orderBy('id', 'desc')->first();
        // $Coupon = CustomerCouponApplyed::where('customerId', "=", $id)->first();
        // dd($Coupon);
        DB::commit();
        $State = State::orderBy('stateName', 'asc')->get();

        return view('Front.checkout', compact('Shipping', 'Coupon', 'State'));
    }

    public function checkoutstore(Request $request)
    {
        $request->validate([
                'billFirstName' => 'required',
                'billLastName' => 'required',
                'billPhone' => 'required',
                'billEmail' => 'required',
                'billCompanyName' => 'required',
                'billCity' => 'required',
                'billState' => 'required',
                'billPinCode' => 'required',
                'billStreetAddress1' => 'required',
                 // Ensure 'billState' is required and a valid state ID
            ]);
        // dd($request);
        $random = Str::random(8);
        $password = Hash::make($random);;
        $cartItems = \Cart::getContent();
        // dd($cartItems);
        $Shipping = Shipping::orderBy('id', 'desc')->first();
        $ShippingCharges = $Shipping->rate;
        $amount = \Cart::getTotal();
        $netamount = $amount + $ShippingCharges;
        $Mobile = Customer::where(['isDelete' => 0, 'iStatus' => 1, 'customeremail' => $request->billEmail])->first();

        $customerid = 0;
        if ($Mobile == null) {
            $Order = array(
                'customername' => $request->billFirstName . ' ' . $request->billLastName,
                'password' => $password,
                'customermobile' => $request->billPhone,
                'customeremail' => $request->billEmail,
                'created_at' => date('Y-m-d H:i:s'),
                'strIP' => $request->ip()
            );
            $customerid = DB::table('customer')->insertGetId($Order);
        } else {
            $customerid = $Mobile->customerid;
        }




        $Order = array(
            'customerid' => $customerid,
            'shipping_cutomerName' => $request->billFirstName . ' ' . $request->billLastName,
            'shipping_companyName' => $request->billCompanyName,
            'shipping_mobile' => $request->billPhone,
            'shipping_email' => $request->billEmail,
            'shiiping_address1' => $request->billStreetAddress1,
            'shiiping_address2' => $request->billStreetAddress2,
            'shipping_city' => $request->billCity,
            'shiiping_state' => $request->billState,
            'shipping_pincode' => $request->billPinCode,
            'orderNote' => $request->billNotes,
            'amount' => $amount,
            'discount' => $request->discount,
            'shipping_Charges' => $request->shippingcharges,
            'netAmount' => $request->netamount,
            'created_at' => date('Y-m-d H:i:s'),
            'strIP' => $request->ip()
        );
        $OrderId = DB::table('order')->insertGetId($Order);

        foreach ($cartItems as $cartItem) {
            $OrderDetail = array(
                'orderID' => $OrderId,
                'customerid' => $customerid,
                'productId' => $cartItem->id,
                'quantity' => $cartItem->quantity,
                'weight' => $cartItem->weight,
                'rate' => $cartItem->price,
                'amount' => $cartItem->price * $cartItem->quantity,
                'isPayment' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                "strIP" => $request->ip()
            );
            DB::table('orderdetail')->insert($OrderDetail);
        }

        // $SendEmailDetails = DB::table('sendemaildetails')
        //     ->where(['id' => 9])
        //     ->first();

        // $msg = array(
        //     'FromMail' => $SendEmailDetails->strFromMail,
        //     'Title' => $SendEmailDetails->strTitle,
        //     'ToEmail' => "dev2.apolloinfotech@gmail.com",
        //     'Subject' => $SendEmailDetails->strSubject
        // );
        // // dd($msg);

        // $mail = Mail::send('emails.checkoutmail', ['Order' => $Order], function ($message) use ($msg) {
        //     $message->from($msg['FromMail'], $msg['Title']);
        //     $message->to($msg['ToEmail'])->subject($msg['Subject']);
        // });
        $state = State::select('stateName')->where(['stateId' => $request->billState])->orderBy('stateName', 'asc')->first();
        $Order['stateName'] = $state->stateName ?? '';
        //\Cart::clear();
        return redirect()->route('razorpay.index', $OrderId);
        // return back();
        //return view('Front.dataFrom', compact('Order', 'OrderId'));
    }

    public function couponcodeapply(Request $request)
    {
        
        $session = Session::get('customerid');
        // dd($session);
        $Offer = Offer::where(['iStatus' => 1, 'isDelete' => 0, 'offercode' => $request->coupon])->first();
        if($Offer != null)
        {
                // dd($Offer);
                $CouponApply = CustomerCouponApplyed::where(['customerId' => $session, 'offerId' => $Offer->id])->count();
                // dd($CouponApply);
                $Today = date('Y-m-d');
                $Coupon = $request->coupon ?? "";
                $Total = $request->totalAmount ?? 0;
                $Percentage = $Offer->type ?? null;
                $OfferCode = $Offer->offercode ?? null;
        
                // echo $Offer->enddate;
                // dd($Offer->startdate);
        
                // if ($CouponApply <= 0) {
                if ($Coupon == $OfferCode) {
                    if ($Total >= $Offer->minvalue) {
                        // dd('mainif');
                        // 2023-10-05 >= 2023-10-02 && 2023-10-05  <= 2023-10-07
                        if (($Today >= $Offer->startdate) && ($Today <= $Offer->enddate)) {
        
                            $result = (($Total * 1)) * (($Percentage * 1) / (100 * 1));
                            $resultround = round($result);
                            $data = array(
                                'offerId' => $Offer->id,
                                'customerId' => $session ?? 0,
                                'result' => $resultround,
                                'created_at' => date('Y-m-d H:i:s'),
                                "strIP" => $request->ip()
                            );
                            $Coupon = CustomerCouponApplyed::create($data);
        
                            return redirect()->route('checkout')->with([
                                'success' => 'Coupon Code Apply Successfully!',
                                'data' => $Coupon
                            ]);
                        } else {
                            return redirect()->back()->with('error', 'Coupon is expired!');
                        }
                    } else {
                        return redirect()->back()->with('error', 'Please Enter Min Value!'.$Offer->minvalue);
                    }
                } else {
                    return redirect()->back()->with('error', 'Coupon Code Not Match!');
                }
                
         } else {
             return redirect()->back()->with('error', 'Invalid Coupon Code!');
         }
    }

    public function ccavRequestHandler()
    {
        return view('Front.ccavRequestHandler');
    }

    public function payment_success()
    {
        return view('Front.payment_success');
    }

    public function payment_fail()
    {
        return view('Front.payment_fail');
    }

    public function frontlogin(Request $request)
    {
        // dd('login');
        return view('Front.login');
    }

    public function frontloginstore(Request $request)
    {
        $request->validate(
            [
                'customeremail' => 'required',
                'password' => 'required',
            ],
            [
                'customeremail.required' => 'Email is required!',
                'password.required' => 'Password is required!',
            ]
        );

        $credentials = $request->only('customeremail', 'password');
        $Customer = Customer::where('customeremail', $request->get('customeremail'))->first();

        if (isset($Customer) && (!empty($Customer))) {
            if (Hash::check($request->password, $Customer->password)) {
                $request->session()->put('customerid', $Customer->customerid);
                $request->session()->put('customername', $Customer->customername);
                $request->session()->put('customermobile', $Customer->customermobile);
                $request->session()->put('customeremail', $Customer->customeremail);
                return redirect()->route('FrontIndex');
            } else {
                return back()->with('error', 'Password Not Match');
            }
        } else {
            return back()->with('error', 'Email Is Not Registered');
        }
    }

    public function register(Request $request)
    {
        // dd('register');
        return view('Front.register');
    }

    public function registerstore(Request $request)
    {
        // dd($request);
        $request->validate(
            [
                'customername' => 'required',
                'customeremail' => 'required|unique:customer,customeremail',
                'customermobile' => 'required|unique:customer,customermobile|numeric|digits:10',
                //  'captcha' => 'required|captcha',
                // 'password' => 'required|confirmed',
                // 'confirmpassword' => 'required',
            ],
            [
                // 'captcha.required' => 'Captcha is required!',
                // 'captcha.captcha' => 'Invalid captcha code!',
                'customername.required' => 'Name is required!',
                'customeremail.required' => 'Email is required!',
                'customeremail.unique'    => 'Email is already used!',
                'customermobile.required' => 'Mobile is required!',
                'customermobile.unique'    => 'Mobile is already used!',
                'customermobile.numeric'    => 'Mobile is only numeric allowed!',
                'customermobile.digits'    => 'Mobile is only 10 digits allowed!',
                // 'password.required' => 'Password is required!',
                // 'password.confirmed' => 'Password And Confirm Password Not Match!',
                // 'confirmpassword.required' => 'Confirm Password is required!',
            ]
        );

        $password = $request->password;
        $confirmpass = $request->confirmpassword;

       // $userInput = $request->input('captcha');
        //$captcha = session('captcha');

        // if ($userInput === $captcha) {
            if ($password == $confirmpass) {
                $Data = array(
                    'customername' => $request->customername,
                    'customermobile' => $request->customermobile,
                    'customeremail' => $request->customeremail,
                    'password' => Hash::make($password),
                    'created_at' => date('Y-m-d H:i:s'),
                    "strIP" => $request->ip()
                );
                DB::table('customer')->insert($Data);

                return redirect()->route('FrontLogin')->with('success', 'Register Successfully!');
            } else {
                return back()->with('error', 'Something Went Wrong!');
            }
       /* } else {
            // return back()->with('invalidcaptcha', 'Invalid captcha code!');
            return redirect()->route('register')->with('invalidcaptcha', 'Invalid captcha code!');
        }*/
    }

    //Forgot Password Page
    public function forgotpassword(Request $request)
    {
        return view('Front.forgotpassword');
    }


    //send mail for new pass
    public function forgotpasswordsubmit(Request $request)
    {
        $Customer = DB::table('customer')->where(['customeremail' => $request->customeremail, 'iStatus' => 1, 'isDelete' => 0])->first();

        if (!empty($Customer)) {
            $token = Str::random(64);
            $data = array(
                'customeremail' => $request->customeremail,
                'fetch' => $Customer,
                'token' => $token,
            );
            $update = DB::table('customer')
                ->where(['iStatus' => 1, 'isDelete' => 0, 'customerid' => $Customer->customerid])
                ->update([
                    'token' => $token,
                ]);

            $SendEmailDetails = DB::table('sendemaildetails')
                ->where(['id' => 8])
                ->first();
            $sendmail = $request->customeremail;
            $msg = array(
                'FromMail' => $SendEmailDetails->strFromMail,
                'Title' => $SendEmailDetails->strTitle,
                'ToEmail' => $request->customeremail,
                'Subject' => $SendEmailDetails->strSubject
            );

            $root = $_SERVER['DOCUMENT_ROOT'];
            $file = file_get_contents($root . '/tongue_twister/mailers/forgetpassword.html', 'r');
            $file = str_replace('#name', $data['fetch']->customername, $file);
            $file = str_replace('#email', 'https://getdemo.in/tongue_twister/New-Password/' . $token, $file);
            // dd($file);
            $setting = DB::table("setting")->select('email')->first();
            $toMail = $sendmail; //$setting->email;// "shahkrunal83@gmail.com";//
            // dd($toMail);
            $to = $toMail;
            $subject = $SendEmailDetails->strSubject;
            $message = $file;
            $header = "From:" . $SendEmailDetails->strFromMail . "\r\n";
            //$header .= "Cc:afgh@somedomain.com \r\n";
            $header .= "MIME-Version: 1.0\r\n";
            $header .= "Content-type: text/html\r\n";

            $retval = mail($to, $subject, $message, $header);


            // $mail = Mail::send('emails.forgetpassword', ['data' => $data], function ($message) use ($msg) {
            //     $message->from($msg['FromMail'], $msg['Title']);
            //     $message->to($msg['ToEmail'])->subject($msg['Subject']);
            // });

            return back()->with('success', 'We have emailed your password reset link!');
        } else {
            return back()->with('error', 'Email Is Not Registered');
        }
    }

    public function newpassword(Request $request, $token)
    {
        return view('Front.newpassword', ['token' => $token]);
    }

    public function newpasswordsubmit(Request $request)
    {
        $newpassword = $request->newpassword;
        $confirmpassword = $request->confirmpassword;

        $Customer = DB::table('customer')->where(['token' => $request->token, 'iStatus' => 1, 'isDelete' => 0])->first();


        if ($Customer->token == $request->token) {
            if ($newpassword == $confirmpassword) {
                $Student = DB::table('customer')
                    ->where(['iStatus' => 1, 'isDelete' => 0, 'customerid' => $Customer->customerid])
                    ->update([
                        'password' => Hash::make($request->confirmpassword),
                        'token' => null,
                    ]);
                return redirect()->route('FrontLogin')->with('success', 'Your password has been successfully changed!');
            } else {
                return back()->with('error', 'Password And Confirm Password Does Not Match.');
            }
        } else {
            return back()->with('error', 'Token Not Match.');
        }
    }

    public function profile(Request $request)
    {
        if ($request->session()->get('customerid') != "") {
            return view('Front.profile');
        } else {
            return redirect()->route('FrontLogin')->with('error', 'Invalid Email or Password');
        }
    }

    public function myaccount(Request $request)
    {
        if ($request->session()->get('customerid') != "") {
            return view('Front.myaccount');
        } else {
            return redirect()->route('FrontLogin')->with('error', 'Invalid Email or Password');
        }
    }

    public function myaccountedit(Request $request)
    {
        $session = Session::get('customerid');
        $request->session()->forget('customername');
        $request->session()->forget('customeremail');
        $request->session()->forget('customermobile');
        // dd($session);

        $request->validate(
            [
                'customeremail' => 'unique:customer,customeremail,' . $session . ',customerid',
                'customermobile' => 'required|unique:customer,customermobile,' . $session . ',customerid'
            ],
            [
                'customeremail.unique'    => 'Email is already used!',
                'customermobile.unique'    => 'Mobile is already used!',
            ]
        );

        $update = DB::table('customer')
            ->where(['iStatus' => 1, 'isDelete' => 0, 'customerid' => $session])
            ->update([
                'customername' => $request->customername,
                'customeremail' => $request->customeremail,
                'customermobile' => $request->customermobile,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        // dd($update);
        $request->session()->put('customername', $request->customername);
        $request->session()->put('customeremail', $request->customeremail);
        $request->session()->put('customermobile', $request->customermobile);

        return back()->with('myaccountupdatesuccess', 'Profile Updated Successfully!');
    }

    public function changepassword(Request $request)
    {
        if ($request->session()->get('customerid') != "") {
            return view('Front.changepassword');
        } else {
            return redirect()->route('FrontLogin')->with('error', 'Invalid Email or Password');
        }
    }

    public function changepasswordsubmit(Request $request)
    {
        $session = Session::get('customerid');
        $newpassword = $request->newpassword;
        $confirmpassword = $request->confirmpassword;

        if ($newpassword == $confirmpassword) {
            $Student = DB::table('customer')
                ->where(['iStatus' => 1, 'isDelete' => 0, 'customerid' => $session])
                ->update([
                    'password' => Hash::make($request->confirmpassword),
                ]);
            return back()->with('passwordsuccess', 'Change Password Successfully!');
        } else {
            return back()->with('passworderror', 'Password And Confirm Password Not Match!');
        }
    }

    public function myorders(Request $request)
    {

        if ($request->session()->get('customerid') != "") 
        {
            $session = Session::get('customerid');
            $Order = Order::where(['order.iStatus' => 1, 'order.isDelete' => 0, 'order.customerid' => $session])
                // ->join('product', 'orderdetail.productId', '=', 'product.productId')
                ->paginate(10);
            // dd($Order);
            return view('Front.order', compact('Order'));
        } else {
            return redirect()->route('FrontLogin')->with('error', 'Invalid Email or Password');
        }
    }

    public function myordersdetails(Request $request, $id)
    {
        // dd($request->session());
        if ($request->session()->get('customerid') != "") {
            $session = Session::get('customerid');
            $Order = OrderDetail::select(
                'orderdetail.productId',
                'orderdetail.orderID',
                'orderdetail.created_at',
                'orderdetail.quantity',
                'orderdetail.weight',
                'orderdetail.rate',
                'orderdetail.amount',
                'product.productname',
                DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId  LIMIT 1) as photo'),
                DB::raw('(SELECT iCustomerId FROM  review WHERE  review.product_id=product.productId  LIMIT 1) as rcustomerId'),
            )
                ->where(['orderdetail.iStatus' => 1, 'orderdetail.isDelete' => 0, 'orderdetail.customerid' => $session, 'orderdetail.orderID' => $id])
                ->join('product', 'orderdetail.productId', '=', 'product.productId')
                ->get();

            $Orderdata = Order::select('order.*',DB::raw('(SELECT order_id FROM card_payment WHERE order.order_id=card_payment.oid LIMIT 1) as orderId'))->where(['iStatus' => 1, 'isDelete' => 0, 'customerid' => $session,'order_id'=>$id])->first();


            return view('Front.order-detail', compact('Order','Orderdata'));
        } else {
            return redirect()->route('FrontLogin')->with('error', 'Invalid Email or Password');
        }
    }

    public function mywishlistpage(Request $request)
    {
        if ($request->session()->get('customerid') != "") {
            $session = Session::get('customerid');
            $wishlist = wishlist::select(
                'product.productId',
                'product.productname',
                'product.rate',
                'product.weight',
                DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId  LIMIT 1) as photo'),
                DB::raw('(SELECT category.categoryId FROM category inner join multiplecategory on category.categoryId=multiplecategory.categoryid where multiplecategory.productid=product.productId ORDER BY product.productId  LIMIT 1) as categoryId'),
            )
                ->orderBY('id', 'desc')
                ->where(['wishlist.iStatus' => 1, 'wishlist.isDelete' => 0, 'wishlist.customerid' => $session])
                ->join("product", "wishlist.productid", '=', 'product.productId')
                ->get();
            // dd($wishlist);

            return view('Front.mywishlist', compact('wishlist'));
        } else {
            return redirect()->route('FrontLogin')->with('error', 'Invalid Email or Password');
        }
    }

    public function addwishlist(Request $request)
    {
        $session = Session::get('customerid');
        $wishlist = Wishlist::where(['wishlist.iStatus' => 1, 'wishlist.isDelete' => 0, 'wishlist.customerid' => $session, 'productid' => $request->productid])
            ->count();

        if (isset($session) && (!empty($session))) {
            if ($wishlist == 0) {
                $data = array(
                    "customerid" => $session,
                    "productid" => $request->productid,
                );
                wishlist::create($data);
                return back()->with('wishlistsuccess', 'Product Added To Wishlist!');
            } else {
                return back()->with('wishlisterror', 'Product Is Already In Your Wishlist');
            }
        } else {
            return redirect()->route('FrontLogin');
        }
    }

    public function isfeatures(Request $request, $id = null)
    {
        $seo = MetaData::where('id', '=', '33')->first();
        $Category = Category::orderBy('categoryId', 'desc')->get();
        // dd($id);
        if ($id == null) {
            $Product = Product::select(
                'product.productId',
                'product.productname',
                'product.rate',
                'product.weight',
                'product.description',
                'product.isFeatures',
                'product.isStock',
                'product.slugname',
                DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId ORDER BY product.productId  LIMIT 1) as photo'),
                DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId ORDER BY product.productId LIMIT 1,1) as backphoto'),
                DB::raw('(SELECT slugname FROM category inner join multiplecategory on category.categoryId=multiplecategory.categoryid where multiplecategory.productid=product.productId ORDER BY product.productId  LIMIT 1) as categoryslug'),
                DB::raw('(SELECT category.categoryId FROM category inner join multiplecategory on category.categoryId=multiplecategory.categoryid where multiplecategory.productid=product.productId ORDER BY product.productId  LIMIT 1) as categoryId'),
            )
                ->orderBy('productId', 'desc')
                ->where(['product.iStatus' => 1, 'product.isDelete' => 0, 'product.isFeatures' => 1])
                 ->whereIn('categoryId', function ($query) {
                    $query->select('categoryId')
                        ->from('category')
                        ->where('isDelete', 0)
                        ->where('iStatus', 1);
                })
                ->paginate(10);
            $ProductCount = $Product->count();
           
        } else {
            $Product = Product::select(
                'product.productId',
                'product.productname',
                'product.rate',
                'product.weight',
                'product.description',
                'product.isFeatures',
                'product.isStock',
                'product.slugname',
                DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId ORDER BY product.productId  LIMIT 1) as photo'),
                DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId ORDER BY product.productId LIMIT 1,1) as backphoto'),
                DB::raw('(SELECT slugname FROM category inner join multiplecategory on category.categoryId=multiplecategory.categoryid where multiplecategory.productid=product.productId ORDER BY product.productId  LIMIT 1) as categoryslug'),
                DB::raw('(SELECT category.categoryId FROM category inner join multiplecategory on category.categoryId=multiplecategory.categoryid where multiplecategory.productid=product.productId ORDER BY product.productId  LIMIT 1) as categoryId'),
            )
                ->orderBy('productId', 'desc')
                ->where(['product.iStatus' => 1, 'product.isDelete' => 0, 'product.isFeatures' => 1, 'category.slugname' => $id, 'category.slugname' => $id,"category.iStatus"=>1 ,"category.isDelete"=>0])
                 
                ->join('multiplecategory', 'product.productId', '=', 'multiplecategory.productid')
                ->join('category', 'multiplecategory.categoryid', '=', 'category.categoryId')
                ->paginate(16);
            $ProductCount = $Product->count();    
        }

        // dd($Product);

        return view('Front.isFeatures', compact('Product', 'Category', 'ProductCount', 'id','seo'));
    }

    public function searchfeaturesproduct(Request $request)
    {
        // dd($request);
        $product = Product::select(
            'product.productId',
            'product.productname',
            'product.rate',
            'product.weight',
            'product.description',
            'product.isFeatures',
            DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId ORDER BY product.productId  LIMIT 1) as photo'),
            DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId ORDER BY product.productId LIMIT 1,1) as backphoto'),
            DB::raw('(SELECT slugname FROM category inner join multiplecategory on category.categoryId=multiplecategory.categoryid where multiplecategory.productid=product.productId ORDER BY product.productId  LIMIT 1) as categoryslug'),
            DB::raw('(SELECT category.categoryId FROM category inner join multiplecategory on category.categoryId=multiplecategory.categoryid where multiplecategory.productid=product.productId ORDER BY product.productId  LIMIT 1) as categoryId'),
        )
            ->where(['product.iStatus' => 1, 'product.isDelete' => 0, 'product.isFeatures' => 1])
             ->whereIn('categoryId', function ($query) {
                $query->select('categoryId')
                    ->from('category')
                    ->where('isDelete', 0)
                    ->where('iStatus', 1);
            })
            ->paginate(16);

        if ($request->keyword != '') {
            $product = Product::select(
                'product.productId',
                'product.productname',
                'product.rate',
                'product.weight',
                'product.description',
                'product.isFeatures',
                DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId ORDER BY product.productId  LIMIT 1) as photo'),
                DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId ORDER BY product.productId LIMIT 1,1) as backphoto'),
                DB::raw('(SELECT slugname FROM category inner join multiplecategory on category.categoryId=multiplecategory.categoryid where multiplecategory.productid=product.productId ORDER BY product.productId  LIMIT 1) as categoryslug'),
                DB::raw('(SELECT category.categoryId FROM category inner join multiplecategory on category.categoryId=multiplecategory.categoryid where multiplecategory.productid=product.productId ORDER BY product.productId  LIMIT 1) as categoryId'),
            )
                ->where('productname', 'LIKE', '%' . $request->keyword . '%')
                ->where(['product.iStatus' => 1, 'product.isDelete' => 0, 'product.isFeatures' => 1])
                 ->whereIn('categoryId', function ($query) {
                    $query->select('categoryId')
                        ->from('category')
                        ->where('isDelete', 0)
                        ->where('iStatus', 1);
                })
                ->get();
        }
        return response()->json([
            'product' => $product
        ]);
    }

    public function searchproduct(Request $request)
    {
        // dd($request);
//\DB::enableQueryLog(); // Enable query log

       $Product = Product::select(
        'product.productId',
        'product.categoryId',
        'product.productname',
        'product.rate',
        'product.weight',
        'product.description',
        'product.isFeatures',
        'product.slugname',
        'product.isStock',
        DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId ORDER BY product.productId  LIMIT 1) as photo'),
        DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId ORDER BY product.productId LIMIT 1,1) as backphoto'),
        DB::raw('(SELECT slugname FROM category INNER JOIN multiplecategory ON category.categoryId=multiplecategory.categoryid WHERE multiplecategory.productid=product.productId ORDER BY product.productId LIMIT 1) as categoryslug'),
        DB::raw('(SELECT category.categoryId FROM category INNER JOIN multiplecategory ON category.categoryId=multiplecategory.categoryid WHERE multiplecategory.productid=product.productId ORDER BY product.productId LIMIT 1) as categoryId')
    )
    ->orderBy('product.productId', 'desc')
    ->when($request->searchProduct, fn ($query, $HeaderSearch) => $query->where('product.productname', 'LIKE', '%' . $HeaderSearch . '%'))
    ->when($request->category, function ($query, $categoryId) {
        $query->whereIn('product.productId', function ($query) use ($categoryId) {
            $query->select('productid')
                ->from('multiplecategory')
                ->where('categoryid', $categoryId);
        });
    })
    ->paginate(16);
    $categorysearch=$request->category;
    $search=$request->searchProduct;
        
        return view('Front.product',compact('Product','categorysearch','search'));
        // return response()->json([
        //     'product' => $product,

        // ]);
    }



    public function searchhomeproduct(Request $request)
    {
        // dd($request);
        $product = Product::select(
            'product.productId',
            'product.productname',
            'product.rate',
            'product.weight',
            'product.description',
            'product.isFeatures',
            'product.slugname',
            DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId ORDER BY product.productId  LIMIT 1) as photo'),
            DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId ORDER BY product.productId LIMIT 1,1) as backphoto'),
            DB::raw('(SELECT slugname FROM category inner join multiplecategory on category.categoryId=multiplecategory.categoryid where multiplecategory.productid=product.productId ORDER BY product.productId  LIMIT 1) as categoryslug'),
            DB::raw('(SELECT category.categoryId FROM category inner join multiplecategory on category.categoryId=multiplecategory.categoryid where multiplecategory.productid=product.productId ORDER BY product.productId  LIMIT 1) as categoryId'),
        )
            ->orderBy('productId', 'desc')->take(8)
            ->where(['product.iStatus' => 1, 'product.isDelete' => 0, 'product.isFeatures' => 0])
            //  ->whereIn('categoryId', function ($query) {
            //     $query->select('categoryId')
            //         ->from('category')
            //         ->where('isDelete', 0)
            //         ->where('iStatus', 1);
            // })
            ->whereIn('product.productId', function ($query) {
                        $query->select('multiplecategory.productid')
                            ->from('category')
                            ->join('multiplecategory','multiplecategory.productid','=','product.productId')
                            //->where('multiplecategory.productid','=','product.productId')
                            ->where('category.isDelete', 0)
                            ->where('category.iStatus', 1);
                    })
            ->get();



        if ($request->keyword != '') {
            $product = Product::select(
                'product.productId',
                'product.productname',
                'product.rate',
                'product.weight',
                'product.description',
                'product.isFeatures',
                'product.slugname',
                DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId ORDER BY product.productId  LIMIT 1) as photo'),
                DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId ORDER BY product.productId LIMIT 1,1) as backphoto'),
                DB::raw('(SELECT slugname FROM category inner join multiplecategory on category.categoryId=multiplecategory.categoryid where multiplecategory.productid=product.productId ORDER BY product.productId  LIMIT 1) as categoryslug'),
                DB::raw('(SELECT category.categoryId FROM category inner join multiplecategory on category.categoryId=multiplecategory.categoryid where multiplecategory.productid=product.productId ORDER BY product.productId  LIMIT 1) as categoryId'),
            )
                ->orderBy('productId', 'desc')->take(8)
                ->where('productname', 'LIKE', '%' . $request->keyword . '%')
                ->where(['product.iStatus' => 1, 'product.isDelete' => 0])
                //  ->whereIn('categoryId', function ($query) {
                //         $query->select('categoryId')
                //             ->from('category')
                //             ->where('isDelete', 0)
                //             ->where('iStatus', 1);
                //     })
                ->whereIn('product.productId', function ($query) {
                        $query->select('multiplecategory.productid')
                            ->from('category')
                            ->join('multiplecategory','multiplecategory.productid','=','product.productId')
                            //->where('multiplecategory.productid','=','product.productId')
                            ->where('category.isDelete', 0)
                            ->where('category.iStatus', 1);
                    })
                ->get();
            // dd($product);
        }
        return response()->json([
            'product' => $product
        ]);
    }

    public function category(Request $request, $id = null)
    {
        // dd($id);
        if ($id == null) {
            // dd('if');
            $Product = Product::select(
                'product.productId',
                'product.productname',
                'product.rate',
                'product.weight',
                'product.description',
                'product.isFeatures',
                DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId ORDER BY product.productId  LIMIT 1) as photo'),
                DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId ORDER BY product.productId LIMIT 1,1) as backphoto'),
                DB::raw('(SELECT category.categoryId FROM category inner join multiplecategory on category.categoryId=multiplecategory.categoryid where multiplecategory.productid=product.productId ORDER BY product.productId  LIMIT 1) as categoryId'),
            )->orderBy('productId', 'desc')
                ->where(['product.iStatus' => 1, 'product.isDelete' => 0, 'product.isFeatures' => 0])
                 ->whereIn('categoryId', function ($query) {
                $query->select('categoryId')
                    ->from('category')
                    ->where('isDelete', 0)
                    ->where('iStatus', 1);
            })
                ->paginate(10);
        } else {
            // dd('else');

            $Product = Product::select(
                'product.productId',
                'product.productname',
                'product.rate',
                'product.weight',
                'product.description',
                'product.isFeatures',
                DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId ORDER BY product.productId  LIMIT 1) as photo'),
                DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId ORDER BY product.productId LIMIT 1,1) as backphoto'),
                DB::raw('(SELECT category.categoryId FROM category inner join multiplecategory on category.categoryId=multiplecategory.categoryid where multiplecategory.productid=product.productId ORDER BY product.productId  LIMIT 1) as categoryId'),
            )->orderBy('productId', 'desc')
                ->where(['product.iStatus' => 1, 'product.isDelete' => 0, 'product.isFeatures' => 0, 'category.categoryname' => $id, 'category.slugname' => $id,"category.iStatus"=>1 ,"category.isDelete"=>0])
                 
                ->join('category', 'product.categoryId', '=', 'category.categoryId')
                ->paginate(10);
            // dd($Product);
        }

        return view('Front.product', compact('Product'));
    }




   public function productdetail(Request $request, $category = null, $id = null)
    {
        // dd($category);
        // dd($id);
        $ProductDetail = Product::select(
            'product.productId',
            'product.productname',
            'product.rate',
            'product.weight',
            'product.description',
            'product.isStock',
            'product.categoryId',
            'product.isFeatures',
            'product.meta_title',
            'product.meta_keyword',
            'product.meta_description',
            'product.head',
            'product.body',
            DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId  LIMIT 1) as photo'),
            DB::raw('(SELECT category.categoryId FROM category inner join multiplecategory on category.categoryId=multiplecategory.categoryid where multiplecategory.productid=product.productId ORDER BY product.productId  LIMIT 1) as categoryId'),
        )
            ->orderBy('productId', 'DESC')
            ->where(['product.iStatus' => 1, 'product.isDelete' => 0, 'product.slugname' => $id])
             
            ->first();
        // dd($ProductDetail);
        $Category = Category::where(['slugname' => $category])->first();

        $Photos = Productphotos::where(['productphotos.iStatus' => 1, 'productphotos.isDelete' => 0, 'productphotos.productid' => $ProductDetail->productId])
            ->get();

        $Attribute = ProductAttributes::select(
            'product_attributes.id',
            'product_attributes.product_id',
            'product_attributes.product_attribute_id',
            'product_attributes.product_attribute_weight',
            // 'product.productId',

        )
            ->where(['product_attributes.product_id' => $ProductDetail->productId])
            ->get();
// dd($Attribute);
        if ($ProductDetail->isFeatures == 1) {
            $RelatedProduct = Product::select(
                'product.productId',
                'product.productname',
                'product.rate',
                'product.weight',
                'product.description',
                'product.isStock',
                'product.slugname',
                'product.categoryId',
                'product.isFeatures',
                DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId ORDER BY product.productId  LIMIT 1) as photo'),
                DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId ORDER BY product.productId LIMIT 1,1) as backphoto'),
                DB::raw('(SELECT category.categoryId FROM category inner join multiplecategory on category.categoryId=multiplecategory.categoryid where multiplecategory.productid=product.productId ORDER BY product.productId  LIMIT 1) as categoryId'),
            )
                ->orderBy('productId', 'DESC')
                ->take(4)
                ->where(['product.iStatus' => 1, 'product.isDelete' => 0, 'product.isFeatures' => 1])
                 ->whereIn('categoryId', function ($query) {
                        $query->select('categoryId')
                            ->from('category')
                            ->where('isDelete', 0)
                            ->where('iStatus', 1);
                    })
                ->where('product.slugname', '!=', $id)
                ->get();
            // dd($RelatedProduct);
        } else {
            // dd('else');
            $RelatedProduct = Product::select(
                'product.productId',
                'product.productname',
                'product.rate',
                'product.weight',
                'product.description',
                'product.isStock',
                'product.slugname',
                'product.categoryId',
                'product.isFeatures',
                DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId ORDER BY product.productId  LIMIT 1) as photo'),
                DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId ORDER BY product.productId LIMIT 1,1) as backphoto'),
                DB::raw('(SELECT category.categoryId FROM category inner join multiplecategory on category.categoryId=multiplecategory.categoryid where multiplecategory.productid=product.productId ORDER BY product.productId  LIMIT 1) as categoryId'),
            )
                ->orderBy('product.productId', 'DESC')
                ->join('multiplecategory', 'product.productId', '=', 'multiplecategory.productid')
                ->where(['product.iStatus' => 1, 'product.isDelete' => 0, 'product.isFeatures' => 0])
                ->where('multiplecategory.categoryid', '=', $Category->categoryId)
                //  ->whereIn('categoryId', function ($query) {
                //         $query->select('categoryId')
                //             ->from('category')
                //             ->where('isDelete', 0)
                //             ->where('iStatus', 1);
                //     })
                 /*->whereIn('product.productId', function ($query) {
                    $query->select('multiplecategory.productid')
                        ->from('category')
                        ->join('multiplecategory','multiplecategory.categoryid','=','category.categoryId')
                        ->where('category.isDelete', 0)
                        ->where('category.iStatus', 1);
                    })*/
                
                ->where('product.slugname', '!=', $id)
                ->get();
            // dd($RelatedProduct);
        }

        $productrate = DB::table('review')->where('product_id',$ProductDetail->productId)->avg('rating');
        $productreview = DB::table('review')->where('product_id',$ProductDetail->productId)->skip(0)->take(4)->orderBy('id','desc')->get();
        $productcount = DB::table('review')->where('product_id',$ProductDetail->productId)->count();


        return view('Front.product-detail', compact('ProductDetail', 'Photos', 'RelatedProduct', 'Attribute', 'category', 'id','productrate','productreview','productcount'));
    }

     public function privacypolicy()
    {
        $seo = MetaData::where('id', '=', '1')->first();
        $data=Pages::where(['id'=>1])->first();
        return view('Front.privacypolicy', compact('seo','data'));
    }

    public function refundpolicy()
    {
        $data=Pages::where(['id'=>3])->first();
        $seo = MetaData::where('id', '=', '2')->first();

        return view('Front.refundpolicy', compact('seo','data'));
    }

    public function termandcondition()
    {
           $data=Pages::where(['id'=>2])->first();
     
        $seo = MetaData::where('id', '=', '3')->first();
        return view('Front.termandcondition', compact('seo','data'));
    }

    public function ShippingandDelivery()
    {
        $seo = MetaData::where('id', '=', '4')->first();
            $data=Pages::where(['id'=>4])->first();

        return view('Front.ShippingandDelivery', compact('seo','data'));
    }

    public function logout()
    {
        $session = Session::get('customerid');
        $session;
        session()->flush('customerid' . $session);
        return redirect()->route('FrontIndex');
    }



    public function weightBind(Request $request)
    {
        // dd($request->all());
        if ($request->Weight == 0) {
            $Data = Product::where(['product.iStatus' => 1, 'product.isDelete' => 0, 'product.productId' => $request->productid])
                ->first();
        } else {
            $Data = ProductAttributes::orderBy('id', 'DESC')
                ->where(['product_id' => $request->productid, 'id' => $request->Weight])
                ->first();
        }

        return  json_encode($Data);
    }

    public function ccavResponseHandler(Request $request)
    {
        // dd($request);
    }

    public function contactthankyou()
    {
        return view('Front.contactthankyou');
    }

    public function FrontCategory(Request $request, $id)
    {
        $HeaderSearch = $request->headersearch;
        $Category = Category::orderBy('categoryId', 'desc')->get();

         


            $Product = Product::select(
                'product.productId',
                'product.categoryId',
                'product.productname',
                'product.rate',
                'product.weight',
                'product.description',
                'product.isFeatures',
                'product.isStock',
                'product.slugname',
                DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId ORDER BY product.productId  LIMIT 1) as photo'),
                DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId ORDER BY product.productId LIMIT 1,1) as backphoto'),
                DB::raw('(SELECT category.categoryId FROM category inner join multiplecategory on category.categoryId=multiplecategory.categoryid where multiplecategory.productid=product.productId ORDER BY product.productId  LIMIT 1) as categoryId'),
            )
                ->orderBy('productId', 'desc')
                //->where(['product.iStatus' => 1, 'product.isDelete' => 0, 'product.isFeatures' => 0, 'category.slugname' => $id,"category.iStatus"=>1 ,"category.isDelete"=>0])
                ->where(['product.iStatus' => 1, 'product.isDelete' => 0,'category.slugname' => $id,"category.iStatus"=>1 ,"category.isDelete"=>0])
                ->join('multiplecategory', 'product.productId', '=', 'multiplecategory.productid')
                ->join('category', 'multiplecategory.categoryid', '=', 'category.categoryId')
                ->paginate(16);
            // dd($Product);
            $ProductCount = $Product->count();

        // dd($Product);
        DB::commit();
        return view('Front.category', compact('Product', 'Category', 'id', 'ProductCount'));
        // return view('Front.product');
    }

    public function searchproductincategory(Request $request)
    {
       //  dd($request);
       
        if ($request->keyword != '') {
            // dd('if');
            $product = Product::select(
                'product.productId',
                'product.categoryId',
                'product.productname',
                'product.rate',
                'product.weight',
                'product.description',
                'product.isFeatures',
                'product.slugname',
                DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId ORDER BY product.productId  LIMIT 1) as photo'),
                DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId ORDER BY product.productId LIMIT 1,1) as backphoto')
            )
                ->orderBy('productId', 'desc')
                ->where('productname', 'LIKE', '%' . $request->keyword . '%')
                ->where(['product.iStatus' => 1, 'product.isDelete' => 0, 'product.isFeatures' => 0])
                //  ->whereIn('categoryId', function ($query) {
                // $query->select('categoryId')
                //     ->from('category')
                //     ->where('isDelete', 0)
                //     ->where('iStatus', 1);
                //  })
            
                 ->whereIn('product.productId', function ($query) {
                        $query->select('multiplecategory.productid')
                            ->from('category')
                            ->join('multiplecategory','multiplecategory.productid','=','product.productId')
                            ->where('category.isDelete', 0)
                            ->where('category.iStatus', 1);
                    })
                ->paginate(16); // ->get();
            // dd($product);
        } else {
            $product = Product::select(
                'product.productId',
                'product.productname',
                'product.rate',
                'product.weight',
                'product.description',
                'product.isFeatures',
                'product.slugname',
                DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId ORDER BY product.productId  LIMIT 1) as photo'),
                DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId ORDER BY product.productId LIMIT 1,1) as backphoto')
            )
                ->orderBy('productId', 'desc')
                ->where(['product.iStatus' => 1, 'product.isDelete' => 0, 'product.isFeatures' => 0, 'category.slugname' => $request->categoryId, 'category.slugname' => $id,"category.iStatus"=>1 ,"category.isDelete"=>0])
                ->join('multiplecategory', 'product.productId', '=', 'multiplecategory.productid')
                ->join('category', 'multiplecategory.categoryid', '=', 'category.categoryId')
                ->paginate(16);
            // dd($product);
        }
        return response()->json([
            'product' => $product,

        ]);
    }
      public function productreview(Request $request)
    {
        // try{

        $customerid = Session::get('customerid');
        $strName=Session::get('customername');
        $strEmail=Session::get('customeremail');
        $data = array(
            "product_id" => $request->productId,
            "iCustomerId" => $customerid,
            "rating" => $request->iRate,
            "comment" => $request->comment,
            "author" => $strName,
            "email" => $strEmail
        );
        if(DB::table('review')->insert($data)){
            return redirect()->back()->with('success', 'Review Added Successfully.');
        } else {
            return redirect()->back()->with('error', 'Invalid Request.');
        }
        
        
    // } catch (\Exception $e) {

    //     report($e);
 
    //     return false;
    // }
    }
    public function fetchProducts(Request $request)
{
    $categoryId = $request->input('categoryId');
    
    $products = Product::select(
                'product.productId',
                'product.productname',
                'product.rate',
                'product.weight',
                'product.description',
                'product.isFeatures',
                'product.slugname',
                DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId ORDER BY product.productId  LIMIT 1) as photo'),
                DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId ORDER BY product.productId LIMIT 1,1) as backphoto')
            )->where([
                    ['product.iStatus', '=', 1],
                    ['product.isDelete', '=', 0],
                    ['multiplecategory.categoryid', '=', $categoryId]
                ])
                ->join('multiplecategory', 'product.productId', '=', 'multiplecategory.productid')
                ->join('category', 'multiplecategory.categoryid', '=', 'category.categoryId')
                ->orderBy('productname', 'asc')
                ->get();

    // Return the product data as a partial view
    return view('Front.products', compact('products'));
}

}
