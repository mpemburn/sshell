<?php

namespace App\Batches;

class HtaccessBatch extends Batch
{
    protected array $commands = [
        'cd ~/{{ env }}/wp-content',
        'cp ./{{ item }} ./{{ item }}.bak',
        'rm ./{{ item }}',
        'echo Done!'

    ];
}
