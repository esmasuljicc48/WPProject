<?php
/** PRESENTATION LAYER – reviews. Keep OpenAPI paths in sync with this file. */

Flight::route('GET /reviews', function () {
    Flight::json(Flight::review_service()->get_all());
});

Flight::route('GET /reviews/@id:[0-9]+', function ($id) {
    Flight::json(Flight::review_service()->get_by_id($id));
});

Flight::route('GET /projects/@id:[0-9]+/reviews', function ($id) {
    Flight::json(Flight::review_service()->get_by_project($id));
});

Flight::route('POST /reviews', function () {
    $data = get_request_data();
    Flight::json(Flight::review_service()->add($data), 201);
});

Flight::route('PUT /reviews/@id:[0-9]+', function ($id) {
    $data = get_request_data();
    Flight::json(Flight::review_service()->update($data, $id));
});

Flight::route('DELETE /reviews/@id:[0-9]+', function ($id) {
    Flight::review_service()->delete($id);
    Flight::json(['message' => 'Review deleted.']);
});
