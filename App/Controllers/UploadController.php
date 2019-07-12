<?php

namespace App\Controllers;

use App\Auth\Session;
use App\Models\User;
use Faker\Provider\Uuid;
use Psr\Http\Message\UploadedFileInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class UploadController extends Controller
{
    public function postUpload(Request $request, Response $response, Session $session)
    {
        // validate user permission, user must own at least one console
        $this->loadDatabase();
        $user = User::query()->find($session->getUserId())->first();
        if ($user === NULL) {
            return $response->withJson([
                'success' => false,
                'error' => [
                    'message' => 'Invalid user',
                    'code' => 400
                ]
            ], 400);
        }
        if (empty($user->consoles()->get())) {
            return $response->withJson([
                'success' => false,
                'error' => [
                    'message' => "You can't upload a file because you don't have any console registered on your account",
                    'code' => 400
                ]
            ], 400);
        }
        $uploadedFiles = $request->getUploadedFiles();
        // validate that uploaded file count is only one
        if (count($uploadedFiles) !== 1 || !isset($uploadedFiles['file'])) {
            return $response->withJson([
                'success' => false,
                'error' => [
                    'message' => 'You must upload at least one file or not more than one.',
                    'code' => 400
                ]
            ], 400);
        }
        /** @var UploadedFileInterface $uploadedFile */
        $uploadedFile = $uploadedFiles['file'];
        $id = Uuid::uuid();
        $fileName = 'rom__' . $id . '__' . $uploadedFile->getClientFilename();
        $target = $this->container->get('upload_path') . '/' . $fileName;
        $uploadedFile->moveTo($target);
        // err must be equal to 0 if no errors
        if ($uploadedFile->getError() !== UPLOAD_ERR_OK) {
            return $response->withJson([
                'success' => false,
                'errors' => [
                    'message' => 'Unsuccessful upload: invalid upload err code',
                    'code' => $uploadedFile->getError()
                ]
            ], 400);
        }
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
