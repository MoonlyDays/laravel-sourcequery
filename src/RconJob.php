<?php

namespace MoonlyDays\LaravelSourceQuery;

use App\Models\MatchSearch;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use xPaw\SourceQuery\Exception\AuthenticationException;
use xPaw\SourceQuery\Exception\InvalidPacketException;
use xPaw\SourceQuery\Exception\SocketException;

class RconJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public string $ip,
        public string $port,
        public string $password,
        public string $command,
        public int $timeout,
        public int $engine,
    ) {}

    /**
     * @throws InvalidPacketException
     * @throws AuthenticationException
     * @throws SocketException
     */
    public function handle(): void
    {
        /** @var Query $query */
        $query = app(Service::class)->query(
            $this->ip,
            $this->port,
            $this->timeout,
            $this->engine
        );

        $query->rcon($this->password)->send($this->command);
    }
}