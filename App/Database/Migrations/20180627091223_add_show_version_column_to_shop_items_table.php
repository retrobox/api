<?php

use Phinx\Migration\AbstractMigration;

class AddShowVersionColumnToShopItemsTable extends AbstractMigration
{
    public function change()
    {
        $this->table('shop_items')
            ->addColumn("show_version", "boolean", [
                'default' => false
            ])
            ->update();
    }
}
