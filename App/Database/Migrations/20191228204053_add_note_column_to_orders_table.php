<?php

use Phinx\Migration\AbstractMigration;

class AddNoteColumnToOrdersTable extends AbstractMigration
{
    public function change()
    {
        $this->table('shop_orders')
            ->addColumn('note', 'string', ['null' => true]) // this field contain the order note entered by customer at checkout
            ->update();
    }
}
