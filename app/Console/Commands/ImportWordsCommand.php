<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Services\WordService;
use Exception;

class ImportWordsCommand extends Command
{
    protected $signature = 'words:import';
    protected $description = 'Import words from the English dictionary JSON file';

    public function handle(WordService $wordService): void
    {
        $this->info('Starting word import process...');

        try {
            $response = Http::get('https://raw.githubusercontent.com/dwyl/english-words/master/words_dictionary.json');

            if (!$response->successful()) {
                throw new Exception('Failed to download the words dictionary file. Try again later.');
            }

            $words = $response->json();

            if (empty($words)) {
                throw new Exception('No words found in the dictionary file. Try again later.');
            }

            $this->info('Downloaded ' . count($words) . ' words. Starting import...');

            $chunks = array_chunk(array_keys($words), 1000);
            $totalChunks = count($chunks);

            $bar = $this->output->createProgressBar($totalChunks);
            $bar->start();

            $now = now();

            foreach ($chunks as $index => $chunk) {

                $wordService->createWords(array_map(function ($word) use ($words, $now) {
                    return [
                        'label' => $word,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                }, $chunk));

                $bar->advance();
            }

            $bar->finish();
            $this->newLine();
            $this->info('Word import completed successfully!');

        } catch (\Exception $e) {
            $this->error('Error during import: ' . $e->getMessage());
            Log::error('Word import failed: ' . $e->getMessage());
        }
    }
}
