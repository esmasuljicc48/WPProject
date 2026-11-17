<?php

use OpenApi\Attributes as OA;

class CategoryPaths
{
    #[OA\Get(path: '/categories', summary: 'List categories', tags: ['categories'], responses: [
        new OA\Response(response: 200, description: 'Categories', content: new OA\JsonContent(type: 'array', items: new OA\Items(ref: '#/components/schemas/Category')))
    ])]
    public function get_all() {}

    #[OA\Get(path: '/categories/{id}', summary: 'Get a category', tags: ['categories'], parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, example: 1, schema: new OA\Schema(type: 'integer', minimum: 1))], responses: [
        new OA\Response(response: 200, description: 'Category', content: new OA\JsonContent(ref: '#/components/schemas/Category')),
        new OA\Response(response: 404, description: 'Not found', content: new OA\JsonContent(ref: '#/components/schemas/Error'))
    ])]
    public function get_by_id() {}

    #[OA\Post(path: '/categories', summary: 'Create a category', tags: ['categories'], requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/CategoryInput', example: ['name' => 'Weaving', 'description' => 'Handwoven textile projects.'])), responses: [
        new OA\Response(response: 201, description: 'Created', content: new OA\JsonContent(ref: '#/components/schemas/Category')),
        new OA\Response(response: 400, description: 'Invalid input', content: new OA\JsonContent(ref: '#/components/schemas/Error'))
    ])]
    public function add() {}

    #[OA\Put(path: '/categories/{id}', summary: 'Update a category', tags: ['categories'], parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, example: 1, schema: new OA\Schema(type: 'integer', minimum: 1))], requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/CategoryInput', example: ['name' => 'Knitting', 'description' => 'Needlework projects.'])), responses: [
        new OA\Response(response: 200, description: 'Updated', content: new OA\JsonContent(ref: '#/components/schemas/Category')),
        new OA\Response(response: 400, description: 'Invalid input', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
        new OA\Response(response: 404, description: 'Not found', content: new OA\JsonContent(ref: '#/components/schemas/Error'))
    ])]
    public function update() {}

    #[OA\Delete(path: '/categories/{id}', summary: 'Delete a category', tags: ['categories'], parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, example: 1, schema: new OA\Schema(type: 'integer', minimum: 1))], responses: [
        new OA\Response(response: 200, description: 'Deleted', content: new OA\JsonContent(ref: '#/components/schemas/Message')),
        new OA\Response(response: 400, description: 'Cannot delete', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
        new OA\Response(response: 404, description: 'Not found', content: new OA\JsonContent(ref: '#/components/schemas/Error'))
    ])]
    public function delete() {}
}
