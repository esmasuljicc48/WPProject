<?php
/** PRESENTATION LAYER – favorites. Keep OpenAPI paths in sync with this file. */

Flight::route('GET /favorites', function () {
    Flight::json(Flight::favorite_service()->get_all());
});

Flight::route('GET /favorites/@user_id:[0-9]+/@project_id:[0-9]+', function ($user_id, $project_id) {
    Flight::json(Flight::favorite_service()->get_by_id($user_id, $project_id));
});

Flight::route('GET /users/@id:[0-9]+/favorites', function ($id) {
    Flight::json(Flight::favorite_service()->get_by_user($id));
});

Flight::route('POST /favorites', function () {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::favorite_service()->add($data), 201);
});

Flight::route('PUT /favorites/@user_id:[0-9]+/@project_id:[0-9]+', function ($user_id, $project_id) {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::favorite_service()->update($data, $user_id, $project_id));
});

Flight::route('DELETE /favorites/@user_id:[0-9]+/@project_id:[0-9]+', function ($user_id, $project_id) {
    Flight::favorite_service()->delete($user_id, $project_id);
    Flight::json(['message' => 'Favorite deleted.']);
});
