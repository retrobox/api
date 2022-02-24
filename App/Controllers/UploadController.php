<?php

namespace App\Controllers;

use App\Models\User;
use Faker\Provider\Uuid;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UploadedFileInterface;

class UploadController extends Controller
{
    public function postUpload(ServerRequestInterface $request, ResponseInterface $response)
    {
        // validate user permission, user must own at least one console
        $this->loadDatabase();
        /** @var $user User */
        $user = User::query()->find($this->session()->getUserId());
        if ($user === NULL) {
            return $response->withJson([
                'success' => false,
                'errors' => [
                    ['message' => 'Invalid user']
                ]
            ], 400);
        }
        if (empty($user->consoles()->get())) {
            return $response->withJson([
                'success' => false,
                'errors' => [
                    ['message' => "You can't upload a file because you don't have any console registered on your account"]
                ]
            ], 400);
        }
        // TODO: validate request input like 'console_id'

        $uploadedFiles = $request->getUploadedFiles();
        // validate that uploaded file count is only one
        if (count($uploadedFiles) !== 1 || !isset($uploadedFiles['file'])) {
            return $response->withJson([
                'success' => false,
                'errors' => [
                    ['message' => "You must upload at least one file or not more than one."]
                ]
            ], 400);
        }
        /** @var UploadedFileInterface $uploadedFile */
        $uploadedFile = $uploadedFiles['file'];

        // TODO: validate allowed extension

        $id = Uuid::uuid();
        $fileName = 'rom__' . $id . '__' . $uploadedFile->getClientFilename();
        $target = $this->container->get('upload_path') . '/' . $fileName;
        $uploadedFile->moveTo($target);
        // err must be equal to 0 if no errors
        if ($uploadedFile->getError() !== UPLOAD_ERR_OK) {
            return $response->withJson([
                'success' => false,
                'errors' => [
                    ['message' => 'Unsuccessful upload: invalid upload err code', 'code' => $uploadedFile->getError()]
                ]
            ], 400);
        }

        // TODO: store a game in db under owned_by: userId
        // TODO: send an event to the websocket server to install the rom on a targeted console
        return $response->withJson([
            'success' => true,
            'data' => [
                'err' => $uploadedFile->getError(),
                'file_name' => $fileName,
                'id' => $id,
                'url' => $this->container->get('services')['data_endpoint'] . $fileName
            ]
        ]);
    }
}
