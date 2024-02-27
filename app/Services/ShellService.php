<?php

namespace App\Services;

use phpseclib3\Crypt\PublicKeyLoader;
use phpseclib3\Net\SSH2;

class ShellService
{
    public SSH2 $ssh;

    public function __construct()
    {
        $remote = env('DEFAULT_REMOTE');
        $key =  env($remote . '_PRIVATE_KEY_PATH');
        $key = PublicKeyLoader::load(file_get_contents($key));

        $this->ssh = new SSH2(env($remote . '_SERVER_IP_ADDRESS'));
        if (!$this->ssh->login(env($remote . '_USER_NAME'), $key)) {
            throw new Exception('Login failed');
        }
    }

    public function execute(string $command): bool|string
    {
        return $this->ssh->exec($command);
    }

    public function getConnection(string $remote): string
    {
        return env($remote . '_SERVER_IP_ADDRESS') . '@' . env($remote . '_USER_NAME');
    }
}

