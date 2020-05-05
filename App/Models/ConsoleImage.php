<?php

namespace App\Models;

class ConsoleImage extends Model
{
    protected $table = 'console_images';

    protected $keyType = 'string';

    public $incrementing = false;

    public function generateExtraFields(): void
    {
        $this['version'] = 'h' . $this['console_version'] . '-s' . $this['software_version'];
        $this['path'] = '/' . $this['version'] . '.img.zip';
    }
}