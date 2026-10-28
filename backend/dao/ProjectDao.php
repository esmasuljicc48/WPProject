<?php
require_once __DIR__ . '/BaseDao.php';

class ProjectDao extends BaseDao
{
    public function __construct()
    {
        parent::__construct('projects', [
            'user_id', 'category_id', 'title', 'description', 'image_url', 'privacy'
        ]);
    }

    public function get_public_feed()
    {
        return $this->query(
            'SELECT
                p.*,
                c.name AS category_name,
                u.first_name AS owner_first_name,
                u.last_name AS owner_last_name,
                u.avatar_url AS owner_avatar_url,
                COALESCE(AVG(r.rating), 0) AS average_rating,
                COUNT(r.id) AS review_count
             FROM projects p
             JOIN categories c ON c.id = p.category_id
             JOIN users u ON u.id = p.user_id
             LEFT JOIN reviews r ON r.project_id = p.id
             WHERE p.privacy = :privacy
             GROUP BY p.id
             ORDER BY p.created_at DESC',
            ['privacy' => 'public']
        );
    }

    public function get_by_user($user_id)
    {
        return $this->query(
            'SELECT
                p.*,
                c.name AS category_name,
                COALESCE(AVG(r.rating), 0) AS average_rating,
                COUNT(r.id) AS review_count
             FROM projects p
             JOIN categories c ON c.id = p.category_id
             LEFT JOIN reviews r ON r.project_id = p.id
             WHERE p.user_id = :user_id
             GROUP BY p.id
             ORDER BY p.created_at DESC',
            ['user_id' => $user_id]
        );
    }
}
