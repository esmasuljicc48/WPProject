<?php

require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/../dao/ProjectDao.php';
require_once __DIR__ . '/../dao/UserDao.php';
require_once __DIR__ . '/../dao/CategoryDao.php';

class ProjectService extends BaseService
{
    protected $entity_name = 'Project';
    private $user_dao;
    private $category_dao;

    public function __construct($dao = null, $user_dao = null, $category_dao = null)
    {
        parent::__construct($dao ?: new ProjectDao());
        $this->user_dao = $user_dao ?: new UserDao();
        $this->category_dao = $category_dao ?: new CategoryDao();
    }

    public function get_public_feed()
    {
        return $this->dao->get_public_feed();
    }

    public function get_by_user($user_id)
    {
        if (!$this->user_dao->get_by_id($user_id)) {
            throw new NotFoundException('User not found.');
        }

        return $this->dao->get_by_user($user_id);
    }

    protected function validate($project, $id = null)
    {
        Validator::required($project, ['user_id', 'category_id', 'title', 'image_url', 'privacy']);
        Validator::integer($project['user_id'], 'user_id', 1);
        Validator::integer($project['category_id'], 'category_id', 1);
        Validator::length($project['title'], 'title', 2, 255);
        Validator::length($project['image_url'], 'image_url', 1, 500);
        Validator::in($project['privacy'], 'privacy', ['public', 'private']);
        if (!$this->user_dao->get_by_id($project['user_id'])) {
            throw new ValidationException('The selected user does not exist.');
        }
        if (!$this->category_dao->get_by_id($project['category_id'])) {
            throw new ValidationException('The selected category does not exist.');
        }
    }
}
