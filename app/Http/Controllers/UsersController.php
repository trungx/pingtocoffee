<?php

namespace App\Http\Controllers;

use App\User;
use App\Helpers\ImageHelper;
use App\Http\Requests\SendInviteMailRequest;
use App\Jobs\SendInvitationEmail;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Search contact public
     *
     * @param Request $request
     * @return array
     */
    public function search(Request $request)
    {
        $needle = $request->needle;

        if ($needle == null) {
            return ['noResults' => __('user.user_search_no_result')];
        }

        $results = auth()->user()->nonBlockingUsers()
            ->where(function($query) use ($needle) {
                $query->search($needle);
            })->get();

        if ($results->count()) {
            $results->map(function ($user) {
                $user->initials = $user->getInitials();

                if ($user->has_avatar) {
                    $user->avatar = $user->getAvatarUrl(ImageHelper::SMALL_SIZE);
                } else {
                    $user->avatar = null;
                }
            });
            return $results;
        }

        return ['noResults' => __('user.user_search_no_result')];
    }

    /**
     * Show referrals form
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showReferralsForm()
    {
        return view('users.referrals.index', [
            'referralCode' => auth()->user()->referral_code,
        ]);
    }

    /**
     * Send invite email
     *
     * @param SendInviteMailRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendInvite(SendInviteMailRequest $request)
    {
        dispatch(new SendInvitationEmail($request->email, auth()->user()));

        return redirect()->back()->with('status', __('settings.referrals_mail_send_success'));
    }

    /**
     * Delete user.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Request $request)
    {
        // Update the delete date.
        $dayWillBeDeleted = Carbon::now()->addDays(config('user.days_to_destroy'))->format('Y-m-d');
        auth()->user()->update(['destroy_date' => $dayWillBeDeleted]);

        // Log out and destroy session.
        $this->guard()->logout();
        $request->session()->invalidate();

        return redirect('/users/destroy/success?d=' . $dayWillBeDeleted);
    }

    /**
     * Destroy success screen.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function destroySuccess(Request $request)
    {
        $dayWillBeDeleted = $request->d;
        return view('users.destroy-success', ['dayWillBeDeleted' => $dayWillBeDeleted]);
    }

    /**
     * Cancel delete user.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function reverse()
    {
        auth()->user()->update(['destroy_date' => null]);
        return redirect('/settings/security')->with('status', __('settings.delete_account_was_cancelled'));
    }
}
