<?php

namespace App\Factories;

use App\Batches\HtaccessTestBatch;
use App\Batches\HtaccessTestRestoreBatch;
use App\Interfaces\BatchInterface;

class BatchFactory
{
    public static function build(string $process): BatchInterface
    {
        return match ($process) {
            'hta_test' => new HtaccessTestBatch(),
            'hta_test_restore' => new HtaccessTestRestoreBatch(),
        };
    }
}
