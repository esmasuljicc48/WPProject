<?php

require_once __DIR__ . '/../utils/exceptions.php';
require_once __DIR__ . '/../utils/Validator.php';
require_once __DIR__ . '/../dao/FavoriteDao.php';
require_once __DIR__ . '/../dao/UserDao.php';
require_once __DIR__ . '/../dao/ProjectDao.php';

class FavoriteService
{
    private $dao;
    private $user_dao;
    private $project_dao;

    public function __construct($dao = null, $user_dao = null, $project_dao = null)
    {
        $this->dao = $dao ?: new FavoriteDao();
        $this->user_dao = $user_dao ?: new UserDao();
        $this->project_dao = $project_dao ?: new ProjectDao();
    }

    public function get_all()
    {
        return $this->dao->get_all();
    }

    public function get_by_id($user_id, $project_id)
    {
        $favorite = $this->dao->get_by_user_and_project($user_id, $project_id);
        if (!$favorite) {
            throw new NotFoundException('Favorite not found.');
        }

        return $favorite;
    }

    public function add($favorite)
    {
        Validator::required($favorite, ['user_id', 'project_id']);
        Validator::integer($favorite['user_id'], 'user_id', 1);
        Validator::integer($favorite['project_id'], 'project_id', 1);
        if (!$this->user_dao->get_by_id($favorite['user_id'])) {
            throw new ValidationException('The selected user does not exist.');
        }
        if (!$this->project_dao->get_by_id($favorite['project_id'])) {
            throw new ValidationException('The selected project does not exist.');
        }
        if ($this->dao->get_by_user_and_project($favorite['user_id'], $favorite['project_id'])) {
            throw new ValidationException('This project is already saved as a favorite.');
        }

        $this->dao->add($favorite);

        return $this->get_by_id($favorite['user_id'], $favorite['project_id']);
    }

    public function update($favorite, $user_id, $project_id)
    {
        $this->get_by_id($user_id, $project_id);
        throw new ValidationException('Favorites do not have editable fields.');
    }

    public function delete($user_id, $project_id)
    {
        $this->get_by_id($user_id, $project_id);
        $this->dao->delete_by_user_and_project($user_id, $project_id);
    }
}
