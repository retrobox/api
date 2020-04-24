<?php

use Phinx\Migration\AbstractMigration;

class AddVersionColumnToConsolesTable extends AbstractMigration
{
    public function change()
    {
        $this->table('consoles')
            ->addColumn('version', 'string', ['null' => true])
            ->update();
    }
}
