<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\ChangePasswordRequest;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\RedirectsUsers;
use UnexpectedValueException;

class ChangePasswordController extends Controller
{
    use RedirectsUsers;

    public $redirectTo = '/settings/security';

    /**
     * Update password
     *
     * @param ChangePasswordRequest $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function update(ChangePasswordRequest $request)
    {
        $credentials = $this->credentials($request);

        $response = $this->validateAndPasswordChange($credentials);

        return $response == 'passwords.changed'
            ? $this->sendChangedResponse($response)
            : $this->sendChangedFailedResponse($response);
    }

    /**
     * Change password form data
     *
     * @param $request
     * @return array
     */
    protected function credentials($request)
    {
        return $request->only(
            'password_current', 'password', 'password_confirmation'
        );
    }

    /**
     * Change password success response
     *
     * @param $response
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendChangedResponse($response)
    {
        return redirect($this->redirectPath())
            ->with('status', __($response));
    }

    /**
     * Change password failed response
     *
     * @param $response
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendChangedFailedResponse($response)
    {
        return redirect($this->redirectPath())
            ->withErrors(['password' => __($response)]);
    }

    /**
     * Validate new password
     *
     * @param $credentials
     * @return string|void
     */
    protected function validateChange($credentials)
    {
        if (is_null($user = $this->getUser($credentials))) {
            return 'passwords.invalid';
        }

        if (!Password::broker()->validateNewPassword($credentials)) {
            return 'passwords.password';
        }

        if ($user && !$user instanceof CanResetPasswordContract) {
            throw new UnexpectedValueException('User must implement CanResetPassword interface.');
        }

        return $user;
    }

    /**
     * Check user is being changed password
     * @param $credentials
     * @return \Illuminate\Contracts\Auth\CanResetPassword|null
     */
    protected function getUser($credentials)
    {
        $user = Auth::user();

        if (! Auth::attempt(['email' => $user->email, 'password' => $credentials['password_current']])) {
            return;
        }

        return $user;
    }

    /**
     * Set new password
     *
     * @param $user
     * @param $password
     */
    protected function setNewPassword($user, $password)
    {
        $user->password = Hash::make($password);

        $user->setRememberToken(Str::random(60));

        $user->save();

        Auth::guard()->login($user);
    }

    /**
     * Validate new password and set it to DB.
     *
     * @param $credentials
     * @return string|void
     */
    protected function validateAndPasswordChange($credentials)
    {
        $user = $this->validateChange($credentials);
        if (!$user instanceof CanResetPasswordContract) {
            return $user;
        }
        $this->setNewPassword($user, $credentials['password']);
        return 'passwords.changed';
    }
}
