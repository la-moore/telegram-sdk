<?php

namespace LaMoore\Tg\Composer\InlineKeyboardNavigation;

use LaMoore\Tg\Composer\InlineKeyboardButtonComposer;
use LaMoore\Tg\Helpers\StringHelper;

class InlineKeyboardTabsComposer extends InlineKeyboardNavigationComposer {
    protected int $selected = 0;
    protected string $selected_label = '- $label -';
    protected string $parameter = 'tab';
    protected array $tabs = [];

    public function tabs(array $tabs): static
    {
        $this->tabs = $tabs;

        return $this;
    }

    public function selected(int $selected): static
    {
        $this->selected = $selected;

        return $this;
    }

    public function selectedLabel(string $label): static
    {
        $this->selected_label = $label;

        return $this;
    }

    public function getParamsCollection(): array {
        return array_map(function ($label, $key) {
            $isSelected = $this->selected === $key;
            $selectedLabel = StringHelper::replace($this->selected_label, ['label' => $label]);

            return InlineKeyboardButtonComposer::make()
                ->text($isSelected ? $selectedLabel : $label)
                ->command($this->command, $this->getButtonParams($key));
        }, array_values($this->tabs), array_keys($this->tabs));
    }
}
