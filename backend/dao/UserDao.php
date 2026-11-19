<?php
require_once __DIR__ . '/BaseDao.php';

class UserDao extends BaseDao
{
    public function __construct()
    {
        parent::__construct('users', [
            'first_name', 'last_name', 'email', 'password_hash', 'role',
            'avatar_url', 'location', 'bio'
        ]);
    }

    public function get_all()
    {
        return $this->query(
            'SELECT id, first_name, last_name, email, role, avatar_url, location, bio, created_at, updated_at
             FROM users ORDER BY id'
        );
    }

    public function get_by_id($id)
    {
        return $this->query_unique(
            'SELECT id, first_name, last_name, email, role, avatar_url, location, bio, created_at, updated_at
             FROM users WHERE id = :id',
            ['id' => $id]
        );
    }

    public function get_by_email($email)
    {
        return $this->query_unique(
            'SELECT * FROM users WHERE email = :email',
            ['email' => $email]
        );
    }
}
