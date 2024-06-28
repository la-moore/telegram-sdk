<?php

namespace LaMoore\Tg\Composer;

class PreCheckoutQueryComposer extends BaseComposer {
    public string $pre_checkout_query_id;
    public bool $ok;
    public ?string $error_message = null;

    public function pre_checkout_query_id (string $pre_checkout_query_id): static {
        $this->pre_checkout_query_id = $pre_checkout_query_id;

        return $this;
    }

    public function ok (bool $ok): static {
        $this->ok = $ok;

        return $this;
    }

    public function error_message (int $error_message): static {
        $this->error_message = $error_message;

        return $this;
    }
}
