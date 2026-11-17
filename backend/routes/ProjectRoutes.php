<?php

Flight::route('GET /projects', function () {
    Flight::json(Flight::project_service()->get_all());
});

Flight::route('GET /projects/public', function () {
    Flight::json(Flight::project_service()->get_public_feed());
});

Flight::route('GET /projects/user/@user_id:[0-9]+', function ($user_id) {
    Flight::json(Flight::project_service()->get_by_user($user_id));
});

Flight::route('GET /projects/@id:[0-9]+', function ($id) {
    Flight::json(Flight::project_service()->get_by_id($id));
});

Flight::route('POST /projects', function () {
    Flight::json(Flight::project_service()->add(Flight::request()->data->getData()), 201);
});

Flight::route('PUT /projects/@id:[0-9]+', function ($id) {
    Flight::json(Flight::project_service()->update(Flight::request()->data->getData(), $id));
});

Flight::route('DELETE /projects/@id:[0-9]+', function ($id) {
    Flight::project_service()->delete($id);
    Flight::json(['message' => 'Project deleted.']);
});
