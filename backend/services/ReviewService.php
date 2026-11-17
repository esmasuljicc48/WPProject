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

    public function __construct($dao = null, $user_dao = null, $project_dao = null)
    {
        parent::__construct($dao ?: new ReviewDao());
        $this->user_dao = $user_dao ?: new UserDao();
        $this->project_dao = $project_dao ?: new ProjectDao();
    }

    protected function validate($review, $id = null)
    {
        Validator::required($review, ['project_id', 'user_id', 'rating']);
        Validator::integer($review['project_id'], 'project_id', 1);
        Validator::integer($review['user_id'], 'user_id', 1);
        Validator::integer($review['rating'], 'rating', 1, 5);
        if (isset($review['pattern_url']) && trim((string) $review['pattern_url']) !== '') {
            Validator::url($review['pattern_url'], 'pattern_url');
        }
        if (!$this->project_dao->get_by_id($review['project_id'])) {
            throw new ValidationException('The selected project does not exist.');
        }
        if (!$this->user_dao->get_by_id($review['user_id'])) {
            throw new ValidationException('The selected user does not exist.');
        }
    }
}
