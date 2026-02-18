<?php

namespace Iwh3n\Tgram\Update;

class UpdateResolver
{
    private array $update;

    public function __construct(array $update)
    {
        $this->update = $update;
    }

    public function resolveUpdateType(): string
    {
        return match (true) {
            isset($this->update['message']) => "message",
            isset($this->update['edited_message']) => 'edited_message',
            isset($this->update['channel_post']) => 'channel_post',
            isset($this->update['edited_channel_post']) => 'edited_channel_post',
            isset($this->update['business_connection']) => 'business_connection',
            isset($this->update['business_message']) => 'business_message',
            isset($this->update['edited_business_message']) => 'edited_business_message',
            isset($this->update['deleted_business_messages']) => 'deleted_business_messages',
            isset($this->update['message_reaction']) => 'message_reaction',
            isset($this->update['message_reaction_count']) => 'message_reaction_count',
            isset($this->update['inline_query']) => 'inline_query',
            isset($this->update['chosen_inline_result']) => 'chosen_inline_result',
            isset($this->update['callback_query']) => 'callback_query',
            isset($this->update['shipping_query']) => 'shipping_query',
            isset($this->update['pre_checkout_query']) => 'pre_checkout_query',
            isset($this->update['purchased_paid_media']) => 'purchased_paid_media',
            isset($this->update['poll']) => 'poll',
            isset($this->update['poll_answer']) => 'poll_answer',
            isset($this->update['my_chat_member']) => 'my_chat_member',
            isset($this->update['chat_member']) => 'chat_member',
            isset($this->update['chat_join_request']) => 'chat_join_request',
            isset($this->update['chat_boost']) => 'chat_boost',
            isset($this->update['removed_chat_boost']) => 'removed_chat_boost',

            default => 'unknown'
        };
    }

    // private function resolveMessageType(array $message): string
    // {
    //     return match (true) {
    //         isset($message['text']) => 'message.text',
    //         isset($message['photo']) => 'message.photo',
    //         isset($message['video']) => 'message.video',
    //         isset($message['video_note']) => 'message.video_note',
    //         isset($message['audio']) => 'message.audio',
    //         isset($message['voice']) => 'message.voice',
    //         isset($message['document']) => 'message.document',
    //         isset($message['paid_media']) => 'message.paid_media',
    //         isset($message['story']) => 'message.story',
    //         isset($message['sticker']) => 'message.sticker',
    //         isset($message['animation']) => 'message.animation',
    //         isset($message['contact']) => 'message.contact',
    //         isset($message['location']) => 'message.location',
    //         isset($message['venue']) => 'message.venue',
    //         isset($message['poll']) => 'message.poll',
    //         isset($message['dice']) => 'message.dice',
    //         isset($message['new_chat_members']) => 'message.new_chat_members',
    //         isset($message['left_chat_member']) => 'message.left_chat_member',
    //         isset($message['new_chat_title']) => 'message.new_chat_title',
    //         isset($message['new_chat_photo']) => 'message.new_chat_photo',
    //         isset($message['delete_chat_photo']) => 'message.delete_chat_photo',
    //         isset($message['group_chat_created']) => 'message.group_chat_created',
    //         isset($message['supergroup_chat_created']) => 'message.supergroup_chat_created',
    //         isset($message['channel_chat_created']) => 'message.channel_chat_created',
    //         isset($message['migrate_to_chat_id']) => 'message.migrate_to_chat_id',
    //         isset($message['migrate_from_chat_id']) => 'message.migrate_from_chat_id',
    //         isset($message['pinned_message']) => 'message.pinned_message',
    //         default => 'message.unknown'
    //     };
    // }

    public function getUpdate(): array
    {
        return $this->update;
    }
}
