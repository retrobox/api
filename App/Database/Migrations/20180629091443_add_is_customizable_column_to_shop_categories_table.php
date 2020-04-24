<?php

use Phinx\Migration\AbstractMigration;

class AddIsCustomizableColumnToShopCategoriesTable extends AbstractMigration
{
    public function change()
    {
        $this->table('shop_categories')
            ->addColumn('is_customizable', "boolean", [
                'default' => false
            ])
            ->update();
    }
}
