<?php

namespace App\User;

use App\Exceptions\UserValidation\EmailExists;
use App\Exceptions\UserValidation\InvalidPassword;
use App\Exceptions\UserValidation\Required;
use App\Security\Password;
use Illuminate\Database\Eloquent\Model;

/**
 * User class
 */
class User extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $appends = [
        'fullName',
    ];

    protected const MINPASSLENGTH = 8;

    public static function boot()
    {
        parent::boot();
    }

    /**
     * @param string $firstName
     * @param string $lastName
     * @param string $email
     * @param string $password
     * @return User
     * @throws EmailExists
     * @throws Required
     * @throws InvalidPassword
     */
    public static function createUser(
        string $firstName,
        string $lastName,
        string $email,
        string $password
    ): User {
        $firstName = trim($firstName);
        $lastName = trim($lastName);
        $email = trim($email);
        $password = trim($password);

        if (empty($email)) {
            throw new Required('No email provided. Please provide an email.');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Required('Please provide a valid email.');
        }

        if (self::scopeEmailExists($email)) {
            throw new EmailExists();
        }

        if (empty($password)) {
            throw new Required('Password is required');
        }

        if (!self::validatePassword($password)) {
            throw new InvalidPassword('Password provided is invalid.');
        }

        $user = new self;
        $user->firstName = $firstName;
        $user->lastName = $lastName;
        $user->email = $email;
        $user->password = (new Password())->hash($password);
        $user->save();

        return $user;
    }

    public static function validatePassword(string $password): bool
    {
        if (strlen($password) >= self::MINPASSLENGTH) {
            return true;
        }

        return false;
    }

    private function scopeEmailExists(string $email)
    {
        return $this->where('email', $email)->exists();
    }
}
