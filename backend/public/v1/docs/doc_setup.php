<?php

use OpenApi\Attributes as OA;

#[OA\Info(
    title: 'Looply API',
    description: 'REST API for the Looply stitch diary.',
    version: '1.0.0'
)]
#[OA\Server(url: API_BASE_URL, description: 'Current Looply backend')]
#[OA\Schema(
    schema: 'Error',
    properties: [new OA\Property(property: 'error', type: 'string', example: 'Project not found.')],
    type: 'object'
)]
#[OA\Schema(
    schema: 'Message',
    properties: [new OA\Property(property: 'message', type: 'string', example: 'Project deleted.')],
    type: 'object'
)]
#[OA\Schema(
    schema: 'CategoryInput',
    required: ['name'],
    properties: [
        new OA\Property(property: 'name', type: 'string', example: 'Knitting'),
        new OA\Property(property: 'description', type: 'string', nullable: true, example: 'Needlework projects.')
    ],
    type: 'object'
)]
#[OA\Schema(
    schema: 'Category',
    allOf: [new OA\Schema(ref: '#/components/schemas/CategoryInput')],
    properties: [new OA\Property(property: 'id', type: 'integer', example: 1)],
    type: 'object'
)]
#[OA\Schema(
    schema: 'UserInput',
    required: ['first_name', 'last_name', 'email'],
    properties: [
        new OA\Property(property: 'first_name', type: 'string', example: 'Maya'),
        new OA\Property(property: 'last_name', type: 'string', example: 'Parker'),
        new OA\Property(property: 'email', type: 'string', format: 'email', example: 'maya@example.test'),
        new OA\Property(property: 'password', type: 'string', format: 'password', example: 'stitchpass'),
        new OA\Property(property: 'role', type: 'string', enum: ['user', 'admin'], example: 'user'),
        new OA\Property(property: 'avatar_url', type: 'string', nullable: true),
        new OA\Property(property: 'location', type: 'string', nullable: true),
        new OA\Property(property: 'bio', type: 'string', nullable: true)
    ],
    type: 'object'
)]
#[OA\Schema(
    schema: 'User',
    allOf: [new OA\Schema(ref: '#/components/schemas/UserInput')],
    properties: [new OA\Property(property: 'id', type: 'integer', example: 1)],
    type: 'object'
)]
#[OA\Schema(
    schema: 'ProjectInput',
    required: ['user_id', 'category_id', 'title', 'image_url', 'privacy'],
    properties: [
        new OA\Property(property: 'user_id', type: 'integer', example: 1),
        new OA\Property(property: 'category_id', type: 'integer', example: 1),
        new OA\Property(property: 'title', type: 'string', example: 'Harbor Mist Cardigan'),
        new OA\Property(property: 'description', type: 'string', nullable: true),
        new OA\Property(property: 'image_url', type: 'string', example: 'https://example.test/cardigan.jpg'),
        new OA\Property(property: 'privacy', type: 'string', enum: ['public', 'private'], example: 'public')
    ],
    type: 'object'
)]
#[OA\Schema(
    schema: 'Project',
    allOf: [new OA\Schema(ref: '#/components/schemas/ProjectInput')],
    properties: [new OA\Property(property: 'id', type: 'integer', example: 1)],
    type: 'object'
)]
#[OA\Schema(
    schema: 'ReviewInput',
    required: ['project_id', 'user_id', 'rating'],
    properties: [
        new OA\Property(property: 'project_id', type: 'integer', example: 1),
        new OA\Property(property: 'user_id', type: 'integer', example: 1),
        new OA\Property(property: 'rating', type: 'integer', minimum: 1, maximum: 5, example: 5),
        new OA\Property(property: 'pattern_source', type: 'string', nullable: true),
        new OA\Property(property: 'pattern_url', type: 'string', nullable: true),
        new OA\Property(property: 'yarn_used', type: 'string', nullable: true),
        new OA\Property(property: 'hook_needle_size', type: 'string', nullable: true),
        new OA\Property(property: 'notes', type: 'string', nullable: true)
    ],
    type: 'object'
)]
#[OA\Schema(
    schema: 'Review',
    allOf: [new OA\Schema(ref: '#/components/schemas/ReviewInput')],
    properties: [new OA\Property(property: 'id', type: 'integer', example: 1)],
    type: 'object'
)]
#[OA\Schema(
    schema: 'Favorite',
    required: ['user_id', 'project_id'],
    properties: [
        new OA\Property(property: 'user_id', type: 'integer', example: 1),
        new OA\Property(property: 'project_id', type: 'integer', example: 1)
    ],
    type: 'object'
)]
#[OA\Schema(
    schema: 'ForecastDay',
    properties: [
        new OA\Property(property: 'date', type: 'string', format: 'date'),
        new OA\Property(property: 'weather_code', type: 'integer'),
        new OA\Property(property: 'description', type: 'string'),
        new OA\Property(property: 'icon', type: 'string'),
        new OA\Property(property: 'temperature_max', type: 'number'),
        new OA\Property(property: 'temperature_min', type: 'number')
    ],
    type: 'object'
)]
#[OA\Schema(
    schema: 'Forecast',
    properties: [
        new OA\Property(property: 'city', type: 'string'),
        new OA\Property(property: 'country', type: 'string', nullable: true),
        new OA\Property(property: 'days', type: 'array', items: new OA\Items(ref: '#/components/schemas/ForecastDay'))
    ],
    type: 'object'
)]
class OpenApiSpec
{
}
