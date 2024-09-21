<?php

namespace LaMoore\Tg;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use LaMoore\Tg\Enums\UpdateTypes;
use LaMoore\Tg\Resources\MessageEntityResource;
use LaMoore\Tg\Resources\MessageResource;
use LaMoore\Tg\Resources\UserResource;
use LaMoore\Tg\Resources\UpdateResource;

class TelegramUpdate {
    public UpdateResource $update;

    public static function make(array $update): static {
        $self = new static();

        $self->update = UpdateResource::make($update);

        return $self;
    }

    public function getMessage(): MessageResource | null {
        return $this->update->message ?? null;
    }

    public function getFrom(): UserResource | null {
        $type = $this->getType()->value;

        return $this->update->$type?->from ?? null;
    }

    public function getType(): UpdateTypes {
//        $commands = collect($this->getMessage()?->entities ?? [])
//            ->filter(fn ($entity) => $entity->type === 'bot_command');
//
//        if (count($commands) > 0) {
//            return UpdateTypes::Command;
//        }

        foreach (UpdateTypes::cases() as $case) {
            $caseValue = $case->value;

            if (isset($this->update->$caseValue)) {
                return $case;
            }
        }

        return UpdateTypes::Message;
    }

    public function getCommands(): Collection {
        return collect($this->getMessage()?->entities ?? [])
            ->filter(fn ($entity) => $entity->type === 'bot_command')
            ->map(function (MessageEntityResource $command) {
                $text = Str::of($this->getMessage()->text);
                $commandName = (string) $text->substr($command->offset, $command->length)
                    ->after('/');
                $parameter = (string) $text->after(' ');

                return [
                    'name' => $commandName,
                    'parameter' => $parameter
                ];
            });
    }
}
