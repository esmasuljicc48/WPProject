<?php

use OpenApi\Attributes as OA;

class ProjectPaths
{
    #[OA\Get(path: '/projects', summary: 'List projects', tags: ['projects'], parameters: [new OA\Parameter(name: 'privacy', in: 'query', required: false, example: 'public', schema: new OA\Schema(type: 'string', enum: ['public', 'private']))], responses: [new OA\Response(response: 200, description: 'Projects', content: new OA\JsonContent(type: 'array', items: new OA\Items(ref: '#/components/schemas/Project'))), new OA\Response(response: 400, description: 'Invalid privacy filter', content: new OA\JsonContent(ref: '#/components/schemas/Error'))])]
    public function get_feed() {}

    #[OA\Get(path: '/projects/{id}', summary: 'Get a project', tags: ['projects'], parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, example: 1, schema: new OA\Schema(type: 'integer', minimum: 1))], responses: [new OA\Response(response: 200, description: 'Project', content: new OA\JsonContent(ref: '#/components/schemas/Project')), new OA\Response(response: 404, description: 'Not found', content: new OA\JsonContent(ref: '#/components/schemas/Error'))])]
    public function get_by_id() {}

    #[OA\Post(path: '/projects', summary: 'Create a project', tags: ['projects'], requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/ProjectInput', example: ['user_id' => 1, 'category_id' => 1, 'title' => 'Harbor Mist Cardigan', 'description' => 'A relaxed cardigan in pale blue wool.', 'image_url' => 'https://example.test/cardigan.jpg', 'privacy' => 'public'])), responses: [new OA\Response(response: 201, description: 'Created', content: new OA\JsonContent(ref: '#/components/schemas/Project')), new OA\Response(response: 400, description: 'Invalid input', content: new OA\JsonContent(ref: '#/components/schemas/Error'))])]
    public function add() {}

    #[OA\Put(path: '/projects/{id}', summary: 'Update a project', tags: ['projects'], parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, example: 1, schema: new OA\Schema(type: 'integer', minimum: 1))], requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/ProjectInput', example: ['title' => 'Updated Cardigan', 'privacy' => 'private'])), responses: [new OA\Response(response: 200, description: 'Updated', content: new OA\JsonContent(ref: '#/components/schemas/Project')), new OA\Response(response: 400, description: 'Invalid input', content: new OA\JsonContent(ref: '#/components/schemas/Error')), new OA\Response(response: 404, description: 'Not found', content: new OA\JsonContent(ref: '#/components/schemas/Error'))])]
    public function update() {}

    #[OA\Delete(path: '/projects/{id}', summary: 'Delete a project', tags: ['projects'], parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, example: 1, schema: new OA\Schema(type: 'integer', minimum: 1))], responses: [new OA\Response(response: 200, description: 'Deleted', content: new OA\JsonContent(ref: '#/components/schemas/Message')), new OA\Response(response: 404, description: 'Not found', content: new OA\JsonContent(ref: '#/components/schemas/Error'))])]
    public function delete() {}
}
