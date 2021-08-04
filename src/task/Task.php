<?php
namespace R794021\Task;

use R794021\User\{Contractor, Customer, User};
use R794021\Action\
    {Action, ApplyAction, CancelAction, DoneAction, RejectAction};
use R794021\Exception\DataDomainException;


class Task
{
    public const STATUS_CANCELLED  = 'cancelled';
    public const STATUS_NEW = 'new';
    public const STATUS_RUNNING = 'running';
    public const STATUS_DONE = 'done';
    public const STATUS_FAILED = 'failed';

    public const STATUSES = [
        self::STATUS_CANCELLED,
        self::STATUS_NEW,
        self::STATUS_RUNNING,
        self::STATUS_DONE,
        self::STATUS_FAILED,
    ];

    public function __construct(
        string $status,
        Customer $customer,
        Contractor $contractor = Null)
    {
        if ( ! in_array($status, self::STATUSES) ) {
            throw new DataDomainException(
                'Task status should be one of the list'
            );
        }

        if ( $contractor && $customer->getId() === $contractor->getId() ) {
            throw new DataDomainException(
                'Contractor cannot be a customer of the same task'
            );
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

    public static function getNextStatus(Action $action): string
    {
        switch (true) {
            case $action instanceof ApplyAction:
                return self::STATUS_RUNNING;

            case $action instanceof CancelAction:
                return self::STATUS_CANCELLED;

            case $action instanceof DoneAction:
                return self::STATUS_DONE;

            case $action instanceof RejectAction:
                return self::STATUS_FAILED;

            default:
                throw new DataDomainException('Unknown action for the task');
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
