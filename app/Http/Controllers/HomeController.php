<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\LawyerDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {

        // $lawyers = User::where('role', 'lawyer')
        //     ->with('lawyerDetails')
        //     ->get();
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

        // $users = User::with("lawyerDetails")->get();
        // $lawyersDetails = LawyerDetails::with("user")->get();




        return view('home', ['lawyers' => $lawyers]);
    }


}
