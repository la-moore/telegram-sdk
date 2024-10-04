<?php

namespace LaMoore\Tg\Composer;

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

    public function chunk (array $buttons, int $count = 1): static {
        $rows = array_chunk($buttons, $count);

        foreach ($rows as $row) {
            $this->row($row);
        }

        return $this;
    }

    public function paginate (array $buttons, int $page = 1, int $perPage = 10): static {
        $buttons = array_slice($buttons, ($page - 1) * $perPage, $perPage);

        $this->buttons($buttons);

        return $this;
    }

    public function eachButton (callable $cb): static {
        $buttons = array_merge(...$this->inline_keyboard);

        foreach ($buttons as $index => $button) {
            $cb($button, $index);
        }

        return $this;
    }

    public function getParamsCollection(): array {
        $data = [];

        $data['inline_keyboard'] = array_map(function ($row) {
            return array_map(fn ($item) => $item->toArray(), $row);
        }, $this->inline_keyboard);

        return $data;
    }
}
