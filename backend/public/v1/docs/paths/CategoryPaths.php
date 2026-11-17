<?php

use OpenApi\Attributes as OA;

class CategoryPaths
{
    #[OA\Get(path: '/categories', tags: ['categories'], responses: [
        new OA\Response(response: 200, description: 'Categories', content: new OA\JsonContent(type: 'array', items: new OA\Items(ref: '#/components/schemas/Category')))
    ])]
    public function list() {}

    #[OA\Get(path: '/categories/{id}', tags: ['categories'], parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))], responses: [
        new OA\Response(response: 200, description: 'Category', content: new OA\JsonContent(ref: '#/components/schemas/Category')),
        new OA\Response(response: 404, description: 'Not found', content: new OA\JsonContent(ref: '#/components/schemas/Error'))
    ])]
    public function get() {}

    #[OA\Post(path: '/categories', tags: ['categories'], requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/CategoryInput')), responses: [
        new OA\Response(response: 201, description: 'Created', content: new OA\JsonContent(ref: '#/components/schemas/Category')),
        new OA\Response(response: 400, description: 'Invalid input', content: new OA\JsonContent(ref: '#/components/schemas/Error'))
    ])]
    public function create() {}

    #[OA\Put(path: '/categories/{id}', tags: ['categories'], parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))], requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/CategoryInput')), responses: [
        new OA\Response(response: 200, description: 'Updated', content: new OA\JsonContent(ref: '#/components/schemas/Category')),
        new OA\Response(response: 400, description: 'Invalid input', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
        new OA\Response(response: 404, description: 'Not found', content: new OA\JsonContent(ref: '#/components/schemas/Error'))
    ])]
    public function update() {}

    #[OA\Delete(path: '/categories/{id}', tags: ['categories'], parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))], responses: [
        new OA\Response(response: 200, description: 'Deleted', content: new OA\JsonContent(ref: '#/components/schemas/Message')),
        new OA\Response(response: 400, description: 'Cannot delete', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
        new OA\Response(response: 404, description: 'Not found', content: new OA\JsonContent(ref: '#/components/schemas/Error'))
    ])]
    public function delete() {}
}
