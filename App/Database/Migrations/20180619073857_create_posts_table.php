<?php

use Phinx\Migration\AbstractMigration;

class CreatePostsTable extends AbstractMigration
{
    public function change()
    {
        $this->table('posts')
            ->addColumn('title', 'string')
            ->addColumn('slug', 'string')
            ->addColumn('description', 'text')
            ->addColumn('content', 'text')
            ->addColumn("created_at", 'datetime', ['null' => true])
            ->addColumn("updated_at", 'datetime', ['null' => true])
            ->create();

        $this->table('posts')
            ->changeColumn('id', 'string')
            ->update();
    }
}
