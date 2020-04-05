<?php

use Phinx\Migration\AbstractMigration;

class AddAllowIndexingColumnToShopItemsTable extends AbstractMigration
{
    public function change()
    {
        $this->table('shop_items')
            ->addColumn('allow_indexing', 'boolean', [
                'default' => false
            ])
            ->update();
    }
}
