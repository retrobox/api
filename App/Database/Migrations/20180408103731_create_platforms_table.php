<?php


use Phinx\Migration\AbstractMigration;

class CreatePlatformsTable extends AbstractMigration
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
		//has many medias
		//has many games
		$this->table('platforms')
			->addColumn('name', 'string')
			->addColumn('short', 'string', ['null' => true])
			->addColumn('description', 'text', ['null' => true])
			->addColumn('manufacturer', 'string', ['null' => true])
			->addColumn('cpu', 'string', ['null' => true])
			->addColumn('memory', 'string', ['null' => true])
			->addColumn('graphics', 'string', ['null' => true])
			->addColumn('sound', 'string', ['null' => true])
			->addColumn('display', 'string', ['null' => true])
			->addColumn('media', 'string', ['null' => true])
			->addColumn('max_controllers', 'string', ['null' => true])
			->addColumn('thegamesdb_rating', 'float', ['null' => true])
			->addColumn("created_at", 'datetime', ['null' => true])
			->addColumn("updated_at", 'datetime', ['null' => true])
			->create();

		$this->table('platforms')
			->changeColumn('id', 'string')
			->update();
    }
}
