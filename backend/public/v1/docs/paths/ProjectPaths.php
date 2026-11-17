<?php

use OpenApi\Attributes as OA;

class ProjectPaths
{
    #[OA\Get(path: '/projects', tags: ['projects'], responses: [new OA\Response(response: 200, description: 'Projects', content: new OA\JsonContent(type: 'array', items: new OA\Items(ref: '#/components/schemas/Project')))])]
    public function list() {}

    #[OA\Get(path: '/projects/public', tags: ['projects'], responses: [new OA\Response(response: 200, description: 'Public projects', content: new OA\JsonContent(type: 'array', items: new OA\Items(ref: '#/components/schemas/Project')))])]
    public function publicFeed() {}

    #[OA\Get(path: '/projects/user/{user_id}', tags: ['projects'], parameters: [new OA\Parameter(name: 'user_id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))], responses: [new OA\Response(response: 200, description: 'User projects', content: new OA\JsonContent(type: 'array', items: new OA\Items(ref: '#/components/schemas/Project'))), new OA\Response(response: 404, description: 'User not found', content: new OA\JsonContent(ref: '#/components/schemas/Error'))])]
    public function byUser() {}

    #[OA\Get(path: '/projects/{id}', tags: ['projects'], parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))], responses: [new OA\Response(response: 200, description: 'Project', content: new OA\JsonContent(ref: '#/components/schemas/Project')), new OA\Response(response: 404, description: 'Not found', content: new OA\JsonContent(ref: '#/components/schemas/Error'))])]
    public function get() {}

    #[OA\Post(path: '/projects', tags: ['projects'], requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/ProjectInput')), responses: [new OA\Response(response: 201, description: 'Created', content: new OA\JsonContent(ref: '#/components/schemas/Project')), new OA\Response(response: 400, description: 'Invalid input', content: new OA\JsonContent(ref: '#/components/schemas/Error'))])]
    public function create() {}

    #[OA\Put(path: '/projects/{id}', tags: ['projects'], parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))], requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/ProjectInput')), responses: [new OA\Response(response: 200, description: 'Updated', content: new OA\JsonContent(ref: '#/components/schemas/Project')), new OA\Response(response: 400, description: 'Invalid input', content: new OA\JsonContent(ref: '#/components/schemas/Error')), new OA\Response(response: 404, description: 'Not found', content: new OA\JsonContent(ref: '#/components/schemas/Error'))])]
    public function update() {}

    #[OA\Delete(path: '/projects/{id}', tags: ['projects'], parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))], responses: [new OA\Response(response: 200, description: 'Deleted', content: new OA\JsonContent(ref: '#/components/schemas/Message')), new OA\Response(response: 404, description: 'Not found', content: new OA\JsonContent(ref: '#/components/schemas/Error'))])]
    public function delete() {}
}
