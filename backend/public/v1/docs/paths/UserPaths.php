<?php

use OpenApi\Attributes as OA;

class UserPaths
{
    #[OA\Get(path: '/users', tags: ['users'], responses: [new OA\Response(response: 200, description: 'Users', content: new OA\JsonContent(type: 'array', items: new OA\Items(ref: '#/components/schemas/User')))])]
    public function list() {}

    #[OA\Get(path: '/users/{id}', tags: ['users'], parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))], responses: [new OA\Response(response: 200, description: 'User', content: new OA\JsonContent(ref: '#/components/schemas/User')), new OA\Response(response: 404, description: 'Not found', content: new OA\JsonContent(ref: '#/components/schemas/Error'))])]
    public function get() {}

    #[OA\Post(path: '/users', tags: ['users'], requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/UserInput')), responses: [new OA\Response(response: 201, description: 'Created', content: new OA\JsonContent(ref: '#/components/schemas/User')), new OA\Response(response: 400, description: 'Invalid input', content: new OA\JsonContent(ref: '#/components/schemas/Error'))])]
    public function create() {}

    #[OA\Put(path: '/users/{id}', tags: ['users'], parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))], requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/UserInput')), responses: [new OA\Response(response: 200, description: 'Updated', content: new OA\JsonContent(ref: '#/components/schemas/User')), new OA\Response(response: 400, description: 'Invalid input', content: new OA\JsonContent(ref: '#/components/schemas/Error')), new OA\Response(response: 404, description: 'Not found', content: new OA\JsonContent(ref: '#/components/schemas/Error'))])]
    public function update() {}

    #[OA\Delete(path: '/users/{id}', tags: ['users'], parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))], responses: [new OA\Response(response: 200, description: 'Deleted', content: new OA\JsonContent(ref: '#/components/schemas/Message')), new OA\Response(response: 404, description: 'Not found', content: new OA\JsonContent(ref: '#/components/schemas/Error'))])]
    public function delete() {}
}
