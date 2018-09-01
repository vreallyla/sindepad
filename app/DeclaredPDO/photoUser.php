<?php

namespace App\DeclaredPDO;


use App\Model\sideGender;
use http\Exception;

class photoUser
{
    const woman = [
        'storage/user-photos/footage/woman/croupier.png',
        'storage/user-photos/footage/woman/w2.png',
        'storage/user-photos/footage/woman/w3.png',
        'storage/user-photos/footage/woman/w4.png',
        'storage/user-photos/footage/woman/w5.png',
        'storage/user-photos/footage/woman/w6.png',
        'storage/user-photos/footage/woman/w.png'
    ];

    const man = [
        'storage/user-photos/footage/man/m2.png',
        'storage/user-photos/footage/man/m3.png',
        'storage/user-photos/footage/man/m4.png',
        'storage/user-photos/footage/man/m5.png',
        'storage/user-photos/footage/man/m6.png',
        'storage/user-photos/footage/man/m7.png',
        'storage/user-photos/footage/man/m.png'

    ];

    const male = 'seeker';

    const female = 'agency';

    const ALL = [
        photoUser::man,
        photoUser::woman,
        photoUser::male,
        photoUser::female
    ];

    public static function check($code, $delimitter = null)
    {
        try {
            $gender = sideGender::findOrFail($code);
        } catch (\Exception $e) {
            return redirect()->back()->with('message', 'message');
        }

        if ($gender->en == 'Male') {
            return photoUser::ALL[0][rand(0, 6)];
        }

        return photoUser::ALL[1][rand(0, 6)];
    }
}
