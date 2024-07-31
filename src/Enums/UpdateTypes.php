<?php

namespace LaMoore\Tg\Enums;

enum UpdateTypes: string
{
    case Error = 'error';
    case Update = 'update';
    case Message = 'message';
    case Command = 'command';
    case EditedMessage = 'edited_message';
    case ChannelPost = 'channel_post';
    case EditedChannelPost = 'edited_channel_post';
    case InlineQuery = 'inline_query';
    case ChosenInlineResult = 'chosen_inline_result';
    case CallbackQuery = 'callback_query';
    case ShippingQuery = 'shipping_query';
    case PreCheckoutQuery = 'pre_checkout_query';
    case SuccessfulPayment = 'successful_payment';
}