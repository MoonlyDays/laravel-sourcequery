<?php

namespace MoonlyDays\LaravelSourceQuery;

use Exception;
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
        private readonly int    $port,
        private readonly int    $timeout,
        private readonly int    $engine
    )
    {
        $this->query = new xPawSourceQuery;
        $this->query->Connect($this->ip, $this->port, $this->timeout, $this->engine);
    }

    /**
     * Sets the RCON password to use in this server query.
     *
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
     *
     * @throws InvalidPacketException
     * @throws SocketException
     */
    public function rules(): array
    {
        return $this->query->GetRules();
    }

    /**
     * Returns the information about the target server.
     */
    public function info(): Info|null
    {
        try {
            return new Info($this->query->GetInfo());
        } catch (Exception) {
            return null;
        }
    }

    /**
     * Returns the data about the players currently on the server.
     *
     * @return Collection<Player>|null
     */
    public function players(): Collection|null
    {
        try {
            return collect($this->query->GetPlayers())->mapInto(Player::class);
        } catch (Exception) {
            return null;
        }
    }

    public function rcon(string $password): RconQuery
    {
        return new RconQuery(
            $this->query,
            $password,

            $this->ip,
            $this->port,
            $this->timeout,
            $this->engine,
        );
    }
}
