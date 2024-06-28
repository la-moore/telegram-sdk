<?php

namespace LaMoore\Tg\Composer;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;
use LaMoore\Tg\Resources\BaseResource;
use LaMoore\Tg\Resources\LinkPreviewOptionsResource;
use LaMoore\Tg\Resources\MessageEntityResource;
use LaMoore\Tg\Resources\ReplyParametersResource;

class InvoiceComposer extends BaseComposer {
    protected int $chat_id;
    protected string $title;
    protected string $description;
    protected array $payload;
    protected string $currency;
    protected array $prices = [];
    protected ?int $message_thread_id = null;
    protected ?string $provider_token = null;
    protected ?int $max_tip_amount = null;
    protected ?array $suggested_tip_amounts = null;
    protected ?string $start_parameter = null;
    protected ?array $provider_data = null;
    protected ?string $photo_url = null;
    protected ?int $photo_size = null;
    protected ?int $photo_width = null;
    protected ?int $photo_height = null;
    protected ?bool $need_name = null;
    protected ?bool $need_phone_number = null;
    protected ?bool $need_email = null;
    protected ?bool $need_shipping_address = null;
    protected ?bool $send_phone_number_to_provider = null;
    protected ?bool $send_email_to_provider = null;
    protected ?bool $is_flexible = null;
    protected ?bool $disable_notification = null;
    protected ?bool $protect_content = null;
    protected ?bool $message_effect_id = null;
    protected ?ReplyParametersResource $reply_parameters = null;
    protected ?InlineKeyboardComposer $reply_markup = null;

    public function chat_id(int $chat_id): static
    {
        $this->chat_id = $chat_id;

        return $this;
    }

    public function title(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function description(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function payload(array $payload): static
    {
        $this->payload = $payload;

        return $this;
    }

    public function currency(string $currency): static
    {
        $this->currency = $currency;

        return $this;
    }

    public function message_thread_id(int $message_thread_id): static
    {
        $this->message_thread_id = $message_thread_id;

        return $this;
    }

    public function provider_token(string $provider_token): static
    {
        $this->provider_token = $provider_token;

        return $this;
    }

    public function max_tip_amount(int $max_tip_amount): static
    {
        $this->max_tip_amount = $max_tip_amount;

        return $this;
    }

    public function suggested_tip_amounts(array $suggested_tip_amounts): static
    {
        $this->suggested_tip_amounts = $suggested_tip_amounts;

        return $this;
    }

    public function start_parameter(string $start_parameter): static
    {
        $this->start_parameter = $start_parameter;

        return $this;
    }

    public function provider_data(array $provider_data): static
    {
        $this->provider_data = $provider_data;

        return $this;
    }


    public function need_name(bool $need_name): static
    {
        $this->need_name = $need_name;

        return $this;
    }

    public function need_phone_number(bool $need_phone_number): static
    {
        $this->need_phone_number = $need_phone_number;

        return $this;
    }

    public function need_email(bool $need_email): static
    {
        $this->need_email = $need_email;

        return $this;
    }

    public function need_shipping_address(bool $need_shipping_address): static
    {
        $this->need_shipping_address = $need_shipping_address;

        return $this;
    }

    public function send_phone_number_to_provider(bool $send_phone_number_to_provider): static
    {
        $this->send_phone_number_to_provider = $send_phone_number_to_provider;

        return $this;
    }

    public function send_email_to_provider(bool $send_email_to_provider): static
    {
        $this->send_email_to_provider = $send_email_to_provider;

        return $this;
    }

    public function is_flexible(bool $is_flexible): static
    {
        $this->is_flexible = $is_flexible;

        return $this;
    }

    public function disable_notification(bool $disable_notification): static
    {
        $this->disable_notification = $disable_notification;

        return $this;
    }

    public function protect_content(bool $protect_content): static
    {
        $this->protect_content = $protect_content;

        return $this;
    }

    public function message_effect_id(bool $message_effect_id): static
    {
        $this->message_effect_id = $message_effect_id;

        return $this;
    }


    /**
     * @param LabeledPriceComposer[] $prices
     */
    public function prices(array $prices): static
    {
        $this->prices = $prices;

        return $this;
    }

    public function photo(string $url, ?int $width, ?int $height, ?int $size): static
    {
        $this->photo_url = $url;

        if ($width) {
            $this->photo_width = $width;
        }

        if ($height) {
            $this->photo_height = $height;
        }

        if ($size) {
            $this->photo_size = $size;
        }

        return $this;
    }

    public function reply(string $message_id): static
    {
        $this->reply_parameters = ReplyParametersResource::make([
            'message_id' => $message_id
        ]);

        return $this;
    }

    public function keyboard(InlineKeyboardComposer $keyboard): static
    {
        $this->reply_markup = $keyboard;

        return $this;
    }


    public function getParamsCollection(): Collection {
        $data = collect(get_object_vars($this));

        if ($this->prices) {
            $prices = collect($this->prices)->map(fn ($price) => $price->toArray());
            $data['prices'] = json_encode($prices);
        }

        if ($this->provider_data) {
            $data['provider_data'] = json_encode($this->provider_data);
        }

        if ($this->payload) {
            $data['payload'] = json_encode($this->payload);
        }

        $data['reply_markup'] = $this->reply_markup?->toJson() ?? null;

        return $data;
    }
}
