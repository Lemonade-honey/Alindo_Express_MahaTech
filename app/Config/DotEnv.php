<?php

namespace Mahatech\AlindoExpress\Config;
class DotEnv{
    public static function set_default_timezone(): string{
        date_default_timezone_set("Asia/Jakarta");
        return date_default_timezone_get();
    }

}