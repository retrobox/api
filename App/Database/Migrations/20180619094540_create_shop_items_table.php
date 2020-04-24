<?php

use Phinx\Migration\AbstractMigration;

class CreateShopItemsTable extends AbstractMigration
{
    public function change()
    {
		$this->table('shop_items')
			->addColumn('title', 'string')
			->addColumn('slug', 'string')
			// no markdown here
			->addColumn('description_short', 'string', ['null' => true])
			// markdown here
			->addColumn('description_long', 'text', ['null' => true])
			->addColumn('image', 'string', ['null' => true])
			->addColumn('price', 'float')
			->addColumn('version', 'string', ['null' => true])
			->addColumn('shop_category_id', 'string', ['null' => true])
			->addColumn("created_at", 'datetime', ['null' => true])
			->addColumn("updated_at", 'datetime', ['null' => true])
			->create();

		$this->table('shop_items')
			->changeColumn('id', 'string')
			->update();
    }
}
