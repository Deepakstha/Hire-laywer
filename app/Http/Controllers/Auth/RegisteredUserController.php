<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\LawyerDetails;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        if (!Storage::exists('images')) {
            Storage::makeDirectory('images');
        }

        if (!Storage::exists('documents/lawyers')) {
            Storage::makeDirectory('documents/lawyers');
        }
        // Handle the image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('images', $imageName, 'public'); // Specify the 'public' disk here
        } else {
            $imageName = null; // Default image or no image
        }

        if ($request->hasFile('lawyer_card')) {
            $lawyer_card = $request->file('lawyer_card');
            $lawyer_card_name = time() . '.' . $lawyer_card->getClientOriginalExtension();
            $path = $lawyer_card->storeAs('documents/lawyers', $lawyer_card_name, 'public');
        } else {
            $lawyer_card_name = null;
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),
            'image' => $imageName,

        ]);
        if ($user->role == 'lawyer') {
            $lawyerDetails = LawyerDetails::where('lawyer_id', $user->id)->first();

            // If the lawyer is not in the LawyerDetails table, store it
            if (!$lawyerDetails) {
                $lawyerDetails = new LawyerDetails;
                $lawyerDetails->lawyer_id = $user->id;
                $lawyerDetails->lawyer_card = $lawyer_card_name;
                $lawyerDetails->bio = "";
                $lawyerDetails->price = 0;
                $lawyerDetails->save();
            }
        }




        event(new Registered($user));

        Auth::login($user);

        // Check the user's role and redirect accordingly
        if ($user->role == 'lawyer') {
            return redirect(RouteServiceProvider::LAYWER_DASHBOARD);
        } else {
            return redirect(RouteServiceProvider::HOME);
        }



    }
}
