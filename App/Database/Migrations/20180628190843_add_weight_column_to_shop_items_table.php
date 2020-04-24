<?php


use Phinx\Migration\AbstractMigration;

class AddWeightColumnToShopItemsTable extends AbstractMigration
{
    public function change()
    {
        $this->table('shop_items')
            ->addColumn('weight', 'float', [
                'null' => true
            ])
            ->update();
    }
}
