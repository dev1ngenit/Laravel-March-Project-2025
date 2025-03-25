<?php
namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Mail\VerificationMail;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('user.auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // $user = User::create([
        //     'name'     => $request->name,
        //     'email'    => $request->email,
        //     'password' => Hash::make($request->password),
        // ]);

        // event(new Registered($user));

        // Auth::login($user);

        // return redirect(RouteServiceProvider::HOME);

        $verificationCode = rand(100000, 999999); // Generate 6-digit code

        $user = User::create([

            'name'              => $request->name,
            'email'             => $request->email,
            'password'          => Hash::make($request->password),
            'verification_code' => $verificationCode,

        ]);

        // Send email
        Mail::to($user->email)->send(new VerificationMail($user, $verificationCode));

        return redirect()->route('verification.form', ['email' => $user->email])->with('success', 'Verification code has been sent to your email.');
    }

}
