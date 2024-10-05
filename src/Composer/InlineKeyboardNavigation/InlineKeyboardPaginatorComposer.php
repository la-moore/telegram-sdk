<?php

namespace LaMoore\Tg\Composer\InlineKeyboardNavigation;

use LaMoore\Tg\Composer\InlineKeyboardButtonComposer;
use LaMoore\Tg\Helpers\StringHelper;

class InlineKeyboardPaginatorComposer extends InlineKeyboardLightPaginatorComposer {
    protected array $labels = [
        'start' => '« $page',
        'previous' => '‹ $page',
        'current' => '- $page -',
        'next' => '$page ›',
        'end' => '$page »',
    ];

    public function getParamsCollection(): array
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
                ->text(StringHelper::replace($btn['label'], ['page' => $btn['page']]))
                ->command($this->command, $this->getButtonParams($btn['page']));
        }, array_values($navigation));
    }
}
