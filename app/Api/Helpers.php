<?php
use Hashids\Hashids;

// hashids 加密
function hashidsEncode ($id, $salt = '', $minHashLength = '', $alphabet = '') {
    $id = (int)$id;
    if (!$id) {
        return false;
    }
    if (empty($salt)) {
        $salt = config('hashids.salt');
    }
    if (empty($minHashLength)) {
        $minHashLength = config('hashids.minHashLength');
    }
    if (empty($alphabet)) {
        $alphabet = config('hashids.alphabet');
    }
    $hashids = new Hashids($salt, $minHashLength, $alphabet);
    return $hashids->encode($id);
}

// hashids 解密
function hashidsDecode ($hash, $salt = '', $minHashLength = '', $alphabet = '') {
    if (empty($salt)) {
        $salt = config('hashids.salt');
    }
    if (empty($minHashLength)) {
        $salt = config('hashids.minHashLength');
    }
    if (empty($alphabet)) {
        $salt = config('hashids.alphabet');
    }
    $hashids = new Hashids($salt, $minHashLength, $alphabet);
    return $hashids->decode($hash);
}