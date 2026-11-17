<?php

Flight::route('GET /weather/forecast', function () {
    $query = Flight::request()->query;
    Flight::json(Flight::weather_service()->forecast(
        $query['city'] ?? '',
        $query['days'] ?? 7
    ));
});
