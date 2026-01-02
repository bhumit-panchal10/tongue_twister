<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Testimonial;
use App\Models\Faq;
use App\Models\Offer;
use App\Models\Inquiry;
use App\Models\Courier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Session;
use Illuminate\Support\Facades\Auth;
use App\Models\Role;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $Category = Category::orderBy('categoryId', 'DESC')->where(['iStatus' => 1, 'isDelete' => 0])->count();
        $Faq = Faq::orderBy('faqid', 'DESC')->where(['iStatus' => 1, 'isDelete' => 0])->count();
        $Offer = Offer::orderBy('id', 'DESC')->where(['iStatus' => 1, 'isDelete' => 0])->count();
        $Product = Product::orderBy('productId', 'DESC')->where(['iStatus' => 1, 'isDelete' => 0])->count();
        $Testimonial = Testimonial::orderBy('id', 'DESC')->where(['iStatus' => 1, 'isDelete' => 0])->count();
        $Courier = Courier::orderBy('id', 'DESC')->where(['iStatus' => 1, 'isDelete' => 0])->count();
        $Inquiry = Inquiry::orderBy('id', 'DESC')->where(['iStatus' => 1, 'isDelete' => 0])->count();
        //  dd($Product);
        return view('home', compact('Category', 'Offer',  'Product', 'Testimonial',  'Faq', 'Inquiry', 'Courier'));
    }

    /**
     * User Profile
     * @param Nill
     * @return View Profile
     * @author Shani Singh
     */
    public function getProfile()
    {
        $session = Auth::user()->id;
        // dd($session);
        $users = User::where('users.id',  $session)
            ->first();
        // dd($users);

        return view('profile', compact('users'));
    }


    public function EditProfile()
    {
        $roles = Role::where('id', '!=', '1')->get();

        return view('Editprofile', compact('roles'));
    }

    /**
     * Update Profile
     * @param $profileData
     * @return Boolean With Success Message
     * @author Shani Singh
     */
    public function updateProfile(Request $request)
    {
        $session = auth()->user()->id;
        $user = User::where(['status' => 1, 'id' => $session])->first();

        $request->validate([
            'email' => 'required|unique:users,email,' . $user->id . ',id',
        ]);

        try {
            DB::beginTransaction();

            #Update Profile Data
            User::whereId(auth()->user()->id)->update([
                'first_name'    => $request->first_name,
                'last_name'     => $request->last_name,
                'email'         => $request->email,
                'mobile_number' => $request->mobile_number,
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            #Commit Transaction
            DB::commit();

            #Return To Profile page with success
            return back()->with('success', 'Profile Updated Successfully.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', $th->getMessage());
        }
    }

    /**
     * Change Password
     * @param Old Password, New Password, Confirm New Password
     * @return Boolean With Success Message
     * @author Shani Singh
     */
    public function changePassword(Request $request)
    {
        $session = Auth::user()->id;

        $user = User::where('id', '=', $session)->where(['status' => 1])->first();

        if (Hash::check($request->current_password, $user->password)) {
            $newpassword = $request->new_password;
            $confirmpassword = $request->new_confirm_password;

            if ($newpassword == $confirmpassword) {
                $Student = DB::table('users')
                    ->where(['status' => 1, 'id' => $session])
                    ->update([
                        'password' => Hash::make($confirmpassword),
                    ]);
                Auth::logout();
                return redirect()->route('login')->with('success', 'User Password Updated Successfully.');
            } else {
                return back()->with('error', 'password and confirm password does not match');
            }
        } else {
            return back()->with('error', 'Current Password does not match');
        }
    }
}
