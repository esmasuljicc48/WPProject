<?php
require_once __DIR__ . '/../dao/CategoryDao.php';
require_once __DIR__ . '/../dao/UserDao.php';
require_once __DIR__ . '/../dao/ProjectDao.php';
require_once __DIR__ . '/../dao/ReviewDao.php';
require_once __DIR__ . '/../dao/FavoriteDao.php';

function display_value($value)
{
    return ($value === null || $value === '') ? '-' : $value;
}

try {
    $category_dao = new CategoryDao();
    $user_dao = new UserDao();
    $project_dao = new ProjectDao();
    $review_dao = new ReviewDao();
    $favorite_dao = new FavoriteDao();

    $categories = $category_dao->get_all();
    $users = $user_dao->get_all();
    $projects = $project_dao->get_all();
    $reviews = $review_dao->get_all();
    $favorites = $favorite_dao->get_all();

    $categories_by_id = [];
    foreach ($categories as $category) {
        $categories_by_id[$category['id']] = $category['name'];
    }

    $users_by_id = [];
    foreach ($users as $user) {
        $users_by_id[$user['id']] = $user['first_name'] . ' ' . $user['last_name'];
    }

    $projects_by_id = [];
    foreach ($projects as $project) {
        $projects_by_id[$project['id']] = $project['title'];
    }

    echo "=== Categories (" . count($categories) . ") ===\n";
    foreach ($categories as $category) {
        echo sprintf(
            "#%d | %s | %s\n",
            $category['id'],
            $category['name'],
            display_value($category['description'])
        );
    }

    echo "\n=== Users (" . count($users) . ") ===\n";
    foreach ($users as $user) {
        echo sprintf(
            "#%d | %s | %s | role=%s | location=%s\n",
            $user['id'],
            $users_by_id[$user['id']],
            $user['email'],
            $user['role'],
            display_value($user['location'])
        );
    }

    echo "\n=== Projects (" . count($projects) . ") ===\n";
    foreach ($projects as $project) {
        echo sprintf(
            "#%d | %s | owner=%s | category=%s | privacy=%s\n",
            $project['id'],
            $project['title'],
            $users_by_id[$project['user_id']] ?? 'Unknown user',
            $categories_by_id[$project['category_id']] ?? 'Unknown category',
            $project['privacy']
        );
    }

    echo "\n=== Reviews (" . count($reviews) . ") ===\n";
    foreach ($reviews as $review) {
        echo sprintf(
            "#%d | project=%s | reviewer=%s | rating=%d/5 | yarn=%s | size=%s\n",
            $review['id'],
            $projects_by_id[$review['project_id']] ?? 'Unknown project',
            $users_by_id[$review['user_id']] ?? 'Unknown user',
            $review['rating'],
            display_value($review['yarn_used']),
            display_value($review['hook_needle_size'])
        );
    }

    echo "\n=== Favorites (" . count($favorites) . ") ===\n";
    foreach ($favorites as $favorite) {
        echo sprintf(
            "%s favorited \"%s\" (project_id=%d)\n",
            $users_by_id[$favorite['user_id']] ?? 'Unknown user',
            $projects_by_id[$favorite['project_id']] ?? 'Unknown project',
            $favorite['project_id']
        );
    }

    echo "\nDAO inspection completed. No data was changed.\n";
} catch (Throwable $exception) {
    fwrite(STDERR, "DAO inspection failed: {$exception->getMessage()}\n");
    exit(1);
}
