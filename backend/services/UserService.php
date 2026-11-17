<?php

require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/../dao/UserDao.php';
require_once __DIR__ . '/../utils/Roles.php';

class UserService extends BaseService
{
    protected $entity_name = 'User';

    /** DAOs can be passed in (used by unit tests); by default real DAOs are created. */
    public function __construct($dao = null)
    {
        parent::__construct($dao ?? new UserDao());
    }

    public function add($user)
    {
        unset($user['password_hash']);
        $user['role'] = $user['role'] ?? Roles::USER;
        $user = $this->empty_to_null($user, ['avatar_url', 'location', 'bio']);
        $this->validate($user);
        Validator::required($user, ['password']);
        Validator::password($user['password']);
        $user['email'] = strtolower(trim($user['email']));
        $user['password_hash'] = password_hash($user['password'], PASSWORD_BCRYPT);
        unset($user['password']);

        return parent::add($user);
    }

    public function update($user, $id)
    {
        unset($user['password_hash']);
        $existing = $this->get_by_id($id);
        $user['role'] = $user['role'] ?? $existing['role'];
        $user = $this->empty_to_null($user, ['avatar_url', 'location', 'bio']);
        $this->validate($user, $id);
        $user['email'] = strtolower(trim($user['email']));

        if (empty($user['password'])) {
            unset($user['password']);
        } else {
            Validator::password($user['password']);
            $user['password_hash'] = password_hash($user['password'], PASSWORD_BCRYPT);
            unset($user['password']);
        }

        $this->dao->update($user, $id);

        return $this->dao->get_by_id($id);
    }

    protected function validate($user, $id = null)
    {
        Validator::required($user, ['first_name', 'last_name', 'email', 'role']);
        Validator::length($user['first_name'], 'first_name', 1, 100);
        Validator::length($user['last_name'], 'last_name', 1, 100);
        Validator::email($user['email']);
        Validator::one_of($user['role'], 'role', Roles::all());

        $existing = $this->dao->get_by_email(strtolower(trim($user['email'])));
        // Rule: user e-mail addresses must be unique.
        if ($existing && (int) $existing['id'] !== (int) $id) {
            throw new ValidationException('A user with this e-mail already exists.');
        }
    }

}
