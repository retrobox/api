<?php

namespace App\Controllers;

use GuzzleHttp\Client;
use Lefuturiste\LocalStorage\LocalStorage;
use Slim\Http\Response;

class DownloadController
{
    public function getDownloads(Response $response, LocalStorage $localStorage)
    {
        if ($localStorage->exist("desktop_last_release")) {
            $lastRelease = $localStorage->get("desktop_last_release");
        } else {
            $client = new Client();
            $ghApiResponse = $client->get("https://api.github.com/repos/retrobox/desktop/releases/latest");
            $lastRelease = json_decode($ghApiResponse->getBody()->getContents(), true);
            $versions = [];
            foreach ($lastRelease['assets'] as $release) {
                $versionName = '';
                $ext = preg_split("/[.]/", $release['name']);
                $ext = $ext[count($ext) - 1];
                switch ($ext) {
                    case 'dmg':
                        $versionName = 'mac';
                        break;
                    case 'exe':
                        $versionName = 'win';
                        break;
                    case 'AppImage':
                        $versionName = 'app_image';
                        break;
                }
                if ($versionName != '') {
                    $versions[$versionName] = [
                        'name' => $release['name'],
                        'size' => $release['size'],
                        'url' => $release['browser_download_url']
                    ];
                }
            }
            $lastRelease = [
                "id" => $lastRelease['id'],
                "version" => $lastRelease['tag_name'],
                "published_at" => $lastRelease['published_at'],
                "versions" => $versions
            ];
            $localStorage->set("desktop_last_release", $lastRelease);
            $localStorage->save();
        }
        return $response->withJson([
            'success' => true,
            'data' => $lastRelease
        ]);
    }
}
