<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails;

    /**
     * Where to redirect users after verification.
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
        $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    /**
     * Resend the email verification notification.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect($this->redirectPath());
        }

        if (! $this->shouldSend($request->user())) {
            $minutes = $request->user()->sendNextVerificationEmailAfter();

            return back()->with('status', __('settings.resend_email_throttle', ['minutes' => $minutes]));
        }

        $request->user()->sendEmailVerificationNotification();

        // Update last date time email was sent.
        $request->user()->forceFill([
            'last_verification_email_sent' => $request->user()->freshTimestamp(),
        ])->save();

        return back()->with('status', __('settings.resent'));
    }

    /**
     * Check it should send verification email.
     *
     * @param $user
     * @return bool
     */
    public function shouldSend($user)
    {
        if (empty($user->last_verification_email_sent)) {
            return true;
        }

        return $user->sendNextVerificationEmailAfter() <= 0;
    }
}
