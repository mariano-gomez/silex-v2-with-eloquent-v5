<?php

use Illuminate\Database\Seeder;
use App\Models\PhinxUser;
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

        $estudiantes_ids_array = range(1, 500);
        DB::statement('SET FOREIGN_KEY_CHECKS = 0'); # Para poder truncar las tablas
        PhinxUser::truncate();
        DB::table('users_phinx')->truncate();

        factory(PhinxUser::class, 50)->create();
    }
}
