<?php

require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/../dao/UserDao.php';

class UserService extends BaseService
{
    protected $entity_name = 'User';

    public function __construct($dao = null)
    {
        parent::__construct($dao ?: new UserDao());
    }

    public function add($user)
    {
        Validator::required($user, ['password']);
        $this->validate_password($user['password']);
        $user['email'] = strtolower(trim($user['email']));
        $user['password_hash'] = password_hash($user['password'], PASSWORD_BCRYPT);
        unset($user['password']);

        return parent::add($user);
    }

    public function update($user, $id)
    {
        if (array_key_exists('password', $user)) {
            $this->validate_password($user['password']);
            $user['password_hash'] = password_hash($user['password'], PASSWORD_BCRYPT);
            unset($user['password']);
        }
        if (isset($user['email'])) {
            $user['email'] = strtolower(trim($user['email']));
        }

        return parent::update($user, $id);
    }

    protected function validate($user, $id = null)
    {
        Validator::required($user, ['first_name', 'last_name', 'email']);
        Validator::length($user['first_name'], 'first_name', 1, 100);
        Validator::length($user['last_name'], 'last_name', 1, 100);
        Validator::email($user['email']);
        if (isset($user['role'])) {
            Validator::in($user['role'], 'role', ['user', 'admin']);
        }

        $existing = $this->dao->get_by_email(strtolower(trim($user['email'])));
        if ($existing && (int) $existing['id'] !== (int) $id) {
            throw new ValidationException('A user with this e-mail already exists.');
        }
    }

    private function validate_password($password)
    {
        if (strlen($password) < 8) {
            throw new ValidationException('Password must be at least 8 characters long.');
        }
    }
}
