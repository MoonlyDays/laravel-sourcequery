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
    /**
     * @throws InvalidPacketException
     * @throws SocketException
     * @throws AuthenticationException
     */
    public function __construct(
        private readonly xPawSourceQuery $query,
        private readonly string $password,

        private readonly string $ip,
        private readonly int $port,
        private readonly int $timeout,
        private readonly int $engine,
    )
    {
        $this->query->SetRconPassword($this->password);
    }

    /**
     * @throws InvalidPacketException
     * @throws SocketException
     * @throws AuthenticationException
     */
    public function send(string $command): string
    {
        return $this->query->Rcon($command);
    }

    public function query(string $command): PendingDispatch|PendingClosureDispatch
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