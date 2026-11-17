<?php

require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/../dao/CategoryDao.php';
require_once __DIR__ . '/../dao/ProjectDao.php';

class CategoryService extends BaseService
{
    protected $entity_name = 'Category';
    private $project_dao;

    /** DAOs can be passed in (used by unit tests); by default real DAOs are created. */
    public function __construct($dao = null, $project_dao = null)
    {
        parent::__construct($dao ?? new CategoryDao());
        $this->project_dao = $project_dao ?? new ProjectDao();
    }

    public function add($category)
    {
        return parent::add($this->empty_to_null($category, ['description']));
    }

    public function update($category, $id)
    {
        return parent::update($this->empty_to_null($category, ['description']), $id);
    }

    public function delete($id)
    {
        $this->get_by_id($id);
        $count = $this->project_dao->count_by_category($id);
        // Rule: a category with projects cannot be deleted.
        if ($count > 0) {
            throw new ValidationException("This category still contains $count project(s). Move or delete them first.");
        }
        $this->dao->delete($id);
    }

    protected function validate($category, $id = null)
    {
        Validator::required($category, ['name']);
        Validator::length($category['name'], 'name', 2, 100);
        if (!empty($category['description'])) {
            Validator::length($category['description'], 'description', 0, 1000);
        }

        $existing = $this->dao->get_by_name(trim($category['name']));
        // Rule: category names must be unique.
        if ($existing && (int) $existing['id'] !== (int) $id) {
            throw new ValidationException("A category named '{$category['name']}' already exists.");
        }
    }
}
