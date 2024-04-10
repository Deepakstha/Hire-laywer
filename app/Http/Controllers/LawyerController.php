<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Appointments;
use App\Models\Message;
use App\Models\ratings;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\hire_lawyer;
use App\Models\User;
use Carbon\Carbon;

class LawyerController extends Controller
{

    public function lawyer_page()
    {

        $lawyers = DB::select('
    SELECT lawyer_details.*, users.*, (
        SELECT AVG(ratings.ratings)
        FROM ratings
        WHERE ratings.lawyer_id = lawyer_details.lawyer_id
    ) AS average_rating
    FROM users
    LEFT JOIN lawyer_details ON lawyer_details.lawyer_id = users.id
    WHERE lawyer_details.is_verified = 1
');

        // dd($lawyers);

        return view('lawyer-page', ['lawyers' => $lawyers]);
    }

    public function lawyer_details($id)
    {
        $lawyers = DB::table('lawyer_details')
            ->leftJoin('users', 'users.id', '=', 'lawyer_details.lawyer_id')->where('users.id', $id)
            ->first();


        // dd($lawyers);
        return view('lawyer-profile-client', ['lawyers' => $lawyers]);
    }

    public function lawyer_rating_form(Request $request)
    {
        $userId = Auth::user()->id;
        // return redirect('login')->with('error', 'Please login first');
        // echo "lsfjl";
        $check = hire_lawyer::where('client_id', $userId)->where('lawyer_id', $request->lawyer_id)->first();
        if (!$check) {
            return back()->with('error', 'You must hire a lawyer to rate');
        }
        $checkRating = ratings::where('user_id', $userId)->where('lawyer_id', $request->lawyer_id)->exists();
        ;
        if ($checkRating)
            return back()->with('error', 'You already rated the lawyer');
        ratings::create(['user_id' => $userId, 'lawyer_id' => $request->lawyer_id, 'ratings' => $request->rating, 'reviews' => $request->reviews]);
        return back()->with('success', 'Thanks for rating lawyer');
    }

    public function hire_request_lawyer(Request $request)
    {
        if (Auth::check()) {
            $check = hire_lawyer::where('client_id', Auth::User()->id)->where('lawyer_id', $request->lawyer_id)->first();

            if ($check) {
                return back()->with('error', 'You already send request');
            }
            hire_lawyer::create([
                'lawyer_id' => $request->lawyer_id,
                'client_id' => Auth::User()->id,
            ]);
            return back()->with('success', 'Hire request sent successfully');


        } else {
            return redirect('login')->with('error', 'Please login first');

        }

    }

    public function lawyer_dashboard()
    {
        $userId = Auth::User()->id;
        $hireRequestCount = hire_lawyer::where('lawyer_id', $userId)->where('is_accepted', false)->count();
        $clientCount = hire_lawyer::where('lawyer_id', $userId)->where('is_accepted', true)->count();
        $appointments = Appointments::where('lawyer_id', $userId)->where('booking_start_date', '>', Carbon::now())->count();
        $feedbackCount = ratings::where('lawyer_id', $userId)->get()->count();
        return view('lawyer-dashboard', ['hireRequestCount' => $hireRequestCount, 'clientCount' => $clientCount, 'appointments' => $appointments, 'feedbackCount' => $feedbackCount]);
    }

    public function displayHireLawyerRequest()
    {
        $userId = Auth::User()->id;
        $clientIds = [];
        $hireRequest = hire_lawyer::where('lawyer_id', $userId)->where('is_accepted', false)->get();

        foreach ($hireRequest as $request) {
            $clientIds[] = User::where('id', $request->client_id)->first();
        }
        return view('hire-request', ['hireRequest' => $clientIds]);

    }

    public function deleteHireRequest($id)
    {
        $userId = Auth::User()->id;
        $checkPremission = hire_lawyer::where('lawyer_id', $userId)->where('client_id', $id)->first();
        if ($checkPremission) {
            $checkPremission->delete();
            return back()->with('success', 'Request Deleted');
        } else {
            return back()->with('error', 'Unauthorized access');
        }

    }

    public function acceptHireRequest($id)
    {
        $userId = Auth::User()->id;
        $checkPremission = hire_lawyer::where('lawyer_id', $userId)->where('client_id', $id)->first();

        if ($checkPremission) {
            $checkPremission->is_accepted = true;
            $checkPremission->save();
            return back()->with('success', 'Request Accepted');
        } else {
            return back()->with('error', 'Unauthorised Access');
        }

    }

    public function displayClients()
    {
        $userId = Auth::User()->id;
        $clientIds = [];
        $hireRequest = hire_lawyer::where('lawyer_id', $userId)->where('is_accepted', true)->get();

        foreach ($hireRequest as $request) {
            $clientIds[] = User::where('id', $request->client_id)->first();
        }
        return view('lawyers-client', ['hireRequest' => $clientIds]);

    }

    public function displayAppointmentToLawyer()
    {
        $userId = Auth::User()->id;
        $appointments = DB::select('
            SELECT appointments.booking_start_date,appointments.booking_end_date,users.name, users.email,appointments.id
            FROM appointments
            JOIN users ON appointments.client_id = users.id
            WHERE lawyer_id = ?
        ', [$userId]);
        return view('appointment-lawyer', ['appointments' => $appointments]);
    }

    public function displayAppointmentForUser()
    {
        $userId = Auth::User()->id;
        $appointments = DB::select('
            SELECT appointments.booking_start_date,appointments.booking_end_date,users.name, users.email,appointments.id
            FROM appointments
            JOIN users ON appointments.lawyer_id = users.id
            WHERE client_id = ?
        ', [$userId]);
        return view('appointment-lawyer', ['appointments' => $appointments]);
    }

    public function deleteAppointment($id)
    {
        // $userId = Auth::User()->id;
        $check = Appointments::where('id', $id)->first();
        if ($check) {
            $check->delete();
            return back()->with('success', 'Appointment Deleted');
        } else {
            return back()->with('error', 'Not deleted');
        }


    }

    public function displayBookAppointmentForm($id)
    {
        $lawyer = User::where("id", $id)->first();
        // echo $lawyer->name;
        return view('book-appointment', ['lawyerId' => $id, 'lawyerName' => $lawyer->name]);
    }

    public function bookAppointment(Request $request)
    {
        $endDateTime = date('Y-m-d H:i:s', strtotime($request->datetimeInput . ' +30 minutes'));
        if (!Auth::check()) {
            return redirect('login')->with('error', 'Please login first');
        }
        $userId = Auth::User()->id;
        $checkAppointment = Appointments::where("booking_start_date", $request->datetimeInput)->first();
        if ($checkAppointment) {
            // echo "Booking Date Already exist";
            return back()->with('error', 'Booking Date Already exist');
        }

        $overlappingAppointment = Appointments::where('booking_start_date', '<=', $endDateTime)
            ->where('booking_end_date', '>=', $request->datetimeInput)
            ->first();

        if ($overlappingAppointment) {
            // echo "Another appointment is already booked during this time";
            return back()->with('error', 'Another appointment is already booked during this time');
            // return;
        }
        $store = Appointments::create([
            'client_id' => $userId,
            'lawyer_id' => $request->lawyerId,
            'booking_start_date' => $request->datetimeInput,
            'booking_end_date' => $endDateTime,
        ]);
        if ($store) {
            // echo "Saved";
            return back()->with('success', 'Appointment Send');

        }

    }


    public function displayClientsForMessage()
    {
        $userId = Auth::User()->id;
        $messageUser = Message::where('receiver', $userId)
            ->join('users', 'users.id', '=', 'messages.sender')
            ->select('users.name', 'users.id')
            ->distinct()
            ->get();

        return view("lawyer-message", ['users' => $messageUser]);


        // $message = Messages::where(['user_from' => $userId, 'user_to' => $id])->orWhere(function ($query) use ($userId, $id
        // $message = Messages::where(['sender_id' => $userId, 'receiver_id' => $id])->orWhere(function ($query) use ($userId,
        // $messageData = Messages::select(DB::raw('messages.* , users.name as senderName'))
        //     ->join('users', 'users.id', '=', 'messages.sender_id')
        //     ->where(['receiver_id' => $userId, 'conversation_id' => $id])
        //     ->orderBy('created_at', 'asc')
        //     ->get();
        // $userInfo = Users::findOrFail($userId);
        // return view('pages.display-message')->with(['data' => $messageData, 'userInfo' => $userInfo]);


    }
}
