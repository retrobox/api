<?php

use Phinx\Migration\AbstractMigration;

class CreateConsoleImagesTable extends AbstractMigration
{
    public function change()
    {
        $this->table('console_images')
            ->addColumn('console_version', 'string')
            ->addColumn('software_version', 'string')
            ->addColumn('version', 'string')
            ->addColumn('description', 'string', ['null' => true])
            ->addColumn('size', 'integer', ['null' => true])
            ->addColumn('created_at', 'string', ['null' => true])
            ->addColumn('updated_at', 'string', ['null' => true])
            ->create();

        $this->table('console_images')
            ->changeColumn('id', 'string')
            ->update();
    }
}
