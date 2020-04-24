<?php

use Phinx\Migration\AbstractMigration;

class AddOriginalFileNameColumnToGamesTable extends AbstractMigration
{
    public function change()
    {
        $this->table('games')
            ->addColumn('original_file_name','string', ['null' => true]) // this field will be filled if the game come from a user import (private game library)
            ->update();
    }
}
