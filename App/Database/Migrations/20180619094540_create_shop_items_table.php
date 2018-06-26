<?php


use Phinx\Migration\AbstractMigration;

class CreateShopItemsTable extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
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
			->addColumn('shop_link_id', 'string', ['null' => true])
			->addColumn("created_at", 'datetime', ['null' => true])
			->addColumn("updated_at", 'datetime', ['null' => true])
			->create();

		$this->table('shop_items')
			->changeColumn('id', 'string')
			->update();
    }
}
