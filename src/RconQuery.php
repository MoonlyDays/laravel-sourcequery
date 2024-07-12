<?php

namespace MoonlyDays\LaravelSourceQuery;

use Illuminate\Foundation\Bus\PendingClosureDispatch;
use Illuminate\Foundation\Bus\PendingDispatch;
use xPaw\SourceQuery\Exception\AuthenticationException;
use xPaw\SourceQuery\Exception\InvalidPacketException;
use xPaw\SourceQuery\Exception\SocketException;
use xPaw\SourceQuery\SourceQuery as xPawSourceQuery;

class RconQuery
{
    public function __construct(
        private readonly xPawSourceQuery $query,
        private readonly string $password,

        private readonly string $ip,
        private readonly int $port,
        private readonly int $timeout,
        private readonly int $engine,
    ) {}

    /**
     * @throws InvalidPacketException
     * @throws AuthenticationException
     * @throws SocketException
     */
    public function send(string $command): string
    {
        $this->query->SetRconPassword($this->password);

        return $this->query->Rcon($command);
    }

    public function queue(string $command): PendingDispatch|PendingClosureDispatch
    {
        return dispatch(new RconJob(
            $this->ip,
            $this->port,
            $this->password,
            $command,
            $this->timeout,
            $this->engine
        ));
    }
}
