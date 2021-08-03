<?php

namespace R794021\Tasks;

use R794021\Users\Contractor;
use R794021\Users\Customer;
use R794021\Users\User;


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

    protected const MAP_ACTION_TO_NEXT_STATUS = [
        self::ACTION_CANCEL => self::STATUS_CANCELLED,
        self::ACTION_APPLY => self::STATUS_RUNNING,
        self::ACTION_CONFIRM_DONE => self::STATUS_DONE,
        self::ACTION_REJECT => self::STATUS_FAILED,
    ];

    protected $data;


    public function __construct($status, Customer $customer, Contractor $contractor = Null)
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

    public function getNextStatus($action): string
    {
        if (! in_array($action, $this->getNextActions())) {
            throw new \ValueError("Action '{$action}' cannot be made in the current status '{$this->getStatus()}'.");
        }
        return self::MAP_ACTION_TO_NEXT_STATUS[$action];
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
