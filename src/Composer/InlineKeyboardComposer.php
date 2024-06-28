<?php

namespace LaMoore\Tg\Composer;

class InlineKeyboardComposer extends BaseComposer {
    private array $inline_keyboard = [];

    /**
     * @param InlineKeyboardButtonComposer[] $row
     */
    public function row (array $row): static {
        $this->inline_keyboard[] = $row;

        return $this;
    }

    public function buttons (array $buttons): static {
        foreach ($buttons as $button) {
            $this->inline_keyboard[] = [$button];
        }

        return $this;
    }

    public function chunk (array $buttons, int $count = 1): static {
        $rows = array_chunk($buttons, $count);

        foreach ($rows as $row) {
            $this->inline_keyboard[] = $row;
        }

        return $this;
    }

    public function eachButton (callable $cb): static {
        foreach ($this->inline_keyboard as $row) {
            foreach ($row as $button) {
                $cb($button);
            }
        }

        return $this;
    }

    public function toArray(): array
    {
        if (isset($this->inline_keyboard)) {
            $inline_keyboard = array_map(function ($row) {
                return array_map(fn ($item) => $item->toArray(), $row);
            }, $this->inline_keyboard);

            return [
                'inline_keyboard' => $inline_keyboard
            ];
        }

        return [];
    }
}
