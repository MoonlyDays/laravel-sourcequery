<?php

namespace MoonlyDays\LaravelSourceQuery;

use Illuminate\Support\Collection;
use MoonlyDays\LaravelSourceQuery\Responses\Info;
use MoonlyDays\LaravelSourceQuery\Responses\Player;
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
     * Sets the RCON password to use in this server query.
     * @throws SocketException
     * @throws InvalidPacketException
     * @throws AuthenticationException
     */
    public function withPassword(string $password): static
    {
        $this->query->SetRconPassword($password);

        return $this;
    }

    /**
     * Returns the rules (console variables) of the target server.
     * @throws InvalidPacketException
     * @throws SocketException
     */
    public function rules(): array
    {
        return $this->query->GetRules();
    }

    /**
     * Returns the information about the target server.
     * @throws SocketException
     * @throws InvalidPacketException
     */
    public function info(): Info
    {
        return new Info($this->query->GetInfo());
    }

    /**
     * Returns the data about the players currently on the server.
     * @return Collection<Player>
     * @throws SocketException
     * @throws InvalidPacketException
     */
    public function players(): Collection
    {
        return collect($this->query->GetPlayers());
    }

    /**
     * Send a RCON command to the target server.
     * @throws InvalidPacketException
     * @throws AuthenticationException
     * @throws SocketException
     */
    public function rcon(string $command, string $password = null): string
    {
        if (isset($password)) {
            $this->withPassword($password);
        }

        return $this->query->Rcon($command);
    }
}