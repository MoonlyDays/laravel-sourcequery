<?php

namespace MoonlyDays\LaravelSourceQuery;

use xPaw\SourceQuery\Exception\AuthenticationException;
use xPaw\SourceQuery\Exception\InvalidArgumentException;
use xPaw\SourceQuery\Exception\InvalidPacketException;
use xPaw\SourceQuery\Exception\SocketException;
use xPaw\SourceQuery\SourceQuery as xPawSourceQuery;

class Query
{
    private xPawSourceQuery $query;

    /**
     * @throws SocketException
     * @throws InvalidArgumentException
     */
    public function __construct(
        private readonly string $ip,
        private readonly int $port,
        private readonly int $timeout,
        private readonly int $engine
    )
    {
        $this->query = new xPawSourceQuery();
        $this->query->Connect($this->ip, $this->port, $this->timeout, $this->engine);
    }

    /**
     * @throws SocketException
     * @throws InvalidPacketException
     * @throws AuthenticationException
     */
    public function rconPassword(string $password): static
    {
        $this->query->SetRconPassword($password);

        return $this;
    }

    /**
     * @throws InvalidPacketException
     * @throws SocketException
     */
    public function rules(): array
    {
        return $this->query->GetRules();
    }

    /**
     * @throws SocketException
     * @throws InvalidPacketException
     */
    public function info(): array
    {
        return $this->query->GetInfo();
    }

    /**
     * @throws InvalidPacketException
     * @throws AuthenticationException
     * @throws SocketException
     */
    public function rcon(string $command, string $rconPassword = null): string
    {
        if (isset($rconPassword)) {
            $this->rconPassword($rconPassword);
        }

        return $this->query->Rcon($command);
    }
}