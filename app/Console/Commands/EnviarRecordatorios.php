<?php

namespace App\Console\Commands;

use App\Mail\RecordatorioFecha;
use App\Mail\TallerNotificacion;
use App\Models\User;
use App\Models\Taller;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class EnviarRecordatorios extends Command
{
    protected $signature = 'recordatorio:enviar';
    protected $description = 'Enviar recordatorios de ITV y revisiones que expiran en 29 días';

    public function handle()
    {
        $usuarios = User::all();
        $hoy = Carbon::now();

        Log::info('Iniciando el envío de recordatorios.');

        foreach ($usuarios as $usuario) {
            Log::info('Verificando usuario: ' . $usuario->email);
            $this->verificarYEnviarCorreo($usuario, 'fechaITV', $hoy);
            $this->verificarYEnviarCorreo($usuario, 'fechaUltimaRevision', $hoy);
        }

        Log::info('Finalizado el envío de recordatorios.');
        return 0;
    }

    private function verificarYEnviarCorreo($usuario, $campoFecha, $hoy)
    {
        $fecha = Carbon::parse($usuario->$campoFecha);
        $diasRestantes = $hoy->diffInDays($fecha);

        Log::info("Verificando fecha $campoFecha para el usuario {$usuario->email}. Días restantes: $diasRestantes");

        if ($diasRestantes == 29) {
            $tipoRecordatorio = $campoFecha == 'fechaITV' ? 'ITV' : 'revisión';
            Mail::to($usuario->email)->send(new RecordatorioFecha($usuario, $tipoRecordatorio, $diasRestantes));
            Log::info('Correo enviado a: ' . $usuario->email . ' para ' . $campoFecha);

            // Enviar correos a los talleres de la misma ciudad
            $this->enviarCorreoATalleres($usuario, $tipoRecordatorio, $diasRestantes);
        } else {
            Log::info('No se envió correo para: ' . $usuario->email . ' - Días restantes: ' . $diasRestantes);
        }
    }

    private function enviarCorreoATalleres($usuario, $tipoRecordatorio, $diasRestantes)
    {
        //$talleres = Taller::where('ubicacionTaller', $usuario->residenciaUser)->get();

        // foreach ($talleres as $taller) {
        //     Mail::to($taller->correo_electronico)->send(new TallerNotificacion($usuario, $taller, $tipoRecordatorio, $diasRestantes));
        //     Log::info('Correo enviado al taller: ' . $taller->correo_electronico . ' sobre el usuario ' . $usuario->email);
        // }

          // Obtener los talleres a los que el usuario está suscrito
          $talleres = $usuario->subscriptoresTalleres;

          foreach ($talleres as $taller) {
            Mail::to($taller->correo_electronico)->send(new TallerNotificacion($usuario, $taller, $tipoRecordatorio, $diasRestantes));
            Log::info('Correo enviado al taller: ' . $taller->correo_electronico . ' sobre el usuario ' . $usuario->email);
        }
    }
}
