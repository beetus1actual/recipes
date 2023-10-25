<?php

namespace App\Security;

use phpseclib3\Crypt\Hash as CryptHash;
use phpseclib3\Crypt\Random as CryptRandom;

class Password
{
    protected const HASH_MD5 = 'plain-MD5';
    protected const HASH_SALTED_MD5 = 'salted-MD5';
    protected const HASH_HMAC_SHA256 = 'HMAC-SHA256';
    protected const HASH_BCRYPT = 'bcrypt';
    protected const HASH_UNKNOWN = 'unknown';

    protected const PATTERN_MD5 = '/^[a-f0-9]{32}$/i';
    protected const PATTERN_SALTED_MD5 = '/^[a-f0-9]{32}(?::(.+))$/i';
    protected const PATTERN_HMAC_SHA256 = '/^[a-f0-9]{64}(?::(.+))$/i';
    protected const PATTERN_BCRYPT = '/^(\$2[axy]|\$2)\$[0-9]{0,2}?\$([a-z0-9\/.]{22})[a-z0-9\/.]{31}$/i';

    protected $defaultHashAlgo = 1;
    protected $useHmac = false;

    public function __construct()
    {
        if (!defined('PASSWORD_BCRYPT')) {
            define('PASSWORD_BCRYPT', 1);
        }

        if (!defined('PASSWORD_DEFAULT')) {
            define('PASSWORD_DEFAULT', PASSWORD_BCRYPT);
        }

        $this->defaultHashAlgo = PASSWORD_BCRYPT;

        if (!empty($useHmac) || version_compare(PHP_VERSION, '5.3.7', '<')) {
            $this->useHmac = true;
        }
    }

    public function hash(string $input, string $algo = '', array $options = []): string
    {
        if ($this->useHmac || $algo == self::HASH_HMAC_SHA256) {
            return $this->hmacHash($input);
        }

        if (!($algo || $algo == self::HASH_BCRYPT)) {
            return $this->defaultHashAlgo;
        }

        if (empty($options)) {
            $options = [];
        }

        return password_hash($input, $algo, $options);
    }

    protected function hmacHash(string $input, string $key = '')
    {
        if (!$key) {
            $key = bin2hex(CryptRandom::string(16));
        }

        $hasher = new CryptHash('sha256');
        $hasher->setKey($key);
        $hashedInput = $hasher->hash($input);

        if (empty($hashedInput)) {
            return false;
        }

        return bin2hex($hashedInput) . ':' . $key;
    }

}
