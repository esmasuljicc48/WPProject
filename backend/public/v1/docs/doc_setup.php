<?php

use OpenApi\Attributes as OA;

#[OA\Info(
    title: 'Looply API',
    description: 'REST API for the Looply stitch diary.',
    version: '1.0.0',
    contact: new OA\Contact(
        name: 'Looply API support'
    )
)]
#[OA\Server(
    url: API_BASE_URL,
    description: 'Current Looply backend'
)]
#[OA\Schema(
    schema: 'Error',
    type: 'object',
    properties: [
        new OA\Property(
            property: 'error',
            type: 'string',
            example: 'Project not found.'
        )
    ]
)]
#[OA\Schema(
    schema: 'Message',
    type: 'object',
    properties: [
        new OA\Property(
            property: 'message',
            type: 'string',
            example: 'Project deleted.'
        )
    ]
)]
#[OA\Schema(
    schema: 'CategoryInput',
    type: 'object',
    required: ['name'],
    properties: [
        new OA\Property(
            property: 'name',
            type: 'string',
            example: 'Knitting'
        ),
        new OA\Property(
            property: 'description',
            type: 'string',
            nullable: true,
            example: 'Needlework projects.'
        )
    ]
)]
#[OA\Schema(
    schema: 'Category',
    type: 'object',
    allOf: [
        new OA\Schema(
            ref: '#/components/schemas/CategoryInput'
        )
    ],
    properties: [
        new OA\Property(
            property: 'id',
            type: 'integer',
            example: 1
        ),
        new OA\Property(
            property: 'created_at',
            type: 'string',
            format: 'date-time',
            example: '2026-11-17 18:23:24'
        ),
        new OA\Property(
            property: 'updated_at',
            type: 'string',
            format: 'date-time',
            example: '2026-11-17 18:23:24'
        )
    ]
)]
#[OA\Schema(
    schema: 'UserInput',
    type: 'object',
    required: ['first_name', 'last_name', 'email', 'password'],
    properties: [
        new OA\Property(
            property: 'first_name',
            type: 'string',
            example: 'Maya'
        ),
        new OA\Property(
            property: 'last_name',
            type: 'string',
            example: 'Parker'
        ),
        new OA\Property(
            property: 'email',
            type: 'string',
            format: 'email',
            example: 'maya@example.test'
        ),
        new OA\Property(
            property: 'password',
            type: 'string',
            format: 'password',
            writeOnly: true,
            example: 'Stitchpass1'
        ),
        new OA\Property(
            property: 'role',
            type: 'string',
            enum: ['user', 'admin'],
            example: 'user'
        ),
        new OA\Property(
            property: 'avatar_url',
            type: 'string',
            nullable: true,
            example: 'https://example.test/maya.jpg'
        ),
        new OA\Property(
            property: 'location',
            type: 'string',
            nullable: true,
            example: 'Sarajevo'
        ),
        new OA\Property(
            property: 'bio',
            type: 'string',
            nullable: true,
            example: 'I make things slowly.'
        )
    ]
)]
#[OA\Schema(
    schema: 'User',
    type: 'object',
    required: ['id', 'first_name', 'last_name', 'email', 'role'],
    properties: [
        new OA\Property(
            property: 'id',
            type: 'integer',
            example: 1
        ),
        new OA\Property(
            property: 'first_name',
            type: 'string',
            example: 'Maya'
        ),
        new OA\Property(
            property: 'last_name',
            type: 'string',
            example: 'Parker'
        ),
        new OA\Property(
            property: 'email',
            type: 'string',
            format: 'email',
            example: 'maya@example.test'
        ),
        new OA\Property(
            property: 'role',
            type: 'string',
            enum: ['user', 'admin'],
            example: 'user'
        ),
        new OA\Property(
            property: 'avatar_url',
            type: 'string',
            nullable: true,
            example: 'https://example.test/maya.jpg'
        ),
        new OA\Property(
            property: 'location',
            type: 'string',
            nullable: true,
            example: 'Sarajevo'
        ),
        new OA\Property(
            property: 'bio',
            type: 'string',
            nullable: true,
            example: 'I make things slowly.'
        ),
        new OA\Property(
            property: 'created_at',
            type: 'string',
            format: 'date-time',
            example: '2026-11-17 18:23:24'
        ),
        new OA\Property(
            property: 'updated_at',
            type: 'string',
            format: 'date-time',
            example: '2026-11-17 18:23:24'
        )
    ]
)]
#[OA\Schema(
    schema: 'ProjectInput',
    type: 'object',
    required: ['user_id', 'category_id', 'title', 'image_url', 'privacy'],
    properties: [
        new OA\Property(
            property: 'user_id',
            type: 'integer',
            example: 1
        ),
        new OA\Property(
            property: 'category_id',
            type: 'integer',
            example: 1
        ),
        new OA\Property(
            property: 'title',
            type: 'string',
            example: 'Harbor Mist Cardigan'
        ),
        new OA\Property(
            property: 'description',
            type: 'string',
            nullable: true,
            example: 'A relaxed cardigan in pale blue wool.'
        ),
        new OA\Property(
            property: 'image_url',
            type: 'string',
            format: 'uri',
            example: 'https://example.test/cardigan.jpg'
        ),
        new OA\Property(
            property: 'privacy',
            type: 'string',
            enum: ['public', 'private'],
            example: 'public'
        )
    ]
)]
#[OA\Schema(
    schema: 'Project',
    type: 'object',
    allOf: [
        new OA\Schema(
            ref: '#/components/schemas/ProjectInput'
        )
    ],
    properties: [
        new OA\Property(
            property: 'id',
            type: 'integer',
            example: 1
        ),
        new OA\Property(
            property: 'created_at',
            type: 'string',
            format: 'date-time',
            example: '2026-11-17 18:23:24'
        ),
        new OA\Property(
            property: 'updated_at',
            type: 'string',
            format: 'date-time',
            example: '2026-11-17 18:23:24'
        )
    ]
)]
#[OA\Schema(
    schema: 'ProjectFeedItem',
    type: 'object',
    allOf: [
        new OA\Schema(
            ref: '#/components/schemas/Project'
        ),
        new OA\Schema(
            properties: [
                new OA\Property(
                    property: 'category_name',
                    type: 'string',
                    example: 'Knitting'
                ),
                new OA\Property(
                    property: 'owner_first_name',
                    type: 'string',
                    example: 'Maya'
                ),
                new OA\Property(
                    property: 'owner_last_name',
                    type: 'string',
                    example: 'Parker'
                ),
                new OA\Property(
                    property: 'owner_avatar_url',
                    type: 'string',
                    nullable: true,
                    example: 'https://example.test/maya.jpg'
                ),
                new OA\Property(
                    property: 'average_rating',
                    type: 'number',
                    format: 'float',
                    example: 4.5
                ),
                new OA\Property(
                    property: 'review_count',
                    type: 'integer',
                    example: 2
                ),
                new OA\Property(
                    property: 'created_at',
                    type: 'string',
                    format: 'date-time',
                    example: '2026-11-17 18:23:24'
                )
            ],
            type: 'object'
        )
    ]
)]
#[OA\Schema(
    schema: 'ReviewInput',
    type: 'object',
    required: ['project_id', 'user_id', 'rating'],
    properties: [
        new OA\Property(
            property: 'project_id',
            type: 'integer',
            example: 1
        ),
        new OA\Property(
            property: 'user_id',
            type: 'integer',
            example: 1
        ),
        new OA\Property(
            property: 'rating',
            type: 'integer',
            minimum: 1,
            maximum: 5,
            example: 5
        ),
        new OA\Property(
            property: 'pattern_source',
            type: 'string',
            nullable: true,
            example: 'Coastal Knits'
        ),
        new OA\Property(
            property: 'pattern_url',
            type: 'string',
            format: 'uri',
            nullable: true,
            example: 'https://example.test/pattern'
        ),
        new OA\Property(
            property: 'yarn_used',
            type: 'string',
            nullable: true,
            example: 'Wool blend'
        ),
        new OA\Property(
            property: 'hook_needle_size',
            type: 'string',
            nullable: true,
            example: '4 mm'
        ),
        new OA\Property(
            property: 'notes',
            type: 'string',
            nullable: true,
            example: 'The sleeves were easy to adjust.'
        )
    ]
)]
#[OA\Schema(
    schema: 'Review',
    type: 'object',
    allOf: [
        new OA\Schema(
            ref: '#/components/schemas/ReviewInput'
        )
    ],
    properties: [
        new OA\Property(
            property: 'id',
            type: 'integer',
            example: 1
        ),
        new OA\Property(
            property: 'created_at',
            type: 'string',
            format: 'date-time',
            example: '2026-11-17 18:23:24'
        ),
        new OA\Property(
            property: 'updated_at',
            type: 'string',
            format: 'date-time',
            example: '2026-11-17 18:23:24'
        )
    ]
)]
#[OA\Schema(
    schema: 'Favorite',
    type: 'object',
    required: ['user_id', 'project_id'],
    properties: [
        new OA\Property(
            property: 'user_id',
            type: 'integer',
            example: 1
        ),
        new OA\Property(
            property: 'project_id',
            type: 'integer',
            example: 1
        )
    ]
)]
#[OA\Schema(
    schema: 'ForecastDay',
    type: 'object',
    required: ['date', 'weather_code', 'description', 'icon', 'temp_max', 'temp_min', 'precipitation_probability'],
    properties: [
        new OA\Property(
            property: 'date',
            type: 'string',
            format: 'date',
            example: '2026-11-17'
        ),
        new OA\Property(
            property: 'weather_code',
            type: 'integer',
            nullable: true,
            example: 61
        ),
        new OA\Property(
            property: 'description',
            type: 'string',
            example: 'Light rain'
        ),
        new OA\Property(
            property: 'icon',
            type: 'string',
            example: 'cloud-rain'
        ),
        new OA\Property(
            property: 'temp_max',
            type: 'number',
            format: 'float',
            nullable: true,
            example: 17
        ),
        new OA\Property(
            property: 'temp_min',
            type: 'number',
            format: 'float',
            nullable: true,
            example: 4
        ),
        new OA\Property(
            property: 'precipitation_probability',
            type: 'integer',
            nullable: true,
            example: 10
        )
    ]
)]
#[OA\Schema(
    schema: 'Forecast',
    type: 'object',
    required: ['city', 'days'],
    properties: [
        new OA\Property(
            property: 'city',
            type: 'string',
            example: 'Sarajevo'
        ),
        new OA\Property(
            property: 'country',
            type: 'string',
            nullable: true,
            example: 'Bosnia and Herzegovina'
        ),
        new OA\Property(
            property: 'latitude',
            type: 'number',
            format: 'float',
            example: 43.84864
        ),
        new OA\Property(
            property: 'longitude',
            type: 'number',
            format: 'float',
            example: 18.35644
        ),
        new OA\Property(
            property: 'days',
            type: 'array',
            items: new OA\Items(
                ref: '#/components/schemas/ForecastDay'
            )
        )
    ]
)]
class OpenApiSpec
{
}
