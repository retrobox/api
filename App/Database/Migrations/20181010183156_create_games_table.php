<?php

use Phinx\Migration\AbstractMigration;

class CreateGamesTable extends AbstractMigration
{
    public function change()
    {
        $this->table('games')
            ->addColumn('name', 'string')
            ->addColumn('esrb_level', 'string', ['null' => true])
            ->addColumn('locales', 'string', ['null' => true])
            ->addColumn('players', 'integer', ['null' => true])
            ->addColumn('thegamesdb_rating', 'float', ['null' => true])
            ->addColumn('igdb_rating', 'float', ['null' => true])
            ->addColumn('description', 'text')
            ->addColumn('rom_url', 'string', ['null' => true])
            ->addColumn('editor_id', 'string', ['null' => true])
            ->addColumn('platform_id', 'string', ['null' => true])
            ->addColumn('released_at', 'datetime', ['null' => true])
            ->addColumn('created_at', 'datetime', ['null' => true])
            ->addColumn('updated_at', 'datetime', ['null' => true])
            ->create();

        $this->table('games')
            ->changeColumn('id', 'string')
            ->update();
    }
}
