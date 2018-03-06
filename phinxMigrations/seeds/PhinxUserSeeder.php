<?php

use Illuminate\Database\Capsule\Manager as Capsule;

use Phinx\Seed\AbstractSeed;
use App\Models\PhinxUser;
use Illuminate\Container\Container;

class PhinxUserSeeder extends AbstractSeed
{

    /** @var \Illuminate\Database\Capsule\Manager $capsule */
    public $capsule;
    /** @var \Illuminate\Database\Schema\Builder $capsule */
    public $schema;

    //  Seteo la capsula, no me acuerdo porque "deduje" que iba a necesitar esto
    public function init()
    {
        $this->app = new Silex\Application();
        $this->app['debug'] = true;

        $capsule = new Capsule;
        $capsule->addConnection([
            'driver'    => 'mysql',
            'host'      => '127.0.0.1',
            'database'  => 'silex',
            'username'  => 'homestead',
            'password'  => 'secret',
            'charset'   => 'utf8',
            'collation' => 'utf8_general_ci',
        ]);

        //These two have to be outside closure
        // Make the Capsule instance available globally via static methods...
        $capsule->setAsGlobal();
        // Setup the Eloquent ORM...
        $capsule->bootEloquent();

        $this->app['db'] = $capsule;

        $this->registerConnectionServices();
    }

    //  Intentando tener los mismos servicios vinculados a la DB que ofrece eloquent, copio este metodo de
    //  DatabaseServiceProvider.php, pero lo adapto para usarlo con la "sintaxis" de silex
    private function registerConnectionServices() {
        // The connection factory is used to create the actual connection instances on
        // the database. We will inject the factory into the manager so that it may
        // make the connections while they are actually needed and not of before.
        $this->app['db.factory'] = new \Illuminate\Database\Connectors\ConnectionFactory($this->app);

        // The database manager is used to resolve various connections, since multiple
        // connections might be managed. It also implements the connection resolver
        // interface which may be used by other components requiring connections.
//        $this->app->singleton('db', function ($app) {
//            return new DatabaseManager($app, $app['db.factory']);
//        });

        $this->app['db.connection'] = $this->app['db']->connection();
    }

    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {

        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS = 0'); # Para poder truncar las tablas
        PhinxUser::truncate();
die;
        $phinxUsersTable = $this->table('users_phinx');
        $phinxUsersTable->truncate();

        $faker = Faker\Factory::create();
        $data = [];
        for ($i = 1; $i <= 100; $i++) {
            $data[] = [
                'id'                => $i,
                'username'          => $faker->userName,
                'password'          => sha1($faker->password),
                'plain_password'    => sha1('foo'),
                'roles'             => 'ROLE_USER',
            ];
        }
        $this->insert('users_phinx', $data);


//        $this->factory(PhinxUser::class, 50)->create();
//        die;
    }

    public function factory() {

        \Illuminate\Database\Eloquent\Model::setConnectionResolver($this->app['db']);
        try {
            $factory = \Illuminate\Container\Container::getInstance()->make('Illuminate\Database\Eloquent\Factory');

            $faker = Faker\Factory::create();

//            $e = new Exception();
//        print_r(str_replace('/home/lumen.udemy/', '', $e->getTraceAsString()));

            $factory->define(App\Models\PhinxUser::class, function (Faker\Generator $faker) {
                $faker = Faker\Factory::create();
                return [
                    'password'          => sha1($faker->password),
                    'username'          => $faker->userName,
                    'plain_password'    => sha1('foo'),
                    'roles'             => 'ROLE_USER',
                ];
            });

            $arguments = func_get_args();

            if (isset($arguments[1]) && is_string($arguments[1])) {
                return $factory->of($arguments[0], $arguments[1])->times(isset($arguments[2]) ? $arguments[2] : null);
            } elseif (isset($arguments[1])) {
                $response = $factory->of($arguments[0])->times($arguments[1]);
                $e = new Exception();
                print_r(str_replace('/home/silex/', '', $e->getTraceAsString()));
                return $response;
//            return $factory->of($arguments[0])->times($arguments[1]);
            } else {
                return $factory->of($arguments[0]);
            }
        } catch (Exception $e) {
            print_r(str_replace('/home/silex/', '', $e->getTraceAsString()));
        }
    }

}
