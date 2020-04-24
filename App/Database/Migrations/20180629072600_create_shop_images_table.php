<?php

use Phinx\Migration\AbstractMigration;

class CreateShopImagesTable extends AbstractMigration
{
    public function change()
    {
        $this->table('shop_images')
            ->addColumn('url', 'string')
            ->addColumn('shop_item_id', 'string')
            ->addColumn('is_main', 'boolean', [
                'default' => false
            ])
            ->addColumn('name', 'string', [
                'null' => true
            ])
            ->addColumn("created_at", 'datetime', ['null' => true])
            ->addColumn("updated_at", 'datetime', ['null' => true])
            ->create();

        $this->table('shop_images')
            ->changeColumn('id', 'string')
            ->update();
    }
}
