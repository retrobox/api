<?php

use Phinx\Migration\AbstractMigration;

class CreateGameMediasTable extends AbstractMigration
{
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
