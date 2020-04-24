<?php

use Phinx\Migration\AbstractMigration;

class AddOrderColumnToShopCategoriesTable extends AbstractMigration
{
    public function change()
    {
        $this->table('shop_categories')
            ->addColumn('order', 'integer')
            ->update();
    }
}
