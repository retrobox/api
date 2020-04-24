<?php

use Phinx\Migration\AbstractMigration;

class AddLocaleColumnToShopsTable extends AbstractMigration
{
    public function change()
    {
        $this->table('shop_items')
            ->addColumn('locale', 'string')
            ->update();

        $this->table('shop_categories')
            ->addColumn('locale', 'string')
            ->update();
    }
}
