<?php

namespace R794021;

/**
 *
 */
class Task
{
    public const STATUS_CANCELLED  = 'cancelled';
    public const STATUS_NEW = 'new';
    public const STATUS_RUNNING = 'running';
    public const STATUS_DONE = 'done';
    public const STATUS_FAILED = 'failed';

    public const ACTION_CANCEL = 'cancel';
    public const ACTION_APPLY = 'apply';
    public const ACTION_CONFIRM_DONE = 'done';
    public const ACTION_REJECT = 'reject';

    protected const MappingStatusToNextActions = [
        self::STATUS_CANCELLED => [],
        self::STATUS_NEW => [self::ACTION_CANCEL, self::ACTION_APPLY],
        self::STATUS_RUNNING => [self::ACTION_CONFIRM_DONE, self::ACTION_REJECT],
        self::STATUS_DONE => [],
        self::STATUS_FAILED => [],
    ];

    protected const MappingActionToNextStatus = [
        self::ACTION_CANCEL => self::STATUS_CANCELLED,
        self::ACTION_APPLY => self::STATUS_RUNNING,
        self::ACTION_CONFIRM_DONE => self::STATUS_DONE,
        self::ACTION_REJECT => self::STATUS_FAILED,
    ];

    protected $data;


    public function __construct($status, $customerId, $contractorId = Null)
    {
        if (! array_key_exists($status, self::MappingStatusToNextActions)) {
            throw new \Exception('Unknown status.');
        }

        $this->data['status'] = $status;
        $this->data['customerId'] = $customerId;

        if ($customerId === $contractorId) {
            throw new \Exception('Contractor cannot be a customer of the same task.');
        };
        $this->data['contractorId'] = $contractorId;

        $this->bids = new Bids();
        $this->chat = new Chat();
    }

    public function addBid(Bid $bid)
    {
        $this->bids->addBid($bid);
    }

    public function cancel(User $initiator)
    {
        switch ($initiator->getId()) {
            case $this->data['customerId']:
                $this->cancelOrder();
                break;
            case $this->data['contractorId']:
                $this->rejectOrder();
                break;
            default:
                throw new \Exception('Task may be cancelled by customer or contractor');
        }
    }

    protected function cancelOrder()
    {
    }

    protected function rejectOrder()
    {
    }

    public function chooseContractor(Contractor $contractor)
    {
        $this->data['contractorId'] = $contractor->getId();
        $this->bid = $bids->findBid($contractor);
        $this->bids = null;
    }

    public function getNextActions($status = Null): array
    {
        $status = $status ?? $this->getStatus();
        return self::MappingStatusToNextActions[$status] ?? new \Exception('Unknown status.');
    }


    public function getNextStatus($action): string
    {
        if (! in_array($action, $this->getNextActions())) {
            throw new \Exception("Action '{$action}' cannot be made in the current status '{$this->getStatus()}'.");
        }
        return self::MappingActionToNextStatus[$action];
    }

    public function getStatus()
    {
        return $this->data['status'];
    }


    public function dispatch(string $action): void
    {
        if (! in_array($action, $this->getNextActions())) {
            throw new \Exception("Inappropriate action '{$action}' for the current status '{$this->getStatus()}' of the task.");
        }

        $this->data['status'] = self::MappingActionToNextStatus[$action] ?? new \Exception('Unknown action.');
        $this->isBeingExecuted = true;
    }

    public function isInProgress()
    {
        return $this->isBeingExecuted;
    }
}
