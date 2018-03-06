<?php

use App\Migration\PhinxMigrationDriver;
use Illuminate\Database\Schema\Blueprint;

class MySecondPhinxMigration extends PhinxMigrationDriver
{

    /**
     * Do the migration
     */
    public function up()
    {
        $this->schema->create('users_phinx', function(Blueprint $table){
            // Auto-increment id
            $table->increments('id');
            $table->string('username', 32)->unique();
            $table->string('plain_password', 255);
            $table->string('password', 255);
            $table->string('roles', 255);

            $table->nullableTimestamps();
        });
    }

    /**
     * Undo the migration
     */
    public function down()
    {
    }
}
