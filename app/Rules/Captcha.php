<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use ReCaptcha\ReCaptcha;

class Captcha implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $recaptcha= new ReCaptcha(env('CAPTCHA_SECRET'));
        $resp = $recaptcha/*->setExpectedHostname(env('APP_URL'))*/
            ->verify($value, $_SERVER['REMOTE_ADDR']);

        return $resp->isSuccess();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'please make sure reCaptcha is complete';
    }
}
