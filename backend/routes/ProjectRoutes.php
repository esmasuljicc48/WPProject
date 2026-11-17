<?php
/** PRESENTATION LAYER – projects. Keep OpenAPI paths in sync with this file. */

Flight::route('GET /projects', function () {
    $query = Flight::request()->query;
    Flight::json(Flight::project_service()->get_feed($query['privacy'] ?? null));
});

Flight::route('GET /projects/@id:[0-9]+', function ($id) {
    Flight::json(Flight::project_service()->get_by_id($id));
});

Flight::route('POST /projects', function () {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::project_service()->add($data), 201);
});

Flight::route('PUT /projects/@id:[0-9]+', function ($id) {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::project_service()->update($data, $id));
});

Flight::route('DELETE /projects/@id:[0-9]+', function ($id) {
    Flight::project_service()->delete($id);
    Flight::json(['message' => 'Project deleted.']);
});
