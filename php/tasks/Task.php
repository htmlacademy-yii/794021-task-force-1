<?php

namespace R794021\Tasks;

use R794021\Users;


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


    public function __construct($status, Users\Customer $customer, Users\Contractor $contractor = Null)
    {
        if (! array_key_exists($status, self::MAP_STATUS_TO_NEXT_ACTION)) {
            throw new \Error('Unknown status.');
        }

        if ($contractor && $customer->getId() === $contractor->getId()) {
            throw new \Error('Contractor cannot be a customer of the same task.');
        }

        $this->status = $status;
        $this->customer = $customer;
        $this->contractor = $contractor;
    }

    public function getCustomer()
    {
        return $this->customer;
    }

    public function getContractor()
    {
        return $this->contractor;
    }

    protected function getNextActions($status = Null): array
    {
        $status = $status ?? $this->getStatus();
        return self::MAP_STATUS_TO_NEXT_ACTION[$status] ?? new \Error('Unknown status.');
    }

    public function getNextStatus($action): string
    {
        if (! in_array($action, $this->getNextActions())) {
            throw new \Error("Action '{$action}' cannot be made in the current status '{$this->getStatus()}'.");
        }
        return self::MAP_ACTION_TO_NEXT_STATUS[$action];
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function isRunning()
    {
        return $this->status === self::STATUS_RUNNING;
    }
}
