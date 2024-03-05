<?php

namespace App\Services;

use App\Models\Connection;
use phpseclib3\Crypt\PublicKeyLoader;
use phpseclib3\Net\SSH2;

class ShellService
{
    public const COMMAND_ALIASES = [
        'll' => 'ls -l'
    ];
    public const DISALLOWED_COMMANDS = [
        'rm'
    ];

    public SSH2 $ssh;
    protected string $output = '';
    protected string $displayName;

    public function __construct(string $connect)
    {
        $this->connect($connect);
//        $remote = env('DEFAULT_REMOTE');
//        $key =  env($remote . '_PRIVATE_KEY_PATH');
//        $key = PublicKeyLoader::load(file_get_contents($key));
//
//        $this->ssh = new SSH2(env($remote . '_SERVER_IP_ADDRESS'));
//        if (!$this->ssh->login(env($remote . '_USER_NAME'), $key)) {
//            throw new Exception('Login failed');
//        }
    }

    public static function getConnections(): array
    {
        return Connection::all()->pluck('id', 'name')->toArray();
    }

    public function connect(string $connectName): void
    {
        $connection = Connection::where('name', $connectName)->first();

        $key =  $connection->key_path;
        $key = PublicKeyLoader::load(file_get_contents($key));

        $this->ssh = new SSH2($connection->host);
        if (!$this->ssh->login($connection->user, $key)) {
            throw new Exception('Login failed');
        }

        $this->displayName = $connection->host . '@' . $connection->user;

    }
    public function execute(string $command): bool|string
    {
        $command = self::COMMAND_ALIASES[$command] ?? $command;

        if ($this->isDisallowed($command)) {
            return '"' . $command . '" contains a disallowed command.';
        }

        return $this->ssh->exec($command);
    }

    public function getConnection(string $connectName): string
    {
        return $this->displayName;
    }

    protected function isDisallowed(string $command): bool
    {
        $disallowed = false;

        collect(explode(' ', $command))
            ->each(function ($word) use (&$disallowed) {
                if (in_array($word, ShellService::DISALLOWED_COMMANDS)) {
                    $disallowed = true;
                }
            });

        return $disallowed;
    }
}

