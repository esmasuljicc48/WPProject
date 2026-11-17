<?php

require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/../dao/CategoryDao.php';

class CategoryService extends BaseService
{
    protected $entity_name = 'Category';

    public function __construct($dao = null)
    {
        parent::__construct($dao ?: new CategoryDao());
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
        $project_count = $this->dao->count_projects($id);
        if ($project_count > 0) {
            throw new ValidationException("This category still contains $project_count project(s).");
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
        if ($existing && (int) $existing['id'] !== (int) $id) {
            throw new ValidationException("A category named '{$category['name']}' already exists.");
        }
    }
}
