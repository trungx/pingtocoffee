<?php

namespace App\Http\Controllers;

use App\Helpers\ImageHelper;
use App\Http\Requests\SendInviteMailRequest;
use App\Jobs\SendInvitationEmail;
use Illuminate\Http\Request;

class UsersController extends Controller
{
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
}
