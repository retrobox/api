<?php

use Phinx\Migration\AbstractMigration;

class CreateConsolesTable extends AbstractMigration
{
    public function change()
    {
        $this->table('consoles')
            ->addColumn('token', 'string')
            ->addColumn('storage', 'string')
            ->addColumn('color', 'string')
            ->addColumn('user_id', 'string', ['null' => true])
            ->addColumn('order_id', 'string', ['null' => true])
            ->addColumn('first_boot_at', 'datetime', ['null' => true])
            ->addColumn('created_at', 'datetime')
            ->addColumn('updated_at', 'datetime')
            ->create();

        $this->table('consoles')
            ->changeColumn('id', 'string')
            ->update();
    }
}
