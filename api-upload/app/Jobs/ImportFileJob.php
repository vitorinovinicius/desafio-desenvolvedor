<?php

namespace App\Jobs;

use App\Imports\ImportInstrument;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ImportFileJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $upload;
    protected string $path;

    public function __construct($upload, string $path)
    {
        $this->upload = $upload;
        $this->path = $path;
    }

    public function handle() :void
    {
        // Garante que o diretório de cache usado pelo Laravel Excel existe
        $excelCachePath = storage_path('framework/cache/laravel-excel');

        if (!File::exists($excelCachePath)) {
            File::makeDirectory($excelCachePath, 0755, true); // cria recursivamente
        }

        try {
            $dir = Storage::disk('local')->path($this->path);

            if (!File::exists($dir)) {
                geraActivityLog(
                    'import_file',
                    'Arquivo não encontrado',
                    ['file_path' => $this->path],
                    $this->upload->id,
                    get_class($this->upload)
                );

                throw new \Exception("Arquivo não encontrado: {$this->path}");
            }

            Excel::import(new ImportInstrument, $dir);
            geraActivityLog(
                'import_file',
                'Importação finalizada com sucesso',
                ['file_path' => $this->path],
                $this->upload->id,
                get_class($this->upload)
            );

            $this->upload->update([
                'status' => 'Finished'
            ]);
        } catch (\Throwable $e) {
            geraActivityLog(
                'import_file',
                'Erro ao importar arquivo',
                [
                    'file_path' => $this->path,
                    'error' => $e->getMessage(),
                ],
                $this->upload->id,
                get_class($this->upload)
            );
            throw $e;
        }
    }
}
