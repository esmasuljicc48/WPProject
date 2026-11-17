<?php
require_once __DIR__ . '/BaseDao.php';

class ReviewDao extends BaseDao
{
    public function __construct()
    {
        parent::__construct('reviews', [
            'project_id', 'user_id', 'rating', 'pattern_source', 'pattern_url',
            'yarn_used', 'hook_needle_size', 'notes'
        ]);
    }

    public function get_by_user_and_project($user_id, $project_id)
    {
        return $this->query_unique(
            'SELECT * FROM reviews WHERE user_id = :user_id AND project_id = :project_id',
            ['user_id' => $user_id, 'project_id' => $project_id]
        );
    }

    public function get_by_project($project_id)
    {
        return $this->query(
            'SELECT
                r.*,
                u.first_name AS reviewer_first_name,
                u.last_name AS reviewer_last_name,
                u.avatar_url AS reviewer_avatar_url
             FROM reviews r
             JOIN users u ON u.id = r.user_id
             WHERE r.project_id = :project_id
             ORDER BY r.created_at DESC',
            ['project_id' => $project_id]
        );
    }
}
