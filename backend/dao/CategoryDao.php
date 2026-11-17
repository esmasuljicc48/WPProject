<?php
require_once __DIR__ . '/BaseDao.php';

class CategoryDao extends BaseDao
{
    public function __construct()
    {
        parent::__construct('categories', ['name', 'description']);
    }

    public function get_by_name($name)
    {
        return $this->query_unique(
            'SELECT * FROM categories WHERE name = :name',
            ['name' => $name]
        );
    }

    public function count_projects($category_id)
    {
        $result = $this->query_unique(
            'SELECT COUNT(*) AS total FROM projects WHERE category_id = :category_id',
            ['category_id' => $category_id]
        );

        return (int) $result['total'];
    }
}
