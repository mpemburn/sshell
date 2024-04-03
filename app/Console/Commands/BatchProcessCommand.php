<?php

namespace App\Console\Commands;

use App\Batches\HtaccessTestBatch;
use App\Factories\BatchFactory;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class BatchProcessCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:batch {--conn=} {--batch=} {--process=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $connection = $this->option('conn');
        $batchName = $this->option('batch');
        $process = $this->option('process');

        $batchFile = Storage::path('batches/' . $batchName . '.txt');

        $batch = BatchFactory::build($process);

        $batch->setConnection($connection)
            ->getBatchFile($batchFile)
            ->run();
    }
}
