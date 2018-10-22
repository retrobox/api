<?php


use Phinx\Migration\AbstractMigration;

class CreateGameTagsTable extends AbstractMigration
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
        $this->table('game_tags')
            ->addColumn('name', 'string')
            ->addColumn('description', 'string', ['null' => true])
            ->addColumn('icon', 'string', ['null' => true])
            ->addColumn('created_at', 'string', ['null' => true])
            ->addColumn('updated_at', 'string', ['null' => true])
            ->create();

        $this->table('game_tags')
            ->changeColumn('id', 'string')
            ->update();

        $this->table('game_tags_games')
            ->addColumn('tag_id', 'string')
            ->addColumn('game_id', 'string')
            ->create();
    }
}
