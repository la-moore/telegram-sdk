<?php

namespace LaMoore\Tg\Composer\InlineKeyboardPaginator;

use LaMoore\Tg\Composer\InlineKeyboardButtonComposer;

class InlineKeyboardPaginatorComposer extends InlineKeyboardLightPaginatorComposer {
    protected array $labels = [
        'start' => '« $d',
        'previous' => '‹ $d',
        'current' => '- $d -',
        'next' => '$d ›',
        'end' => '$d »',
    ];

    private function formatString(string $str, int $page) {
        return str_replace('$d', $page, $str);
    }

    protected function createNavigation(): array
    {
        $lastPage = ceil($this->items_count / $this->per_page);
        $navigation = [
            ['label' => $this->labels['start'], 'page' => 1, 'filter' => $this->page > 2],
            ['label' => $this->labels['previous'], 'page' => $this->page - 1, 'filter' => $this->page > 1],
            ['label' => $this->labels['current'], 'page' => $this->page, 'filter' => true],
            ['label' => $this->labels['next'], 'page' => $this->page + 1, 'filter' => $this->page < $lastPage],
            ['label' => $this->labels['end'], 'page' => $lastPage, 'filter' => $this->page < $lastPage - 1],
        ];

        $navigation = array_filter($navigation, fn ($btn) => $btn['filter']);

        return array_map(function ($btn) {
            return InlineKeyboardButtonComposer::make()
                ->text($this->formatString($btn['label'], $btn['page']))
                ->command($this->command, [
                    $this->page_param => $btn['page']
                ]);
        }, array_values($navigation));
    }
}
