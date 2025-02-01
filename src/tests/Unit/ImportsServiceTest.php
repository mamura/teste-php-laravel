<?php
namespace Tests\Unit;

use App\Services\ImportsService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ImportsServiceTest extends TestCase
{
    use RefreshDatabase;
    
    public function pode_fazer_upload_do_arquivo_com_sucesso()
    {
        // Simula o arquivo sendo enviado
        $file = UploadedFile::fake()->create('example.json', 500); // Arquivo de 500 KB

        // Cria a instância do serviço
        $service = new ImportsService();

        // Chama o método uploadFile
        $result = $service->uploadFile($file);

        // Verifica se o arquivo foi armazenado com sucesso
        Storage::disk('uploads')->assertExists('imports/example.json');

        // Verifica se a resposta é verdadeira, indicando sucesso
        $this->assertTrue($result);
    }

    public function nao_pode_fazer_upload_de_arquivo_invalido()
    {
        // Simula um arquivo inválido (em branco ou sem conteúdo)
        $file = UploadedFile::fake()->create('example.json', 0); // Arquivo vazio

        // Cria a instância do serviço
        $service = new ImportsService();

        // Chama o método uploadFile
        $result = $service->uploadFile($file);

        // Verifica se o arquivo não foi armazenado
        Storage::disk('local')->assertMissing('imports/example.json');

        // Verifica se a resposta é falsa, indicando falha
        $this->assertFalse($result);
    }
}
