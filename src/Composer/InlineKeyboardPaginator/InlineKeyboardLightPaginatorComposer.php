<?php

namespace LaMoore\Tg\Composer\InlineKeyboardPaginator;

use LaMoore\Tg\Composer\InlineKeyboardButtonComposer;
use LaMoore\Tg\Composer\InlineKeyboardComposer;

class InlineKeyboardLightPaginatorComposer extends InlineKeyboardComposer {
    protected string $command;
    protected int $page;
    protected int $items_count = 0;
    protected int $per_page = 10;
    protected string $page_param = 'page';
    protected array $extra_params = [];
    protected array $labels = [
        'previous' => 'Previous page',
        'next' => 'Next page',
    ];

    public function command(string $command): static
    {
        $this->command = $command;

        return $this;
    }

    public function labels(array $labels): static
    {
        $this->labels = array_merge($this->labels, $labels);

        return $this;
    }

    public function page(int $page): static
    {
        $this->page = $page;

        return $this;
    }

    public function count(int $count): static
    {
        $this->items_count = $count;

        return $this;
    }

    public function per_page(int $perPage): static
    {
        $this->per_page = $perPage;

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

    protected function getButtonParams (int $page)
    {
        return array_merge(
            $this->extra_params,
            [$this->page_param => $page]
        );
    }

    protected function createNavigation(): array
    {
        $lastPage = ceil($this->items_count / $this->per_page);

        $navigation = [
            ['label' => $this->labels['previous'], 'page' => $this->page - 1, 'filter' => $this->page > 1],
            ['label' => $this->labels['next'], 'page' => $this->page + 1, 'filter' => $this->page < $lastPage],
        ];

        $navigation = array_filter($navigation, fn ($btn) => $btn['filter']);

        return array_map(function ($btn) {
            return InlineKeyboardButtonComposer::make()
                ->text($btn['label'])
                ->command($this->command, $this->getButtonParams($btn['page']));
        }, array_values($navigation));
    }

    public function getParamsCollection(): array {
        $data = [];

        $inline_keyboard = array_merge(
            $this->inline_keyboard,
            [$this->createNavigation()]
        );

        $data['inline_keyboard'] = array_map(function ($row) {
            return array_map(fn ($item) => $item->toArray(), $row);
        }, $inline_keyboard);

        return $data;
    }
}
