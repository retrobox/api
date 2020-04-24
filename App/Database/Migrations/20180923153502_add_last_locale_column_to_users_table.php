<?php

use Phinx\Migration\AbstractMigration;

class AddLastLocaleColumnToUsersTable extends AbstractMigration
{

    public function change()
    {
        $this->table('users')
            ->addColumn('last_locale', 'string', ['null' => true])
            ->update();
    }
}
