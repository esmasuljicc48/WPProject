<?php

use OpenApi\Attributes as OA;

class FavoritePaths
{
    #[OA\Get(path: '/favorites', tags: ['favorites'], responses: [new OA\Response(response: 200, description: 'Favorites', content: new OA\JsonContent(type: 'array', items: new OA\Items(ref: '#/components/schemas/Favorite')))])]
    public function list() {}

    #[OA\Get(path: '/favorites/{user_id}/{project_id}', tags: ['favorites'], parameters: [new OA\Parameter(name: 'user_id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')), new OA\Parameter(name: 'project_id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))], responses: [new OA\Response(response: 200, description: 'Favorite', content: new OA\JsonContent(ref: '#/components/schemas/Favorite')), new OA\Response(response: 404, description: 'Not found', content: new OA\JsonContent(ref: '#/components/schemas/Error'))])]
    public function get() {}

    #[OA\Post(path: '/favorites', tags: ['favorites'], requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/Favorite')), responses: [new OA\Response(response: 201, description: 'Created', content: new OA\JsonContent(ref: '#/components/schemas/Favorite')), new OA\Response(response: 400, description: 'Invalid input', content: new OA\JsonContent(ref: '#/components/schemas/Error'))])]
    public function create() {}

    #[OA\Put(path: '/favorites/{user_id}/{project_id}', tags: ['favorites'], parameters: [new OA\Parameter(name: 'user_id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')), new OA\Parameter(name: 'project_id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))], responses: [new OA\Response(response: 400, description: 'Favorites are not editable', content: new OA\JsonContent(ref: '#/components/schemas/Error'))])]
    public function update() {}

    #[OA\Delete(path: '/favorites/{user_id}/{project_id}', tags: ['favorites'], parameters: [new OA\Parameter(name: 'user_id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')), new OA\Parameter(name: 'project_id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))], responses: [new OA\Response(response: 200, description: 'Deleted', content: new OA\JsonContent(ref: '#/components/schemas/Message')), new OA\Response(response: 404, description: 'Not found', content: new OA\JsonContent(ref: '#/components/schemas/Error'))])]
    public function delete() {}
}
