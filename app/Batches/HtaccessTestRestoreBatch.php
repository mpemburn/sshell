<?php

namespace App\Batches;

class HtaccessTestRestoreBatch extends Batch
{
    protected array $commands = [
        'cd ~/sites/www.testing.clarku.edu/wp-content',
        'mv ./{{ item }}.bak ./{{ item }}',
//        'rm {{ item }}'
    ];
}
