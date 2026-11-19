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

    /** DAOs can be passed in (used by unit tests); by default real DAOs are created. */
    public function __construct($dao = null, $user_dao = null, $category_dao = null)
    {
        parent::__construct($dao ?? new ProjectDao());
        $this->user_dao = $user_dao ?? new UserDao();
        $this->category_dao = $category_dao ?? new CategoryDao();
    }

    public function get_feed($privacy = null)
    {
        if ($privacy !== null) {
            Validator::one_of($privacy, 'privacy', ['public', 'private']);
        }

        return $this->dao->get_feed($privacy);
    }

    public function get_by_user($user_id)
    {
        if (!$this->user_dao->get_by_id($user_id)) {
            throw new NotFoundException('User not found.');
        }

        return $this->dao->get_by_user($user_id);
    }

    public function add($project)
    {
        return parent::add($this->empty_to_null($project, ['description']));
    }

    public function update($project, $id)
    {
        return parent::update($this->empty_to_null($project, ['description']), $id);
    }

    protected function validate($project, $id = null)
    {
        Validator::required($project, ['user_id', 'category_id', 'title', 'image_url', 'privacy']);
        Validator::integer($project['user_id'], 'user_id', 1);
        Validator::integer($project['category_id'], 'category_id', 1);
        Validator::length($project['title'], 'title', 2, 255);
        Validator::length($project['image_url'], 'image_url', 1, 500);
        Validator::url($project['image_url'], 'image_url');
        if (!empty($project['description'])) {
            Validator::length($project['description'], 'description', 0, 5000);
        }
        Validator::one_of($project['privacy'], 'privacy', ['public', 'private']);
        // Rule: the project owner and category must exist.
        if (!$this->user_dao->get_by_id($project['user_id'])) {
            throw new ValidationException('The selected user does not exist.');
        }
        if (!$this->category_dao->get_by_id($project['category_id'])) {
            throw new ValidationException('The selected category does not exist.');
        }
    }
}
