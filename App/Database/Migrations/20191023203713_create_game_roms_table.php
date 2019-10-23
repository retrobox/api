<?php


use Phinx\Migration\AbstractMigration;

class CreateGameRomsTable extends AbstractMigration
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
