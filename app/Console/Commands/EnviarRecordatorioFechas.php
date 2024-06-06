<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Carbon\Carbon;
use App\Mail\RecordatorioFecha;
use Illuminate\Support\Facades\Mail;
class EnviarRecordatorioFechas extends Command
{
    
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    // protected $signature = 'app:enviar-recordatorio-fechas';
    protected $signature = 'recordatorio:fechas';

    /**
     * The console command description.
     *
     * @var string
     */
    // protected $description = 'Command description';
    // protected $description = 'Enviar recordatorio de fechas importantes que expiran en 30 días';

    // public function __construct()
    // {
    //     parent::__construct();
    // }

        /**
     * Execute the console command.
     */
    // public function handle()
    // {
    //     $usuarios = User::all();
    //     $hoy = Carbon::now();

    //     foreach ($usuarios as $usuario) {
    //         $this->verificarYEnviarCorreo($usuario, 'fechaITV', $hoy);
    //         $this->verificarYEnviarCorreo($usuario, 'fechaUltimaRevision', $hoy);
    //         // Añadir más fechas aquí según sea necesario
    //     }

    //     return 0;
    // }

    // private function verificarYEnviarCorreo($usuario, $campoFecha, $hoy)
    // {
    //     $fecha = Carbon::parse($usuario->$campoFecha);

    //     if ($hoy->diffInDays($fecha) == 30) {
    //         Mail::to($usuario->email)->send(new RecordatorioFecha($usuario, ucfirst($campoFecha), $fecha));
    //         $this->info('Correo enviado a: ' . $usuario->email . ' para ' . $campoFecha);
    //     }
    // }



}
