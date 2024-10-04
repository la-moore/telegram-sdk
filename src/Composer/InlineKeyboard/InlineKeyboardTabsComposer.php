<?php

namespace LaMoore\Tg\Composer\InlineKeyboard;

use LaMoore\Tg\Composer\InlineKeyboardButtonComposer;
use LaMoore\Tg\Composer\InlineKeyboardComposer;

class InlineKeyboardTabsComposer extends InlineKeyboardComposer {
    protected string $command;
    protected int $tab = 0;
    protected string $selected_label = '- $t -';
    protected string $page_param = 'tab';
    protected array $extra_params = [];
    protected array $tabs = [];

    private function formatString(string $str, string $tab): string
    {
        return str_replace('$t', $tab, $str);
    }

    public function command(string $command): static
    {
        $this->command = $command;

        return $this;
    }

    public function tabs(array $tabs): static
    {
        $this->tabs = $tabs;

        return $this;
    }

    public function tab(int $tab): static
    {
        $this->tab = $tab;

        return $this;
    }

    public function page_param(string $param): static
    {
        $this->page_param = $param;

        return $this;
    }

    public function extra_params(array $params): static
    {
        $this->extra_params = $params;

        return $this;
    }

    protected function getButtonParams (int $tab)
    {
        return array_merge(
            $this->extra_params,
            [$this->page_param => $tab]
        );
    }

    protected function createButtons(): array
    {
        $buttons = array_values($this->tabs)[$this->tab];

        return array_map(fn ($item) => [$item], $buttons);
    }

    protected function createNavigation(): array
    {
        $labels = array_keys($this->tabs);

        return array_map(function ($label, $key) {
            $isSelected = $this->tab === $key;
            return InlineKeyboardButtonComposer::make()
                ->text($isSelected ? $this->formatString($this->selected_label, $label) : $label)
                ->command($this->command, $this->getButtonParams($key));
        }, $labels, array_keys($labels));
    }

    public function getParamsCollection(): array {
        $data = [];

        $inline_keyboard = array_merge(
            $this->createButtons(),
            [$this->createNavigation()]
        );

        $data['inline_keyboard'] = array_map(function ($row) {
            return array_map(fn ($item) => $item->toArray(), $row);
        }, $inline_keyboard);

        return $data;
    }
}
