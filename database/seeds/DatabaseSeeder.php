<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $app = new Silex\Application();
        $app['debug'] = true;
        require __DIR__ . '/../../bootstrap/config.php';
        $app->boot();

        DB::statement('SET FOREIGN_KEY_CHECKS = 0'); # So i can truncate the tables
        User::truncate();
        DB::table('users')->truncate();

        factory(User::class, 5)
            ->create()
            ->each(function (User $user) use ($app) {
                $oldPassword = $user->password;
                $user->password = $app['security.default_encoder']->encodePassword($oldPassword, '');
                $user->save();
            })
        ;
    }
}
