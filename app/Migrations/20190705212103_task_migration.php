<?php

use Phinx\Migration\AbstractMigration;

class TaskMigration extends AbstractMigration
{
    public function up()
    {
        $table = $this->table('task', ['id' => false, 'primary_key' => 'id']);
        $table
            ->addColumn('id', 'string')
            ->addColumn('text', 'string')
            ->addColumn('complete', 'boolean', ['default' => false])
            ->create();
    }

    public function down()
    {
        $table = $this->table('task');
        $table->drop();
    }
}
