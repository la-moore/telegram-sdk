<?php
namespace LaMoore\Tg\Resources;

class UpdateResource extends BaseResource
{
    public int $update_id;
    public MessageResource|null $message = null;
    public MessageResource|null $edited_message = null;
    public MessageResource|null $channel_post = null;
    public MessageResource|null $edited_channel_post = null;
    public MessageResource|null $edited_business_message = null;
//    public mixed $business_connection; // BusinessConnection
//    public mixed $deleted_business_messages; // BusinessMessagesDeleted
//    public mixed $message_reaction; // MessageReactionUpdated
//    public mixed $message_reaction_count; // MessageReactionCountUpdated
//    public mixed $inline_query; // InlineQuery
//    public mixed $chosen_inline_result; // ChosenInlineResult
    public CallbackQueryResource|null $callback_query = null;
//    public mixed $shipping_query; // ShippingQuery
//    public mixed $pre_checkout_query; // PreCheckoutQuery
//    public mixed $poll; // Poll
//    public mixed $poll_answer; // PollAnswer
//    public mixed $my_chat_member; // MyChatMember
//    public mixed $chat_member; // ChatMember
//    public mixed $chat_join_request; // ChatJoinRequest
//    public mixed $chat_boost; // ChatBoostUpdated
//    public mixed $removed_chat_boost; // ChatBoostRemoved
}
