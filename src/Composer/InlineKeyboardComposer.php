<?php

namespace LaMoore\Tg\Composer;

use Illuminate\Support\Collection;

class InlineKeyboardComposer extends BaseComposer {
    protected array $inline_keyboard = [];

    /**
     * @param InlineKeyboardButtonComposer[] $row
     */
    public function row (array $row): static {
        $this->inline_keyboard[] = $row;

        return $this;
    }

    public function buttons (array $buttons): static {
        foreach ($buttons as $button) {
            $this->row([$button]);
        }

        return $this;
    }

    public function chunk (int $count = 1): static {
        $buttons = array_merge(...$this->inline_keyboard);
        $rows = array_chunk($buttons, $count);

        $this->inline_keyboard = $rows;

        return $this;
    }

    public function paginate (int $page = 1, int $perPage = 10): static {
        $this->inline_keyboard = array_slice($this->inline_keyboard, ($page - 1) * $perPage, $perPage);

        return $this;
    }

    public function eachButton (callable $cb): static {
        $buttons = array_merge(...$this->inline_keyboard);

        foreach ($buttons as $index => $button) {
            $cb($button, $index);
        }

        return $this;
    }

    public function getParamsCollection(): Collection {
        $data = collect();

        $data['inline_keyboard'] = array_map(function ($row) {
            return array_map(fn ($item) => $item->toArray(), $row);
        }, $this->inline_keyboard);

        return $data;
    }
}
