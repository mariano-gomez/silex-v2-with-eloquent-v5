<?php

use Phpmig\Migration\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;

class CreateUser extends Migration
{
    /**
     * Do the migration
     */
    public function up()
    {
        $container = $this->getContainer();
        $eloquent = $container['db'];
        $builder = new Builder($eloquent->getConnection());
        $builder->create('users', function (Blueprint $table) {
            $table->string('id', 40)->primary();
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
        $container = $this->getContainer();
        $eloquent = $container['db'];
        $builder = new Builder($eloquent->getConnection());
        $builder->drop('users');
    }
}
