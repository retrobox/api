<?php


use Phinx\Migration\AbstractMigration;

class CreateShopPaymentsTable extends AbstractMigration
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
        $this->table('shop_payments')
            ->addColumn('user_id', 'string')
            ->addColumn('total', 'float')
            ->addColumn('on_way_id', 'string', ['null' => true])
            ->addColumn('status', 'string', ['null' => true])
            ->addColumn('way', 'string')//way like: stripe|paypal|paysafecard
            ->addColumn("created_at", 'datetime', ['null' => true])
            ->addColumn("updated_at", 'datetime', ['null' => true])
            ->create();

        $this->table('shop_payments')
            ->changeColumn('id', 'string')
            ->update();

        //many to many
        $this->table('shop_payments_shop_items')
            ->addColumn('shop_item_id',"string")
            ->addColumn('shop_payment_id', "string")
            ->create();
    }
}