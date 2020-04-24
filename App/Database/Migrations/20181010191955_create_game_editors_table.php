<?php


use Phinx\Migration\AbstractMigration;

class CreateGameEditorsTable extends AbstractMigration
{
    public function change()
    {
        $this->table('game_editors')
            ->addColumn('name','string')
            ->addColumn('description', 'string', ['null' => true])
            ->addColumn('created_at', 'datetime', ['null' => true])
            ->addColumn('updated_at', 'datetime', ['null' => true])
            ->create();

        $this->table('game_editors')
            ->changeColumn('id', 'string')
            ->update();
    }
}
