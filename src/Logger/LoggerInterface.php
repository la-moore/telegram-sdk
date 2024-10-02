<?php

namespace LaMoore\Tg\Logger;

interface LoggerInterface
{
    public function log(string $message): void;
}
