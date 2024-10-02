<?php

namespace LaMoore\Tg;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use LaMoore\Tg\Enums\UpdateTypes;
use LaMoore\Tg\Resources\MessageEntityResource;
use LaMoore\Tg\Resources\MessageResource;
use LaMoore\Tg\Resources\UserResource;
use LaMoore\Tg\Resources\ChatResource;
use LaMoore\Tg\Resources\UpdateResource;

class TelegramUpdate {
    public UpdateResource $data;

    public static function create(array $update): static {
        $self = new static();

        $self->data = UpdateResource::make($update);

        return $self;
    }

    public function getRaw(): array{
        return $this->data->toArray();
    }

    public function getMessage(): MessageResource | null {
        $type = $this->getType()->value;

        return $this->update->message ?? $this->update->$type->message ?? null;
    }

    public function getChat(): ChatResource | null {
        $type = $this->getType()->value;

        return $this->update->$type->chat ?? null;
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
