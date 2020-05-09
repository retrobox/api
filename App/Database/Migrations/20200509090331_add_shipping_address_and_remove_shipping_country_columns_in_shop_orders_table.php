<?php

use Phinx\Migration\AbstractMigration;

class AddShippingAddressAndRemoveShippingCountryColumnsInShopOrdersTable extends AbstractMigration
{
    public function change()
    {
        $this->table('shop_orders')
            ->removeColumn('shipping_country')
            // the address object in JSON of the user at the time of the purchase
            ->addColumn('shipping_address', 'text')
            ->update();
    }
}
