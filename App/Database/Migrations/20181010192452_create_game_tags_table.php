<?php


use Phinx\Migration\AbstractMigration;

class CreateGameTagsTable extends AbstractMigration
{
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
