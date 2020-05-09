<?php

use Phinx\Migration\AbstractMigration;

class ChangeWeightColumnInShopItemsTable extends AbstractMigration
{
    public function change()
    {
        $this->table('shop_items')
            // this field is a integer which represent the weight of the item in S.I grams
            ->changeColumn('weight', 'integer', ['null' => true])
            ->update();
    }
}
