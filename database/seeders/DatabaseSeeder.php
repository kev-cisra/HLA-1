<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleSeeder::class);
        //$this->call(AreasSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(DepartamentosSeeder::class);
        $this->call(PuestosSeeder::class);
        $this->call(JefesAreaSeeder::class);
        $this->call(AreasModulosSeeder::class);
        $this->call(PerfilesUsuariosSeeder::class);
        $this->call(MaquinasSeeder::class);
        $this->call(MarcasMaquinasSeeder::class);
        $this->call(ModulosSeeder::class);
        $this->call(MaterialSeeder::class);
    }
}
