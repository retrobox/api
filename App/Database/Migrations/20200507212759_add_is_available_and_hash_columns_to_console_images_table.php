<?php

use Phinx\Migration\AbstractMigration;

class AddIsAvailableAndHashColumnsToConsoleImagesTable extends AbstractMigration
{
    public function change()
    {
        $this->table('console_images')
            ->addColumn('is_available', 'boolean', ['default' => false])
            ->addColumn('hash', 'string', ['null' => false])
            ->update();
    }
}
