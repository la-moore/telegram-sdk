<?php

namespace LaMoore\Tg\Composer\InlineKeyboardPaginator;

use Illuminate\Support\Collection;
use LaMoore\Tg\Composer\InlineKeyboardButtonComposer;
use LaMoore\Tg\Composer\InlineKeyboardComposer;

class InlineKeyboardLightPaginatorComposer extends InlineKeyboardComposer {
    protected string $command;
    protected int $page;
    protected int $items_count = 0;
    protected int $per_page = 10;
    protected string $page_param = 'page';
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

    public function perPage(int $perPage): static
    {
        $this->per_page = $perPage;

        return $this;
    }

    public function pageParam(string $param): static
    {
        $this->page_param = $param;

        return $this;
    }

    protected function createNavigation(): array
    {
        $navigation = [];
        $lastPage = ceil($this->items_count / $this->per_page);

        if ($this->page > 1) {
            $btn = InlineKeyboardButtonComposer::make()
                ->text($this->labels['previous'])
                ->command($this->command, [
                    $this->page_param => $this->page - 1
                ]);

            $navigation[] = $btn;
        }

        if ($this->page < $lastPage) {
            $btn = InlineKeyboardButtonComposer::make()
                ->text($this->labels['next'])
                ->command($this->command, [
                    $this->page_param => $this->page + 1
                ]);

            $navigation[] = $btn;
        }

        return $navigation;
    }

    public function getParamsCollection(): Collection {
        $data = collect();

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
