<?php

namespace App\Http\Controllers\Auth;

use App\DefaultEvent;
use App\Jobs\SendWelcomeEmailToNewUser;
use App\Feed;
use App\User;
use App\Account;
use App\Referral;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        if (env('APP_DISABLE_SIGNUP')) {
            return redirect('/register');
        }

        // Create a new account
        $account = new Account();
        $account->save();

        do {
            $referralCode = User::randomCode();
            $isExistReferralCode = User::where('referral_code', $referralCode)->exists();
        } while ($isExistReferralCode);

        $user = User::create([
            'account_id' => $account->id,
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'referral_code' => $referralCode,
        ]);

        $user->setAvatarColor();

        if (!empty($data['ref'])) {
            $this->saveReferrals($data);
        }

        // Send welcome mail
        $this->dispatch(new SendWelcomeEmailToNewUser($user));

        // Create log for feed
        $log = DefaultEvent::where('type_of_action', DefaultEvent::DEFAULT_EVENT_SIGN_UP)->first();
        (new Feed)->add($log, $user->id);

        return $user;
    }

    /**
     * Show the application registration form.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showRegistrationForm(Request $request)
    {
        if (env('APP_DISABLE_SIGNUP')) {
            return view('auth.disable_signup');
        }

        $referralCode = $request->get('ref');

        return view('auth.signup', [
            'referralCode' => $referralCode,
        ]);
    }

    /**
     * Save referral record when register success
     *
     * @param array $data
     */
    public function saveReferrals(array $data)
    {
        Referral::create([
            'referral_code' => $data['ref'],
            'to_email' => $data['email']
        ]);
    }
}
