<?php

namespace App\GraphQL\Type;

use App\GraphQL\Types;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class ConsoleImage extends ObjectType
{
    public function __construct()
    {
        $config = [
            'name' => 'ConsoleImage',
            'description' => "A SD-Card image specific version",
            'fields' => [
                'id' => [
                    'type' => Type::id()
                ],
                'console_version' => [
                    'type' => Type::string(),
                    'description' => 'The console hardware (or PCB) version'
                ],
                'software_version' => [
                    'type' => Type::string(),
                    'description' => 'A new software version represent for example a update in linux kernel or others new version of integrated software all packed up inside a single image release'
                ],
                'version' => [
                    'type' => Type::string(),
                    'description' => 'The full version string with the console and the software version'
                ],
                'description' => [
                    'type' => Type::string(),
                    'description' => 'Can serve as a changelog field for this version of the image'
                ],
                'path' => [
                    'type' => Type::string(),
                    'description' => 'The path at where the image is located on "https://os.retrobox.tech", begin with a slash and end with .img.zip'
                ],
                'url' => [
                    'type' => Type::string(),
                    'description' => 'Full download url'
                ],
                'size' => [
                    'type' => Type::int(),
                    'description' => 'The size of the zip file in megabytes'
                ],
                'hash' => [
                    'type' => Type::string(),
                    'description' => 'A SHA-256 hash or checksum of the zip file'
                ],
                'is_available' => [
                    'type' => Type::boolean(),
                    'description' => 'If the image is marked as available then the image can be used on the desktop app'
                ],
                'created_at' => [
                    'type' => Types::dateTime()
                ],
                'updated_at' => [
                    'type' => Types::dateTime()
                ]
            ]
        ];

        parent::__construct($config);
    }
}
