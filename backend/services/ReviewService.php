<?php

require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/../dao/ReviewDao.php';
require_once __DIR__ . '/../dao/UserDao.php';
require_once __DIR__ . '/../dao/ProjectDao.php';

class ReviewService extends BaseService
{
    protected $entity_name = 'Review';
    private $user_dao;
    private $project_dao;

    /** DAOs can be passed in (used by unit tests); by default real DAOs are created. */
    public function __construct($dao = null, $user_dao = null, $project_dao = null)
    {
        parent::__construct($dao ?? new ReviewDao());
        $this->user_dao = $user_dao ?? new UserDao();
        $this->project_dao = $project_dao ?? new ProjectDao();
    }

    public function add($review)
    {
        Validator::required($review, ['project_id', 'user_id']);
        Validator::integer($review['project_id'], 'project_id', 1);
        Validator::integer($review['user_id'], 'user_id', 1);
        if (!$this->project_dao->get_by_id($review['project_id'])) {
            throw new ValidationException('The selected project does not exist.');
        }
        if (!$this->user_dao->get_by_id($review['user_id'])) {
            throw new ValidationException('The selected user does not exist.');
        }
        // Rule: a user can review a project only once.
        if ($this->dao->get_by_user_and_project($review['user_id'], $review['project_id'])) {
            throw new ValidationException('You have already reviewed this project. Edit your existing review instead.');
        }

        return parent::add($this->empty_to_null(
            $review,
            ['pattern_source', 'pattern_url', 'yarn_used', 'hook_needle_size', 'notes']
        ));
    }

    public function get_by_project($project_id)
    {
        Validator::integer($project_id, 'project_id', 1);
        if (!$this->project_dao->get_by_id($project_id)) {
            throw new NotFoundException('Project not found.');
        }

        return $this->dao->get_by_project($project_id);
    }

    public function update($review, $id)
    {
        $review = $this->empty_to_null(
            $review,
            ['pattern_source', 'pattern_url', 'yarn_used', 'hook_needle_size', 'notes']
        );
        $changes = [];
        foreach (['rating', 'pattern_source', 'pattern_url', 'yarn_used', 'hook_needle_size', 'notes'] as $field) {
            if (array_key_exists($field, $review)) {
                $changes[$field] = $review[$field];
            }
        }

        return parent::update($changes, $id);
    }

    protected function validate($review, $id = null)
    {
        Validator::required($review, ['rating']);
        Validator::integer($review['rating'], 'rating', 1, 5);
        if (isset($review['pattern_url']) && trim((string) $review['pattern_url']) !== '') {
            Validator::url($review['pattern_url'], 'pattern_url');
        }
        if (!empty($review['pattern_source'])) {
            Validator::length($review['pattern_source'], 'pattern_source', 0, 2000);
        }
        if (!empty($review['yarn_used'])) {
            Validator::length($review['yarn_used'], 'yarn_used', 0, 255);
        }
        if (!empty($review['hook_needle_size'])) {
            Validator::length($review['hook_needle_size'], 'hook_needle_size', 0, 100);
        }
        if (!empty($review['notes'])) {
            Validator::length($review['notes'], 'notes', 0, 2000);
        }
    }
}
