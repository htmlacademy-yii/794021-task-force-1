<?php
namespace R794021\Exception;


class DataDomainException extends \DomainException
{
    public function __construct(
        string $message,
        int $code = 0,
        \DomainException $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
