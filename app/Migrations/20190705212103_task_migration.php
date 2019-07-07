<?php

use Phinx\Migration\AbstractMigration;

class TaskMigration extends AbstractMigration
{
    public function up()
    {
        $table = $this->table('task');
        $table
            ->addColumn('text', 'string')
            ->addColumn('complete', 'boolean', ['default' => false])
            ->addColumn('date', 'datetime', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('token', 'string')
            ->create();
    }

    public function down()
    {
        $table = $this->table('task');
        $table->drop();
    }
}
