<?php

use Phinx\Migration\AbstractMigration;

class AddShippingIdToShopOrdersTable extends AbstractMigration
{
    public function change()
    {
        $this->table('shop_orders')
            ->addColumn('shipping_id', 'string', ['null' => true])
            ->update();
    }
}
