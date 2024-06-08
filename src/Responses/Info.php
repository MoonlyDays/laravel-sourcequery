<?php

namespace MoonlyDays\LaravelSourceQuery\Responses;

use MoonlyDays\LaravelSourceQuery\AbstractResponse;

/**
 * @property-read int Protocol
 * @property-read string HostName
 * @property-read string Map
 * @property-read string ModDir
 * @property-read string ModDesc
 * @property-read int AppID
 * @property-read int Players
 * @property-read int MaxPlayers
 * @property-read int Bots
 * @property-read string Dedicated
 * @property-read string Os
 * @property-read int Password
 * @property-read int Secure
 * @property-read int Version
 * @property-read int ExtraDataFlags
 * @property-read int GamePort
 * @property-read string SteamID
 * @property-read string GameTags
 * @property-read int GameId
 */
class Info extends AbstractResponse
{
}