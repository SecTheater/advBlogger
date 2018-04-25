<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class usernameOrEmail implements Rule
{

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        //username@.com
        if(filter_var($value,FILTER_VALIDATE_EMAIL)){
            return request()->validate([
                $attribute => ['required','email']
            ],['email.regex' => 'Invalid Domain']);
        }elseif(preg_match('/^[a-zA-Z-_]*$/',$value)){
            return request()->validate([
                $attribute => 'required|alpha_dash|min:6|max:32'
            ]);
        }
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Invalid Domain';
    }
}
