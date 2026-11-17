<?php
/*
 * HTTP request -> routes -> services -> DAO -> MySQL
 */

require __DIR__ . '/vendor/autoload.php';
if (!file_exists(__DIR__ . '/config/config.php')) {
    http_response_code(500);
    exit('Missing backend/config/config.php – copy config.example.php to config.php and set your database credentials.');
}

require_once __DIR__ . '/services/CategoryService.php';
require_once __DIR__ . '/services/UserService.php';
require_once __DIR__ . '/services/ProjectService.php';
require_once __DIR__ . '/services/ReviewService.php';
require_once __DIR__ . '/services/FavoriteService.php';
require_once __DIR__ . '/services/OpenMeteoService.php';

/* Register every service once; routes access the shared service instances. */
Flight::register('category_service', 'CategoryService');
Flight::register('user_service', 'UserService');
Flight::register('project_service', 'ProjectService');
Flight::register('review_service', 'ReviewService');
Flight::register('favorite_service', 'FavoriteService');
Flight::register('open_meteo_service', 'OpenMeteoService');

/* One global handler converts service exceptions into safe JSON responses. */
Flight::map('error', function (Throwable $exception) {
    if ($exception instanceof HttpException) {
        $status = $exception->get_status();
        $message = $exception->getMessage();
    } else {
        $status = 500;
        $message = 'Something went wrong on the server. Please try again later.';
        error_log((string) $exception);
    }

    Flight::response()
        ->clearBody()
        ->status($status)
        ->header('Content-Type', 'application/json')
        ->write(json_encode(['error' => $message]))
        ->send();
});

Flight::map('notFound', function () {
    Flight::response()
        ->clearBody()
        ->status(404)
        ->header('Content-Type', 'application/json')
        ->write(json_encode(['error' => 'Endpoint not found.']))
        ->send();
});

Flight::route('GET /', function () {
    Flight::json([
        'app' => 'Looply API',
        'message' => 'The backend is running.',
        'docs' => 'public/v1/docs/'
    ]);
});

require_once __DIR__ . '/routes/CategoryRoutes.php';
require_once __DIR__ . '/routes/UserRoutes.php';
require_once __DIR__ . '/routes/ProjectRoutes.php';
require_once __DIR__ . '/routes/ReviewRoutes.php';
require_once __DIR__ . '/routes/FavoriteRoutes.php';
require_once __DIR__ . '/routes/WeatherRoutes.php';

Flight::start();
