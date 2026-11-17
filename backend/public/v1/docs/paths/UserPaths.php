<?php

use OpenApi\Attributes as OA;

/** Documents backend/routes/UserRoutes.php. */
class UserPaths
{
    #[OA\Get(
        path: '/users',
        summary: 'List users',
        tags: ['users'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Users',
                content: new OA\JsonContent(
                    type: 'array',
                    items: new OA\Items(
                        ref: '#/components/schemas/User'
                    )
                )
            )
        ]
    )]
    public function getUsers()
    {
    }

    #[OA\Get(
        path: '/users/{id}',
        summary: 'Get a user',
        tags: ['users'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                example: 1,
                schema: new OA\Schema(
                    type: 'integer',
                    minimum: 1
                )
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'User',
                content: new OA\JsonContent(
                    ref: '#/components/schemas/User'
                )
            ),
            new OA\Response(
                response: 404,
                description: 'Not found',
                content: new OA\JsonContent(
                    ref: '#/components/schemas/Error'
                )
            )
        ]
    )]
    public function getUsersById()
    {
    }

    #[OA\Get(
        path: '/users/{id}/projects',
        summary: 'List projects owned by a user',
        tags: ['users', 'projects'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                example: 1,
                schema: new OA\Schema(
                    type: 'integer',
                    minimum: 1
                )
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'User projects',
                content: new OA\JsonContent(
                    type: 'array',
                    items: new OA\Items(
                        ref: '#/components/schemas/ProjectFeedItem'
                    )
                )
            ),
            new OA\Response(
                response: 404,
                description: 'User not found',
                content: new OA\JsonContent(
                    ref: '#/components/schemas/Error'
                )
            )
        ]
    )]
    public function getUsersProjects()
    {
    }

    #[OA\Post(
        path: '/users',
        summary: 'Create a user',
        tags: ['users'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                ref: '#/components/schemas/UserInput',
                example: [
                    'first_name' => 'Ana',
                    'last_name' => 'Kovac',
                    'email' => 'ana@example.test',
                    'password' => 'Secret123'
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: 'Created',
                content: new OA\JsonContent(
                    ref: '#/components/schemas/User'
                )
            ),
            new OA\Response(
                response: 400,
                description: 'Invalid input',
                content: new OA\JsonContent(
                    ref: '#/components/schemas/Error'
                )
            )
        ]
    )]
    public function postUsers()
    {
    }

    #[OA\Put(
        path: '/users/{id}',
        summary: 'Update a user',
        tags: ['users'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                example: 1,
                schema: new OA\Schema(
                    type: 'integer',
                    minimum: 1
                )
            )
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                ref: '#/components/schemas/UserInput',
                example: [
                    'first_name' => 'Maya',
                    'last_name' => 'Parker',
                    'email' => 'maya@example.test',
                    'password' => ''
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'Updated',
                content: new OA\JsonContent(
                    ref: '#/components/schemas/User'
                )
            ),
            new OA\Response(
                response: 400,
                description: 'Invalid input',
                content: new OA\JsonContent(
                    ref: '#/components/schemas/Error'
                )
            ),
            new OA\Response(
                response: 404,
                description: 'Not found',
                content: new OA\JsonContent(
                    ref: '#/components/schemas/Error'
                )
            )
        ]
    )]
    public function putUsers()
    {
    }

    #[OA\Delete(
        path: '/users/{id}',
        summary: 'Delete a user',
        tags: ['users'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                example: 1,
                schema: new OA\Schema(
                    type: 'integer',
                    minimum: 1
                )
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Deleted',
                content: new OA\JsonContent(
                    ref: '#/components/schemas/Message'
                )
            ),
            new OA\Response(
                response: 404,
                description: 'Not found',
                content: new OA\JsonContent(
                    ref: '#/components/schemas/Error'
                )
            )
        ]
    )]
    public function deleteUsers()
    {
    }
}
