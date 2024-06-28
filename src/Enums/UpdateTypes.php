<?php

namespace LaMoore\Tg\Enums;

enum UpdateTypes
{
    case Message;
    case Command;
    case EditedMessage;
    case ChannelPost;
    case EditedChannelPost;
    case InlineQuery;
    case ChosenInlineResult;
    case CallbackQuery;
    case ShippingQuery;
}