<?php

namespace R794021;

class Chat
{
    public function __construct()
    {
        $this->messages = [];
    }

    public function addMessage(ChatMessage $message)
    {
        $this->messages[] = $message;
        $this->sortMessages();
    }

    public function sortMessages()
    {
        array_sort($this->messages, function ($msg1, $msg2) {
            return $msg1->getDatetime() <= $msg2->getDatetime() ? -1 : 1;
        });
        $this->messages = array_values($this->messages);
    }
}
