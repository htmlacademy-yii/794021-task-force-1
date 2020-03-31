<?php
/*
 * Draft, pre-design, thoughts of classes
 */

/*
 * Task related
 */

class Task
{
    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
        $this->bids = new Bids();
        $this->chat = new Chat();
        $this->contractor = null;
    }

    public function addBid(Bid $bid)
    {
        $this->bids->addBid($bid);
    }

    public function cancel(User $initiator)
    {
        if ($initiator->getId() === $this->customer->getId()) {
            $this->cancelOrder();
        } else {
            $this->rejectOrder();
        };
    }

    protected function cancelOrder()
    {
    }

    public function chooseContractor(Contractor $contractor)
    {
        $this->contractor = $contractor;
        $this->bid = $bids->findBid($contractor);
        $this->bids = null;
    }

    protected function rejectOrder()
    {
    }
}


class Bids
{
    public function __construct()
    {
        $this->bids = [];
    }

    public function addBid(Bid $bid)
    {
        $this->bids[] = $bid;
    }

    public function findBid(Contractor $contractor)
    {
        return current(array_filter($this->bids, function ($bid) use ($contractor) {
            $bid->getContractor() === $contractor;
        }));
    }
}

class Bid
{
    public function __construct(Contractor $contractor, $data)
    {
        $this->contractor = $contractor;
        $this->taskId = $data['taskId'];
        $this->budget = $data['budget'];
        $this->text = $data['text'];
    }

    public function getContractor()
    {
        return $this->contractor;
    }

    public function getId()
    {
        return $this->id;
    }
}

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

class Chat
{
    public function __construct($taskId)
    {
        $this->taskId = $taskId;
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

class Review
{
    public function __construct($taskId)
    {
        $this->taskId = $taskId;
    }
}
