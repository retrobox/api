<?php


use Phinx\Migration\AbstractMigration;

class AddAddressColumnsToUserTable extends AbstractMigration
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
        $this->table('users')
            ->addColumn('first_name', 'string', ['null' => true])
            ->addColumn('last_name', 'string', ['null' => true])
            ->addColumn('address_first_line', 'string', ['null' => true])
            ->addColumn('address_second_line', 'string', ['null' => true])
            ->addColumn('address_postal_code', 'string', ['null' => true])
            ->addColumn('address_city', 'string', ['null' => true])
            ->addColumn('address_country', 'string', ['null' => true])
            ->update();
    }
}
