<?php

use Phinx\Migration\AbstractMigration;

class AddLastAvatarColumnToUsersTable extends AbstractMigration
{
    public function change()
    {
        $this->table('users')
            ->addColumn('last_avatar','string', [
                'null' => true
            ])
            ->update();
    }
}
