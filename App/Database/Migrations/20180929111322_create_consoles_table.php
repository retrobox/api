<?php


use Phinx\Migration\AbstractMigration;

class CreateConsolesTable extends AbstractMigration
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
        $this->table('consoles')
            ->addColumn('token', 'string')
            ->addColumn('storage', 'string')
            ->addColumn('color', 'string')
            ->addColumn('user_id', 'string', ['null' => true])
            ->addColumn('order_id', 'string', ['null' => true])
            ->addColumn('first_boot_at', 'datetime', ['null' => true])
            ->addColumn('created_at', 'datetime')
            ->addColumn('updated_at', 'datetime')
            ->create();

        $this->table('consoles')
            ->changeColumn('id', 'string')
            ->update();
    }
}
