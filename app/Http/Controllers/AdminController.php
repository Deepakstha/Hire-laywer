<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Appointments;
use App\Models\LawyerDetails;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\hire_lawyer;
use App\Models\User;

class AdminController extends Controller
{
    public function admin_dashboard()
    {
        $userId = Auth::User()->id;
        // $hireRequestCount = User::where('lawyer_id', $userId)->where('is_accepted', false)->count();

        $lawyers = DB::table('lawyer_details')
            ->leftJoin('users', 'users.id', '=', 'lawyer_details.lawyer_id')->where('lawyer_details.is_verified', false)
            ->get()->count();
        return view('admin-dashboard', ['lawyerRequestCount' => $lawyers]);
    }
    public function displayLawyerRequest()
    {
        $userId = Auth::User()->id;
        $lawyerIds = [];
        $lawyers = DB::table('lawyer_details')
            ->leftJoin('users', 'users.id', '=', 'lawyer_details.lawyer_id')->where('lawyer_details.is_verified', false)
            ->get();
        // dd($lawyers);
        foreach ($lawyers as $request) {
            $lawyerIds[] = User::where('id', $request->lawyer_id)->first();
        }
        return view('lawyer-request', ['lawyerRequest' => $lawyerIds]);
    }

    public function acceptLawyerRequest($id)
    {
        $userId = Auth::User()->id;
        $check = LawyerDetails::where('lawyer_id', $id)->first();
        // dd($check);
        $check->is_verified = true;
        $check->save();
        return back()->with('success', 'Request Accepted');

        // if ($check) {
        // } else {
        //     return back()->with('error', 'Unauthorised Access');
        // }

    }
}
