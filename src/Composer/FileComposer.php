<?php

namespace LaMoore\Tg\Composer;

class FileComposer extends BaseComposer {
    protected string $file_id;

    public function file_id (string $file_id): static {
        $this->file_id = $file_id;

        return $this;
    }
}
