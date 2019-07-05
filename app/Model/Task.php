<?php

namespace App\Model;

class Task
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $text;

    /**
     * @var bool
     */
    private $complete;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * @return bool
     */
    public function isComplete(): bool
    {
        return $this->complete;
    }

    /**
     * @param bool $complete
     */
    public function setComplete($complete)
    {
        $this->complete = $complete;
    }
}
