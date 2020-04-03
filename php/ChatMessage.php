<?php

namespace R794021;

class ChatMessage
{
    public function __construct($userId, $text, $datetime)
    {
        $this->userId = $userId;
        $this->text = $text;
        $this->datetime = $datetime;
    }

    public function getDatetime()
    {
        return $this->datetime;
    }
}
