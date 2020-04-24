<?php

use Phinx\Migration\AbstractMigration;

class CreateUsersTable extends AbstractMigration
{
    public function change()
    {
        $this->table('users')
            ->addColumn("last_username", 'string', ['null' => true])
            ->addColumn("last_email", 'string', ['null' => true])
            ->addColumn("last_user_agent", 'string', ['null' => true])
            ->addColumn("last_login_at", 'datetime', ['null' => true])
            ->addColumn("created_at", 'datetime', ['null' => true])
            ->addColumn("updated_at", 'datetime', ['null' => true])
            ->create();

        $this->table('users')
            ->changeColumn('id', 'string')
            ->update();
    }
}
