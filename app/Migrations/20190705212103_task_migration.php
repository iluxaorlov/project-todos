<?php

use Phinx\Migration\AbstractMigration;

class TaskMigration extends AbstractMigration
{
    public function up()
    {
        $table = $this->table('task');
        $table
            ->addColumn('text', 'string')
            ->addColumn('status', 'boolean', ['default' => false])
            ->addColumn('session', 'string')
            ->create();
    }

    public function down()
    {
        $table = $this->table('task');
        $table->drop();
    }
}
