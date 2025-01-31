<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class StartQueueWorker extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:start-queue-worker';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Inicia o worker da fila de jobs em segundo plano';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $logFile = storage_path('logs/imports.log');

        $this->info('Iniciando o worker da fila...');

        // Rodando o worker em segundo plano
        $process = proc_open(
            'php ' . base_path('artisan') . ' queue:work --daemon >> ' . $logFile . ' 2>&1 &',
            [
                1 => ['pipe', 'w'], // Saída do processo
                2 => ['pipe', 'w'], // Erro do processo
            ],
            $pipes
        );

        if (is_resource($process)) {
            $this->info('Worker da fila iniciado!');
        } else {
            $this->error('Não foi possível iniciar o worker da fila.');
        }
    }
}
