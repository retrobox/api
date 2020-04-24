<?php

use Phinx\Migration\AbstractMigration;

class AddIdentifierColumnToShopItemTable extends AbstractMigration
{
    public function change()
    {
        $this->table('shop_items')
            ->addColumn('identifier', 'string', [
                'null' => true
            ])
            ->save();
    }
}
