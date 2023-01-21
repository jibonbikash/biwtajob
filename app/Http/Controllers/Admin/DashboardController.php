<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Rules\OldPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function index(Request $request){

        return view('dashboard');
    }

    public function profile(Request $request)
    {

        return view("admin.profile");
    }
    public function password(Request $request)
    {

        return view("admin.password");
    }

    public function passwordchange(Request $request)
    {

        $request->validate([
            'current_password' => ['required', new OldPassword()],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);

        try {
            User::find(Auth::guard('web')->user()->id)->update(['password' => Hash::make($request->new_password)]);

            return redirect()->route('dashboard')
                ->with('success', 'Password updated successfully');

        } catch (\Exception $e) {

            return redirect()->route('dashboard')
                ->with('error', $e->getMessage());

        }


    }
}
