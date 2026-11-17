<?php

Flight::route('GET /favorites', function () {
    Flight::json(Flight::favorite_service()->get_all());
});

Flight::route('GET /favorites/@user_id:[0-9]+/@project_id:[0-9]+', function ($user_id, $project_id) {
    Flight::json(Flight::favorite_service()->get_by_id($user_id, $project_id));
});

Flight::route('POST /favorites', function () {
    Flight::json(Flight::favorite_service()->add(Flight::request()->data->getData()), 201);
});

Flight::route('PUT /favorites/@user_id:[0-9]+/@project_id:[0-9]+', function ($user_id, $project_id) {
    Flight::json(Flight::favorite_service()->update(
        Flight::request()->data->getData(),
        $user_id,
        $project_id
    ));
});

Flight::route('DELETE /favorites/@user_id:[0-9]+/@project_id:[0-9]+', function ($user_id, $project_id) {
    Flight::favorite_service()->delete($user_id, $project_id);
    Flight::json(['message' => 'Favorite deleted.']);
});
