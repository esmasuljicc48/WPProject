<?php

Flight::route('GET /reviews', function () {
    Flight::json(Flight::review_service()->get_all());
});

Flight::route('GET /reviews/@id:[0-9]+', function ($id) {
    Flight::json(Flight::review_service()->get_by_id($id));
});

Flight::route('POST /reviews', function () {
    Flight::json(Flight::review_service()->add(Flight::request()->data->getData()), 201);
});

Flight::route('PUT /reviews/@id:[0-9]+', function ($id) {
    Flight::json(Flight::review_service()->update(Flight::request()->data->getData(), $id));
});

Flight::route('DELETE /reviews/@id:[0-9]+', function ($id) {
    Flight::review_service()->delete($id);
    Flight::json(['message' => 'Review deleted.']);
});
