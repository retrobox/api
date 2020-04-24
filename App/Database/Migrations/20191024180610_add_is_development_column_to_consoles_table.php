<?php

use Phinx\Migration\AbstractMigration;

class AddIsDevelopmentColumnToConsolesTable extends AbstractMigration
{
    public function change()
    {
        $this->table('consoles')
            ->addColumn('is_development', 'boolean', ['default' => false, 'null' => true])
            ->update();
    }
}
