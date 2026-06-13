<?php

namespace Iwh3n\Tgram\Config;

class DefaultConfig
{
    public static function yaml(): string
    {
        return <<<YAML
tgram:
  bot:
    token: "TELEGRAM_BOT_TOKEN"
    entry_point: "TELEGRAM_BOT_ENTRY_POINT"

  allow_updates:
    message: true
    edited_message: true
    channel_post: true
    edited_channel_post: true
    business_connection: true
    business_message: true
    edited_business_message: true
    deleted_business_messages: true
    guest_message: true
    message_reaction: true
    message_reaction_count: true
    inline_query: true
    chosen_inline_result: true
    callback_query: true
    shipping_query: true
    pre_checkout_query: true
    purchased_paid_media: true
    poll: true
    poll_answer: true
    my_chat_member: true
    chat_member: true
    chat_join_request: true
    chat_boost: true
    removed_chat_boost: true
    managed_bot: true

  proxy:
    enabled: false
    host: "127.0.0.1"
    port: 9050
YAML;
    }
}
