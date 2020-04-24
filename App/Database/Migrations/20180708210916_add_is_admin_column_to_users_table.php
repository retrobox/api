<?php


use Phinx\Migration\AbstractMigration;

class AddIsAdminColumnToUsersTable extends AbstractMigration
{
    public function change()
    {
        $this->table('users')
            ->addColumn('is_admin', 'string', [
                'default' => false
            ])
            ->update();
    }
}
