<?php

use Phinx\Migration\AbstractMigration;

class CreateShopOrdersTable extends AbstractMigration
{
    public function change()
    {
        $this->table('shop_orders')
            ->addColumn('user_id', 'string')
            ->addColumn('total_price', 'float')
            ->addColumn('sub_total_price', 'float')
            ->addColumn('total_shipping_price', 'float')
            ->addColumn('on_way_id', 'string', ['null' => true])
            ->addColumn('status', 'string', ['null' => true])//like: error|not-payed|payed|shipped|closed
            ->addColumn('way', 'string')//way like: stripe|paypal|paysafecard
            ->addColumn("created_at", 'datetime', ['null' => true])
            ->addColumn("updated_at", 'datetime', ['null' => true])
            ->create();

        $this->table('shop_orders')
            ->changeColumn('id', 'string')
            ->update();

        //many to many
        $this->table('shop_orders_shop_items')
            ->addColumn('shop_item_id',"string")
            ->addColumn('shop_order_id', "string")
            ->addColumn('shop_item_custom_option_storage', 'integer', [
                'null' => true
            ])
            ->addColumn('shop_item_custom_option_color', 'string', [
                'null' => true
            ])
            ->create();
    }
}
