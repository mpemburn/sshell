<?php

namespace App\Batches;

class HtaccessTestBatch extends Batch
{
    protected array $commands = [
        'cd ~/sites/www.testing.clarku.edu/wp-content',
        'cp ./{{ item }} ./{{ item }}.bak',
        'rm ./{{ item }}'
    ];
}
