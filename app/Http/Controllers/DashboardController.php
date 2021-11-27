<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Post;
use App\Models\Scholarship;
use App\Models\Subscription;
use App\Models\User;
use App\Models\Video;
use App\Models\Wallet;
use App\Models\Withdraw;
use Auth;

class DashboardController extends Controller
{

	public function homePage()
	{
		$title  = "Home";
		$data   = compact('title');
		return view('front.home_page', $data);
	}

	public function dashboard()
	{
		$title               = "Dashboard";
		$totalUsers 		 = User::count();
		$totalPosts 		 = Post::count();
		$totalVideos 		 = Video::count();
		$totalScholarshipReq = Scholarship::count();
		$totalSubscriptions  = Subscription::count();
		$totalWithdrawReq 	 = Withdraw::count();
		$totalWallet 		 = Wallet::count();
		$totalSupportEnq 	 = Contact::count();
		$data   = compact('title','totalUsers','totalPosts','totalVideos','totalScholarshipReq','totalSubscriptions','totalWithdrawReq','totalWallet','totalSupportEnq');
		return view('admin_panel.dashboard', $data);
	}

	public function contact_us()
	{
		$title  = "Contact Us";
		$data   = compact('title');
		return view('admin_panel.contact_us', $data);
	}

	public function logout_admin()
	{
		Auth::guard('admin')->logout();
		return redirect()->route('control_panel')->with('Success', 'Logout successfully');
	}
}