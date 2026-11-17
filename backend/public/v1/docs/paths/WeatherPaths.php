<?php

use OpenApi\Attributes as OA;

class WeatherPaths
{
    #[OA\Get(path: '/weather/forecast', summary: 'Get a city weather forecast', tags: ['weather'], parameters: [
        new OA\Parameter(name: 'city', in: 'query', required: true, example: 'Sarajevo', schema: new OA\Schema(type: 'string')),
        new OA\Parameter(name: 'days', in: 'query', required: false, example: 7, schema: new OA\Schema(type: 'integer', minimum: 1, maximum: 16))
    ], responses: [
        new OA\Response(response: 200, description: 'Weather forecast', content: new OA\JsonContent(ref: '#/components/schemas/Forecast')),
        new OA\Response(response: 400, description: 'Invalid query', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
        new OA\Response(response: 404, description: 'City not found', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
        new OA\Response(response: 503, description: 'Weather service unavailable', content: new OA\JsonContent(ref: '#/components/schemas/Error'))
    ])]
    public function forecast() {}
}
