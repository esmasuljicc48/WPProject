<?php
/** PRESENTATION LAYER – weather. Keep OpenAPI paths in sync with this file. */

Flight::route('GET /weather/forecast', function () {
    $query = Flight::request()->query;
    Flight::json(Flight::open_meteo_service()->forecast(
        $query['city'] ?? '',
        $query['days'] ?? 7
    ));
});
