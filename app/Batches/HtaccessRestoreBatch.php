<?php

namespace App\Batches;

class HtaccessRestoreBatch extends Batch
{
    protected array $commands = [
        'cd ~/{{ env }}/wp-content',
        'mv ./{{ item }}.bak ./{{ item }}',
        'echo Done!'
    ];
}
