<?php

namespace R794021\Tasks;

use R794021\Users\Contractor;
use R794021\Users\Customer;
use R794021\Users\User;
use R794021\Actions\{Action, Apply, Cancel, Done, Reject};


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

    protected const MAP_STATUS_TO_NEXT_ACTION = [
        self::STATUS_CANCELLED => [],
        self::STATUS_NEW => [self::ACTION_CANCEL, self::ACTION_APPLY],
        self::STATUS_RUNNING => [self::ACTION_CONFIRM_DONE, self::ACTION_REJECT],
        self::STATUS_DONE => [],
        self::STATUS_FAILED => [],
    ];

    protected $data;


    public function __construct(string $status, Customer $customer, Contractor $contractor = Null)
    {
        if (! array_key_exists($status, self::MAP_STATUS_TO_NEXT_ACTION)) {
            throw new \ValueError('Unknown status.');
        }

        if ($contractor && $customer->getId() === $contractor->getId()) {
            throw new \ValueError('Contractor cannot be a customer of the same task.');
        }

        $this->status = $status;
        $this->customer = $customer;
        $this->contractor = $contractor;
    }

    public function getCustomer(): User
    {
        return $this->customer;
    }

    public function getContractor(): User|Null
    {
        return $this->contractor;
    }

    protected function getNextActions($status = Null): array
    {
        $status = $status ?? $this->getStatus();
        return
            self::MAP_STATUS_TO_NEXT_ACTION[$status] ??
            new \ValueError('Unknown status.');
    }

    public function getNextStatus(Action $action): string
    {
        switch (True) {
            case $action instanceof Apply:
                return self::STATUS_RUNNING;

            case $action instanceof Cancel:
                return self::STATUS_CANCELLED;

            case $action instanceof Done:
                return self::STATUS_DONE;

            case $action instanceof Reject:
                return self::STATUS_FAILED;

            default:
                throw new \ValueError('Invalid action');
        }
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function isRunning(): bool
    {
        return $this->status === self::STATUS_RUNNING;
    }
}
