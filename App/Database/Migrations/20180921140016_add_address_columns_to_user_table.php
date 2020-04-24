<?php

use Phinx\Migration\AbstractMigration;

class AddAddressColumnsToUserTable extends AbstractMigration
{
    public function change()
    {
        $this->table('users')
            ->addColumn('first_name', 'string', ['null' => true])
            ->addColumn('last_name', 'string', ['null' => true])
            ->addColumn('address_first_line', 'string', ['null' => true])
            ->addColumn('address_second_line', 'string', ['null' => true])
            ->addColumn('address_postal_code', 'string', ['null' => true])
            ->addColumn('address_city', 'string', ['null' => true])
            ->addColumn('address_country', 'string', ['null' => true])
            ->update();
    }
}
