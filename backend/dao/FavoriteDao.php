<?php
require_once __DIR__ . '/BaseDao.php';

class FavoriteDao extends BaseDao
{
    public function __construct()
    {
        parent::__construct('favorites', ['user_id', 'project_id']);
    }

    public function get_all()
    {
        return $this->query('SELECT * FROM favorites ORDER BY created_at DESC');
    }

    public function get_by_user_and_project($user_id, $project_id)
    {
        return $this->query_unique(
            'SELECT * FROM favorites WHERE user_id = :user_id AND project_id = :project_id',
            ['user_id' => $user_id, 'project_id' => $project_id]
        );
    }

    public function get_projects_by_user($user_id)
    {
        return $this->query(
            'SELECT
                f.created_at AS favorited_at,
                p.*,
                c.name AS category_name,
                u.first_name AS owner_first_name,
                u.last_name AS owner_last_name,
                u.avatar_url AS owner_avatar_url
             FROM favorites f
             JOIN projects p ON p.id = f.project_id
             JOIN categories c ON c.id = p.category_id
             JOIN users u ON u.id = p.user_id
             WHERE f.user_id = :user_id
             ORDER BY f.created_at DESC',
            ['user_id' => $user_id]
        );
    }

    public function delete_by_user_and_project($user_id, $project_id)
    {
        return $this->execute(
            'DELETE FROM favorites WHERE user_id = :user_id AND project_id = :project_id',
            ['user_id' => $user_id, 'project_id' => $project_id]
        );
    }
}
