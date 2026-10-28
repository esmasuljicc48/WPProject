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
}
