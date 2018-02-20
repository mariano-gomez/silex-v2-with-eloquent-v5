<?php
/**
 * Created by PhpStorm.
 * User: Mariano
 * Date: 08/02/18
 * Time: 6:47 PM
 */

namespace App\Security;


use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

class EloquentUserProvider implements UserProviderInterface
{
    private $conn;

    public function __construct($eloquent)
    {
        $this->conn = $eloquent->getConnection();
    }

    public function loadUserByUsername($username)
    {
        $user = $this->conn->table('users')->where('username', $username)->first();
        if (!$user) {
            throw new UsernameNotFoundException(sprintf('Username "%s" does not exist.', $username));
        }

        return new User($user->username, $user->password, explode(',', $user->roles), true, true, true, true);
    }

    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', get_class($user)));
        }

        return $this->loadUserByUsername($user->getUsername());
    }

    public function supportsClass($class)
    {
        return $class === 'Symfony\Component\Security\Core\User\User';
    }
}