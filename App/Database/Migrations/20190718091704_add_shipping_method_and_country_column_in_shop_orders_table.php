<?php


use Phinx\Migration\AbstractMigration;

class AddShippingMethodAndCountryColumnInShopOrdersTable extends AbstractMigration
{
    public function change()
    {
        $this->table('shop_orders')
            ->addColumn('shipping_country', 'string')
            ->addColumn('shipping_method', 'string')
            ->update();
    }
}
