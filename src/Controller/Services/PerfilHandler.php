<?php

namespace App\Controller\Services;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class PerfilHandler
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function fetchAvatar(String $username): String
    {
        $response = $this->client->request(
            'GET',
            "https://avatars.dicebear.com/api/pixel-art/" . $username . ".svg?size=200"
        );
        $avatarFile = fopen(dirname(__DIR__, 3) . "/assets/images/$username.svg", 'w');
        fwrite($avatarFile, $response->getContent());
        $relativePathToAvatar = "build/images/$username.svg";
        return $relativePathToAvatar;
    }
}
