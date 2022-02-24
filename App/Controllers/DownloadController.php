<?php

namespace App\Controllers;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use Predis\Client as RedisClient;

class DownloadController
{
    public function __construct(
        private RedisClient $redis
    )
    {
    }

    public function getDownloads($_, ResponseInterface $response)
    {
        if ($this->redis->exists("desktop_last_release")) {
            $lastRelease = json_decode($this->redis->get("desktop_last_release"), true);
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
            $this->redis->set("desktop_last_release", json_encode($lastRelease));
        }
        return $response->withJson([
            'success' => true,
            'data' => $lastRelease
        ]);
    }
}
