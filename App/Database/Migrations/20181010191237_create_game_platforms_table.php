<?php


use Phinx\Migration\AbstractMigration;

class CreateGamePlatformsTable extends AbstractMigration
{
    public function change()
    {
        $this->table('game_platforms')
            ->addColumn('name', 'string')
            ->addColumn('short', 'string', ['null' => true])
            ->addColumn('description', 'text')
            ->addColumn('manufacturer', 'string', ['null' => true])
            ->addColumn('cpu', 'string', ['null' => true])
            ->addColumn('memory', 'string', ['null' => true])
            ->addColumn('graphics', 'string', ['null' => true])
            ->addColumn('sound', 'string', ['null' => true])
            ->addColumn('display', 'string', ['null' => true])
            ->addColumn('media', 'string', ['null' => true])
            ->addColumn('max_controllers', 'integer', ['null' => true])
            ->addColumn('thegamesdb_rating', 'float', ['null' => true])
            ->addColumn('released_at', 'datetime', ['null' => true])
            ->addColumn('created_at', 'datetime', ['null' => true])
            ->addColumn('updated_at', 'datetime', ['null' => true])
            ->create();

        $this->table('game_platforms')
            ->changeColumn('id', 'string')
            ->update();
    }
}
