<?php


use Phinx\Migration\AbstractMigration;

class CreateGameRomsTable extends AbstractMigration
{
    public function change()
    {
        $this->table('game_roms')
            ->addColumn('game_id', 'string')
            ->addColumn('url', 'string')
            ->addColumn('size', 'integer', ['null' => true])
            ->addColumn('md5_hash', 'string', ['null' => true])
            ->addColumn('sha1_hash', 'string', ['null' => true])
            ->addColumn('sha256_hash', 'string', ['null' => true])
            ->addColumn('sha512_hash', 'string', ['null' => true])
            ->addColumn('crc_hash', 'string', ['null' => true])
            ->addColumn('last_checked_at', 'string', ['null' => true])
            ->addColumn('created_at', 'string', ['null' => true])
            ->addColumn('updated_at', 'string', ['null' => true])
            ->create();

        $this->table('game_roms')
            ->changeColumn('id', 'string')
            ->update();
    }
}
