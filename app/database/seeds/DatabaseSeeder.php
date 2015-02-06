<?php

class DatabaseSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        
        Eloquent::unguard();

        //Se desactiva la restricción de claves ajenas para borrar tablas sin problemas
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        //Todos los nombres de las tablas
        $tableNames = DB::select('SELECT table_name AS name FROM information_schema.tables WHERE  table_schema = DATABASE()');
        
        //Se vacían los datos de todas las tablas (excepto la de migraciones)        
        foreach ($tableNames as $table) {            
            if($table->name !== 'migrations') {
                DB::table($table->name)->truncate();
            }
        }
        
        //Se vuelve a activar la restricción
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->call('AdminSeeder');
        $this->call('ClientSeeder');
        $this->call('UserSeeder');
        $this->call('AgerateSeeder');
        $this->call('CategorySeeder');
        $this->call('GameSeeder');
        $this->call('PlatformSeeder');
        $this->call('LanguageSeeder');
        $this->call('DeveloperSeeder');
        $this->call('PublisherSeeder');
        $this->call('ProductSeeder');
    }

}
