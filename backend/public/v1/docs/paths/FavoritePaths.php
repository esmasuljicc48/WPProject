<?php

use OpenApi\Attributes as OA;

class FavoritePaths
{
    #[OA\Get(path: '/favorites', summary: 'List favorites', tags: ['favorites'], responses: [new OA\Response(response: 200, description: 'Favorites', content: new OA\JsonContent(type: 'array', items: new OA\Items(ref: '#/components/schemas/Favorite')))])]
    public function get_all() {}

    #[OA\Get(path: '/favorites/{user_id}/{project_id}', summary: 'Get a favorite', tags: ['favorites'], parameters: [new OA\Parameter(name: 'user_id', in: 'path', required: true, example: 1, schema: new OA\Schema(type: 'integer', minimum: 1)), new OA\Parameter(name: 'project_id', in: 'path', required: true, example: 1, schema: new OA\Schema(type: 'integer', minimum: 1))], responses: [new OA\Response(response: 200, description: 'Favorite', content: new OA\JsonContent(ref: '#/components/schemas/Favorite')), new OA\Response(response: 404, description: 'Not found', content: new OA\JsonContent(ref: '#/components/schemas/Error'))])]
    public function get_by_id() {}

    #[OA\Get(path: '/users/{id}/favorites', summary: 'List favorites saved by a user', tags: ['users', 'favorites'], parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, example: 1, schema: new OA\Schema(type: 'integer', minimum: 1))], responses: [new OA\Response(response: 200, description: 'User favorites', content: new OA\JsonContent(type: 'array', items: new OA\Items(ref: '#/components/schemas/Project'))), new OA\Response(response: 404, description: 'User not found', content: new OA\JsonContent(ref: '#/components/schemas/Error'))])]
    public function get_by_user() {}

    #[OA\Post(path: '/favorites', summary: 'Create a favorite', tags: ['favorites'], requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/Favorite', example: ['user_id' => 1, 'project_id' => 1])), responses: [new OA\Response(response: 201, description: 'Created', content: new OA\JsonContent(ref: '#/components/schemas/Favorite')), new OA\Response(response: 400, description: 'Invalid input', content: new OA\JsonContent(ref: '#/components/schemas/Error'))])]
    public function add() {}

    #[OA\Put(path: '/favorites/{user_id}/{project_id}', summary: 'Reject favorite updates', tags: ['favorites'], parameters: [new OA\Parameter(name: 'user_id', in: 'path', required: true, example: 1, schema: new OA\Schema(type: 'integer', minimum: 1)), new OA\Parameter(name: 'project_id', in: 'path', required: true, example: 1, schema: new OA\Schema(type: 'integer', minimum: 1))], responses: [new OA\Response(response: 400, description: 'Favorites are not editable', content: new OA\JsonContent(ref: '#/components/schemas/Error'))])]
    public function update() {}

    #[OA\Delete(path: '/favorites/{user_id}/{project_id}', summary: 'Delete a favorite', tags: ['favorites'], parameters: [new OA\Parameter(name: 'user_id', in: 'path', required: true, example: 1, schema: new OA\Schema(type: 'integer', minimum: 1)), new OA\Parameter(name: 'project_id', in: 'path', required: true, example: 1, schema: new OA\Schema(type: 'integer', minimum: 1))], responses: [new OA\Response(response: 200, description: 'Deleted', content: new OA\JsonContent(ref: '#/components/schemas/Message')), new OA\Response(response: 404, description: 'Not found', content: new OA\JsonContent(ref: '#/components/schemas/Error'))])]
    public function delete() {}
}
