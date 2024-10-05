<?php

namespace LaMoore\Tg\Composer\InlineKeyboardNavigation;

use LaMoore\Tg\Composer\InlineKeyboardButtonComposer;

class InlineKeyboardLightPaginatorComposer extends InlineKeyboardNavigationComposer {
    protected int $page;
    protected int $items_count = 0;
    protected int $per_page = 10;
    protected string $parameter = 'page';
    protected array $labels = [
        'previous' => 'Previous page',
        'next' => 'Next page',
    ];

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

    public function getParamsCollection(): array {
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
}
