<?php

namespace App\Traits;
// use Image;
use File;

trait Avatar
{
    /**
     * Ставит аватарку под все размеры
     */
    public function setUserAvatar($user, $img) { // TODO interface Image
        // сохраняет начальный статус(когда только обрезана)
        $img->backup();

        $sizes = [
            'lg' => 320,
            'md' => 200,
            'sm' => 133,
            'circle' => 80
        ];

        $avatar = [];
        foreach ($sizes as $sizeName => $width) {
            $avatar[$sizeName] = $this->saveAvatarBySize($user, $img, $sizeName, $width);
        }
        $user->avatar = $avatar;
        $user->save();


        return $avatar;
    }


    protected function saveAvatarBySize($user, $img, $sizeName, $width) {
        $folderPath =  "avatars/$user->id";
        $folderPathFull = public_path($folderPath);
        $filePath = "$folderPath/$sizeName.jpg";

        if (!File::exists($folderPathFull)) {
            File::makeDirectory($folderPathFull, 0777, true, true);
        }

        $img->resize($width, null, function ($constraint) {
            $constraint->aspectRatio();
        })->save(public_path($filePath));
        // возвращает к состоянию когда был сделан бэкап $img->backup() (тогда была только обрезаность)
        $img->reset();


        return config('app.url') . '/' . $filePath . '?' . rand(); // app url TODO
    }
}
