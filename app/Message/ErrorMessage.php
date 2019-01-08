<?php


namespace App\Message;


class ErrorMessage extends Message
{
    private const TYPE = 'error';

    public function __construct(string $message)
    {
        parent::__construct(self::TYPE, ['message' => $message]);
    }
}