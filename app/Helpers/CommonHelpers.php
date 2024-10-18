<?php

namespace App\Helpers;

use Hashids\Hashids;

if (!function_exists('hashidDecode')) {
    /**
     * get decode hash with hashids
     *
     * @return int month
     */

    function hashidDecode($hash)
    {
        $salt = env('HASHIDS_SALT', 'default_salt');
        $length = env('HASHIDS_LENGTH', 16);

        $hashids = new Hashids($salt, $length);

        if (!$hash) {
            return null;
        }

        $decode = $hashids->decode($hash);

        if (!is_array($decode)) {
            return null;
        }

        if (!count($decode)) {
            return null;
        }

        return $decode[0];
    }
}

if (!function_exists('hashidEncode')) {
    /**
     * get encode id with hashids
     *
     * @return int month
     */

    function hashidEncode($id)
    {
        $salt = env('HASHIDS_SALT', 'default_salt');
        $length = env('HASHIDS_LENGTH', 16);

        $hashids = new Hashids($salt, $length);

        return $hashids->encode($id);
    }
}
