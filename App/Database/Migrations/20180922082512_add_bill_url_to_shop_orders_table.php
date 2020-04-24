<?php


use Phinx\Migration\AbstractMigration;

class AddBillUrlToShopOrdersTable extends AbstractMigration
{
    public function change()
    {
        $this->table('shop_orders')
            ->addColumn('bill_url', 'string', [
                'null' => true
            ])
            ->update();
    }
}
