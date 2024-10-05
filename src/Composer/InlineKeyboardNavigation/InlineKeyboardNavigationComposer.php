<?php

namespace LaMoore\Tg\Composer\InlineKeyboardNavigation;

use LaMoore\Tg\Composer\InlineKeyboardButtonComposer;
use LaMoore\Tg\Composer\BaseComposer;
use LaMoore\Tg\Helpers\StringHelper;

class InlineKeyboardNavigationComposer extends BaseComposer {
    protected string $command;
    protected string $parameter = 'p';
    protected array $props = [];

    public function command(string $command, array $data = []): static
    {
        $this->command = $command;
        $this->props = $data;

        return $this;
    }

    public function parameter(string $param): static
    {
        $this->parameter = $param;

        return $this;
    }

    protected function getButtonParams (int $tab): array
    {
        return array_merge(
            $this->props,
            [$this->parameter => $tab]
        );
    }

    public function getParamsCollection(): array {
        return [];
    }
}
