<?php

use OpenApi\Attributes as OA;

class ReviewPaths
{
    #[OA\Get(path: '/reviews', tags: ['reviews'], responses: [new OA\Response(response: 200, description: 'Reviews', content: new OA\JsonContent(type: 'array', items: new OA\Items(ref: '#/components/schemas/Review')))])]
    public function list() {}

    #[OA\Get(path: '/reviews/{id}', tags: ['reviews'], parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))], responses: [new OA\Response(response: 200, description: 'Review', content: new OA\JsonContent(ref: '#/components/schemas/Review')), new OA\Response(response: 404, description: 'Not found', content: new OA\JsonContent(ref: '#/components/schemas/Error'))])]
    public function get() {}

    #[OA\Post(path: '/reviews', tags: ['reviews'], requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/ReviewInput')), responses: [new OA\Response(response: 201, description: 'Created', content: new OA\JsonContent(ref: '#/components/schemas/Review')), new OA\Response(response: 400, description: 'Invalid input', content: new OA\JsonContent(ref: '#/components/schemas/Error'))])]
    public function create() {}

    #[OA\Put(path: '/reviews/{id}', tags: ['reviews'], parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))], requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/ReviewInput')), responses: [new OA\Response(response: 200, description: 'Updated', content: new OA\JsonContent(ref: '#/components/schemas/Review')), new OA\Response(response: 400, description: 'Invalid input', content: new OA\JsonContent(ref: '#/components/schemas/Error')), new OA\Response(response: 404, description: 'Not found', content: new OA\JsonContent(ref: '#/components/schemas/Error'))])]
    public function update() {}

    #[OA\Delete(path: '/reviews/{id}', tags: ['reviews'], parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))], responses: [new OA\Response(response: 200, description: 'Deleted', content: new OA\JsonContent(ref: '#/components/schemas/Message')), new OA\Response(response: 404, description: 'Not found', content: new OA\JsonContent(ref: '#/components/schemas/Error'))])]
    public function delete() {}
}
