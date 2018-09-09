<?php

namespace App\Http\Controllers;

use App\Helpers\ImageHelper;
use App\Http\Requests\SettingRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class SettingsController extends Controller
{
    /**
     * Show account setting form
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show()
    {
        return view('settings.index');
    }

    /**
     * Save account settings
     *
     * @param SettingRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(SettingRequest $request)
    {
        // Validate data
        $updatingData = $request->all();
        $year = $request->get('year');
        $month = $request->get('month');
        $day = $request->get('day');
        $updatingData['birthday'] = null;

        if ($year && $month && $day) {
            $updatingData['birthday'] = implode('-', [$year, $month, $day]);
        }

        $validator = Validator::make($updatingData, [
            'birthday' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return redirect('/settings');
        }

        $request->user()->update($updatingData);

        return redirect('settings')->with('status', __('settings.account_information_changed'));
    }

    /**
     * Upload profile picture.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadAvatar(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'avatar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()->all()
                ]);
            }

            if ($request->file('avatar') != '') {
                $request->user()->has_avatar = true;
                $request->user()->avatar_location = config('filesystems.default');
                $request->user()->avatar_file_name = $request->avatar->store('avatars', config('filesystems.default'));
                $request->user()->save();
            }

            // Resize image.
            ImageHelper::resizeAvatar($request->user());

            return response()->json([
                'status' => 'success',
                'msg' => __('settings.avatar_uploaded'),
                'src' => $request->user()->getAvatarUrl(ImageHelper::LARGE_SIZE),
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'status' => 'error',
                'msg' => __('settings.something_wrong'),
            ]);
        }
    }

    /**
     * Show security form
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function security()
    {
        return view('settings.security');
    }
}
