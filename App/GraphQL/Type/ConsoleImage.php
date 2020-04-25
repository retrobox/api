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
                'size' => [
                    'type' => Type::int(),
                    'description' => 'The size of the zip file'
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