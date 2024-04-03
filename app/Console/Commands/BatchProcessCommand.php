<?php

namespace App\Console\Commands;

use App\Batches\HtaccessBatch;
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
    protected $signature = 'app:batch {--conn=} {--env=} {--batch=} {--process=}';

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
        // conn must be the name of an existing connection
        $connection = $this->option('conn');
        // env is the directory path
        $env = $this->option('env');
        // batch is a text file with appropriate command strings
        $batchName = $this->option('batch');
        // process is the key string to access a Batch class
        $process = $this->option('process');

        $batchFile = Storage::path('batches/' . $batchName . '.txt');

        // Get an instance of the appropriate Batch class
        $batch = BatchFactory::build($process);

        $batch->setConnection($connection)
            ->setEnvironment($env)
            ->getBatchFile($batchFile)
            ->run();
    }
}
