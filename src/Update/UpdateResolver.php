<?php

namespace Iwh3n\Tgram\Update;

use Iwh3n\Tgram\Config\DefaultConfig;

class UpdateResolver
{
    private array $update;

    public function __construct(array $update)
    {
        $this->update = $update;
    }

    public function resolveUpdateType(): string
    {
        foreach (DefaultConfig::get()['tgram']['allow_updates'] as $type => $value) {
            if (isset($this->update[$type])) {
                return $type;
            }
        }

        return 'unknown';
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
