<?php

namespace Musonza\Chat\Messages;

use Illuminate\Database\Eloquent\Model;
use Musonza\Chat\Models\Conversation;

class SendMessageCommand
{
    public $body;
    public $conversation;
    public $type;
    public $data;
    public $participant;
    public $delivered_ts_int;
    public $delivered_ts;
    public $is_outgoing;
    public $is_need_send;
    public $is_send_success;

    /**
     * @param Conversation $conversation The conversation
     * @param string       $body         The message body
     * @param Model        $sender       The sender identifier
     * @param string       $type         The message type
     */
    public function __construct(Conversation $conversation, $body, Model $sender, $type = 'text', $data,
                                $delivered_ts_int,$is_outgoing,$is_need_send,$is_send_success,$delivered_ts)
    {
        $this->conversation = $conversation;
        $this->body = $body;
        $this->type = $type;
        $this->data = $data;
        $this->delivered_ts_int = $delivered_ts_int;
        $this->delivered_ts = $delivered_ts;
        $this->is_send_success = $is_send_success;
        $this->is_need_send = $is_need_send;
        $this->is_outgoing = $is_outgoing;
        $this->participant = $this->conversation->participantFromSender($sender);
    }
}
