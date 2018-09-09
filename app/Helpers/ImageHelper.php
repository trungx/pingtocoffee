<?php

namespace App\Helpers;

use App\User;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image as Image;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

class ImageHelper
{
    /**
     * Images size constant.
     */
    const SMALL_SIZE = 50;
    const MEDIUM_SIZE = 150;
    const LARGE_SIZE = 300;

    /**
     * Resize avatar for user.
     *
     * @param User $user
     */
    public static function resizeAvatar(User $user)
    {
        if ($user->has_avatar) {
            try {
                $originalAvatar = Storage::disk($user->avatar_location)->get($user->avatar_file_name);
                $avatarPath = Storage::disk($user->avatar_location)->url($user->avatar_file_name);
                $avatarFilenameWithoutExtension = pathinfo($avatarPath, PATHINFO_FILENAME);
                $extension = pathinfo($avatarPath, PATHINFO_EXTENSION);
            } catch (FileNotFoundException $e) {
                Log::debug($e->getMessage());
                return;
            }

            $avatarCroppedPath = 'avatars/' . $avatarFilenameWithoutExtension . '_' . self::SMALL_SIZE . '.' . $extension;
            $avatar = Image::make($originalAvatar)->orientate();
            $avatar->fit(self::SMALL_SIZE);
            Storage::disk($user->avatar_location)->put($avatarCroppedPath, $avatar->stream()->__toString());

            $avatarCroppedPath = 'avatars/' . $avatarFilenameWithoutExtension . '_' . self::MEDIUM_SIZE . '.' . $extension;
            $avatar = Image::make($originalAvatar)->orientate();
            $avatar->fit(self::MEDIUM_SIZE);
            Storage::disk($user->avatar_location)->put($avatarCroppedPath, $avatar->stream()->__toString());

            $avatarCroppedPath = 'avatars/' . $avatarFilenameWithoutExtension . '_' . self::LARGE_SIZE . '.' . $extension;
            $avatar = Image::make($originalAvatar)->orientate();
            $avatar->fit(self::LARGE_SIZE);
            Storage::disk($user->avatar_location)->put($avatarCroppedPath, $avatar->stream()->__toString());
        }
    }
}
