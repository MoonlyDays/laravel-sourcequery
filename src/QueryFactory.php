<?php

namespace MoonlyDays\LaravelSourceQuery;


use xPaw\SourceQuery\Exception\InvalidArgumentException;
use xPaw\SourceQuery\Exception\SocketException;
use xPaw\SourceQuery\SourceQuery;

class QueryFactory
{
    /**
     * @throws SocketException
     * @throws InvalidArgumentException
     */
    public function query(string $ip, int $port, int $timeout = 3, int $engine = SourceQuery::SOURCE): Query
    {
        return new Query($ip, $port, $timeout, $engine);
    }
}
