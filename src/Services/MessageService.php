<?php

namespace Musonza\Chat\Services;

use Exception;
use Musonza\Chat\Commanding\CommandBus;
use Musonza\Chat\Messages\SendMessageCommand;
use Musonza\Chat\Models\Message;
use Musonza\Chat\Traits\SetsParticipants;

class MessageService
{
    use SetsParticipants;

    protected $type = 'text';
    protected $data = [];
    protected $delivered_ts_int = null;
    protected $delivered_ts = null;
    protected $is_outgoing = 0;
    protected $is_need_send = 0;
    protected $is_send_success = 0;



    protected $body;
    /**
     * @var CommandBus
     */
    protected $commandBus;
    /**
     * @var Message
     */
    protected $message;

    public function __construct(CommandBus $commandBus, Message $message)
    {
        $this->commandBus = $commandBus;
        $this->message = $message;
    }

    public function setMessage($message)
    {
        if (is_object($message)) {
            $this->message = $message;
        } else {
            $this->body = $message;
        }

        return $this;
    }

    /**
     * Set Message type.
     *
     * @param string type
     *
     * @return $this
     */
    public function type(string $type)
    {
        $this->type = $type;

        return $this;
    }

    public function data(array $data)
    {
        $this->data = $data;

        return $this;
    }

    public function set_is_outgoing(int $val)
    {
        $this->is_outgoing = $val;

        return $this;
    }


    public function set_is_need_send(int $val)
    {
        $this->is_need_send = $val;

        return $this;
    }


    public function set_is_send_success(int $val)
    {
        $this->is_send_success = $val;

        return $this;
    }



    public function delivered_ts_int(int $delivered_ts_int)
    {
        $this->delivered_ts_int = $delivered_ts_int;
        $ts = date('Y-m-d h:i:s', floor($delivered_ts_int / 1000));

        $this->delivered_ts = $ts;

        return $this;
    }

    public function getById($id)
    {
        return $this->message->findOrFail($id);
    }

    /**
     * Mark a message as read.
     *
     * @return void
     */
    public function markRead()
    {
        $this->message->markRead($this->participant);
    }

    /**
     * Deletes message.
     *
     * @return void
     */
    public function delete()
    {
        $this->message->trash($this->participant);
    }

    /**
     * Get count for unread messages.
     *
     * @return void
     */
    public function unreadCount()
    {
        return $this->message->unreadCount($this->participant);
    }

    public function toggleFlag()
    {
        return $this->message->toggleFlag($this->participant);
    }

    public function flagged()
    {
        return $this->message->flagged($this->participant);
    }

    /**
     * Sends the message.
     *
     * @throws Exception
     *
     * @return void
     */
    public function send()
    {
        if (!$this->sender) {
            throw new Exception('Message sender has not been set');
        }

        if (strlen($this->body) == 0) {
            throw new Exception('Message body has not been set');
        }

        if (!$this->recipient) {
            throw new Exception('Message receiver has not been set');
        }






        $command = new SendMessageCommand($this->recipient, $this->body, $this->sender, $this->type, $this->data,
           $this->delivered_ts_int,$this->is_outgoing,$this->is_need_send,$this->is_send_success, $this->delivered_ts);

        return $this->commandBus->execute($command);
    }
}
