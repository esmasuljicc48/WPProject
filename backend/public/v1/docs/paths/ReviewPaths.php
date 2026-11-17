<?php

use OpenApi\Attributes as OA;

class ReviewPaths
{
    #[OA\Get(path: '/reviews', summary: 'List reviews', tags: ['reviews'], responses: [new OA\Response(response: 200, description: 'Reviews', content: new OA\JsonContent(type: 'array', items: new OA\Items(ref: '#/components/schemas/Review')))])]
    public function get_all() {}

    #[OA\Get(path: '/reviews/{id}', summary: 'Get a review', tags: ['reviews'], parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, example: 1, schema: new OA\Schema(type: 'integer', minimum: 1))], responses: [new OA\Response(response: 200, description: 'Review', content: new OA\JsonContent(ref: '#/components/schemas/Review')), new OA\Response(response: 404, description: 'Not found', content: new OA\JsonContent(ref: '#/components/schemas/Error'))])]
    public function get_by_id() {}

    #[OA\Get(path: '/projects/{id}/reviews', summary: 'List reviews for a project', tags: ['projects', 'reviews'], parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, example: 1, schema: new OA\Schema(type: 'integer', minimum: 1))], responses: [new OA\Response(response: 200, description: 'Project reviews', content: new OA\JsonContent(type: 'array', items: new OA\Items(ref: '#/components/schemas/Review'))), new OA\Response(response: 404, description: 'Project not found', content: new OA\JsonContent(ref: '#/components/schemas/Error'))])]
    public function get_by_project() {}

    #[OA\Post(path: '/reviews', summary: 'Create a review', tags: ['reviews'], requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/ReviewInput', example: ['project_id' => 1, 'user_id' => 1, 'rating' => 5, 'notes' => 'A relaxing project.'])), responses: [new OA\Response(response: 201, description: 'Created', content: new OA\JsonContent(ref: '#/components/schemas/Review')), new OA\Response(response: 400, description: 'Invalid input', content: new OA\JsonContent(ref: '#/components/schemas/Error'))])]
    public function add() {}

    #[OA\Put(path: '/reviews/{id}', summary: 'Update a review', tags: ['reviews'], parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, example: 1, schema: new OA\Schema(type: 'integer', minimum: 1))], requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/ReviewInput', example: ['rating' => 4, 'notes' => 'Updated notes.'])), responses: [new OA\Response(response: 200, description: 'Updated', content: new OA\JsonContent(ref: '#/components/schemas/Review')), new OA\Response(response: 400, description: 'Invalid input', content: new OA\JsonContent(ref: '#/components/schemas/Error')), new OA\Response(response: 404, description: 'Not found', content: new OA\JsonContent(ref: '#/components/schemas/Error'))])]
    public function update() {}

    #[OA\Delete(path: '/reviews/{id}', summary: 'Delete a review', tags: ['reviews'], parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, example: 1, schema: new OA\Schema(type: 'integer', minimum: 1))], responses: [new OA\Response(response: 200, description: 'Deleted', content: new OA\JsonContent(ref: '#/components/schemas/Message')), new OA\Response(response: 404, description: 'Not found', content: new OA\JsonContent(ref: '#/components/schemas/Error'))])]
    public function delete() {}
}
