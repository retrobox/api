<?php

use Phinx\Migration\AbstractMigration;

class AddPathColumnToConsoleImagesTable extends AbstractMigration
{
    public function change()
    {
        $this->table('console_images')
            ->addColumn('path', 'string')
            ->update();
    }
}
