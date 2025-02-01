<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Services\ImportsService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Mockery;
use Tests\TestCase;

class ImportsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_pode_acessar_a_pagina_de_imports(): void
    {
        $response = $this->get(route('index'));

        $response->assertStatus(200);
        $response->assertViewIs('imports');
    }

    public function test_pode_acessar_a_pagina_de_processamento(): void
    {
        $response = $this->get(route('show'));

        $response->assertStatus(200);
        $response->assertViewIs('process');
    }

    public function test_pode_fazer_upload_do_arquivo_com_sucesso()
    {
        // Mock do ImportsService
        $serviceMock = Mockery::mock(ImportsService::class);
        $serviceMock->shouldReceive('uploadFile')
                    ->once()
                    ->andReturn(true);

        // Substitui o serviço original pelo mock
        $this->app->instance(ImportsService::class, $serviceMock);

        $file       = UploadedFile::fake()->create('test-file.json', 100);
        
        $response   = $this->post(route('upload'), ['file' => $file]);
        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
    }

    public function test_pode_fazer_upload_do_arquivo_quando_falha()
    {
        $serviceMock = Mockery::mock(ImportsService::class);
        $serviceMock->shouldReceive('uploadFile')
                    ->once()
                    ->andReturn(false);

        $this->app->instance(ImportsService::class, $serviceMock);

        $file       = UploadedFile::fake()->create('test-file.json', 100);

        $response   = $this->post(route('upload'), [
            'file' => $file,
        ]);

        // Verifica se a resposta é JSON e se o upload falhou
        $response->assertStatus(500);
        $response->assertJson(['success' => false]);
    }

    public function test_pode_iniciar_o_worker_com_o_comando_artisan()
    {
        // Verifica se o comando Artisan 'queue:start-worker' é chamado
        Artisan	::shouldReceive('call')
               ->once()
               ->with('queue:start-worker')
               ->andReturn(0); // Simula que o comando foi executado com sucesso

        $response = $this->post(route('process-queue'));

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);
    }

    public function test_pode_retornar_false_se_o_comando_falhar()
    {
        Artisan::shouldReceive('call')
               ->once()
               ->with('queue:start-worker')
               ->andReturn(1); // Simula que o comando falhou

        $response = $this->postJson(route('process-queue'));

        $response->assertStatus(200);
        $response->assertJson([
            'success' => false,
        ]);
    }

    public function test_pode_ler_os_logs_do_arquivo()
    {
        // Simula a existência de um arquivo de log com conteúdo
        $logContent = "Log do worker iniciado...\nJob processado com sucesso.";
        Storage::disk('logs')->put('imports.log', $logContent);

        // Faz uma requisição GET para a rota que chama o método 'logs'
        $response = $this->get(route('logs'));

        // Verifica se a resposta contém o conteúdo do log
        $response->assertStatus(200);
        $response->assertJsonFragment(['logs' => $logContent]);
    }

    public function test_pode_retornar_mensagem_se_o_log_nao_existir()
    {
        Storage::disk('logs')->delete('imports.log');

        $response = $this->get(route('logs'));

        $response->assertStatus(200);
        $response->assertJson(['logs' => 'Nenhum log encontrado.']);
    }
}
