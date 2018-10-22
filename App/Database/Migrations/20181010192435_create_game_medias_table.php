<?php


use Phinx\Migration\AbstractMigration;

class CreateGameMediasTable extends AbstractMigration
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
        $this->table('game_medias')
            ->addColumn('url', 'string')
            ->addColumn('type', 'string')
            ->addColumn('is_main', 'boolean', ['default' => false])
            ->addColumn('platform_id', 'string', ['null' => true])
            ->addColumn('game_id', 'string', ['null' => true])
            ->addColumn('created_at', 'datetime', ['null' => true])
            ->addColumn('updated_at', 'datetime', ['null' => true])
            ->create();

        $this->table('game_medias')
            ->changeColumn('id', 'string')
            ->update();
    }
}
