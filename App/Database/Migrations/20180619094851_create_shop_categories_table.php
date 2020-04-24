<?php

use Phinx\Migration\AbstractMigration;

class CreateShopCategoriesTable extends AbstractMigration
{
	public function change()
	{
		$this->table('shop_categories')
			->addColumn('title', 'string')
			->addColumn("created_at", 'datetime', ['null' => true])
			->addColumn("updated_at", 'datetime', ['null' => true])
			->create();

		$this->table('shop_categories')
			->changeColumn('id', 'string')
			->update();
	}
}
