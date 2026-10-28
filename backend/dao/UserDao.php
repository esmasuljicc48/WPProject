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
}
