<?php

namespace LaMoore\Tg\Composer;

class LabeledPriceComposer extends BaseComposer {
    public string $label;
    public int $amount;

    public function label (string $label): static {
        $this->label = $label;

        return $this;
    }

    public function amount (int $amount): static {
        $this->amount = $amount;

        return $this;
    }
}
