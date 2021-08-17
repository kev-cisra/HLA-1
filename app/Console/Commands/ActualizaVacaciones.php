<?php

namespace App\Console\Commands;

use App\Models\RecursosHumanos\Perfiles\PerfilesUsuarios;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ActualizaVacaciones extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:task';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tarea programada para actualizar los dias de vacaciones';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(){

        $texto = "[".date('Y-m-d: H:i:s')."]: Actualizacion de Dias de vacaciones";

        Storage::disk('local')->put('archivo.txt', $texto);
        // Storage::disk('local')->append('archivo.txt', $texto, null);
        // Storage::append("archivo.txt", $texto);
    }
}
