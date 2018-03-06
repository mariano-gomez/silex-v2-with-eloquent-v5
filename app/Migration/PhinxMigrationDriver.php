<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Phinx\Migration\AbstractMigration;

class PhinxMigrationDriver extends AbstractMigration {
    /** @var \Illuminate\Database\Capsule\Manager $capsule */
    public $capsule;
    /** @var \Illuminate\Database\Schema\Builder $capsule */
    public $schema;

    public function init()  {
        $this->capsule = new Capsule;
        $this->capsule->addConnection([
            'driver'    => 'mysql',
            'host'      => '127.0.0.1',
            'port'      => '3306',
            'database'  => 'silex',
            'username'  => 'homestead',
            'password'  => 'secret',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
        ]);

        $this->capsule->bootEloquent();
        $this->capsule->setAsGlobal();
        $this->schema = $this->capsule->schema();
    }
}