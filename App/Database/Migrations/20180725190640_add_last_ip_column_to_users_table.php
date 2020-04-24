<?php


use Phinx\Migration\AbstractMigration;

class AddLastIpColumnToUsersTable extends AbstractMigration
{
    public function change()
    {
        $this->table('users')
            ->addColumn('last_ip','string', [
                'null' => true
            ])
            ->update();
    }
}
