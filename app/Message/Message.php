<?php


namespace App\Message;


class Message
{
    protected $type;
    protected $data;

    protected static $requiredFields = ['type', 'data'];

    public function __construct($type, $data)
    {
        $this->type = $type;
        $this->data = $data;
    }

    /**
     * @param string $json
     * @return Message
     * @throws \InvalidArgumentException
     */
    public static function fromJson(string $json) : Message
    {
        $decoded = json_decode($json, true);
        if ($decoded === null) {
            throw new \InvalidArgumentException('Invalid incoming message json');
        }

        // проверить наличие обязательных полей в сообщении: type и data
        foreach (self::$requiredFields as $field) {
            if (!array_key_exists($field, $decoded)) {
                throw new \InvalidArgumentException("Missing required message field '{$field}'");
            }
        }

        return new self($decoded['type'], $decoded['data']);
    }

    public function getType()
    {
        return $this->type;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    public function __toString()
    {
        return (string) json_encode([
            'type' => $this->type,
            'data' => $this->data,
        ]);
    }
}