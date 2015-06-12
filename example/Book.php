<?php

use Crisu83\Overseer\Entity\Resource;

class Book implements Resource
{

    /**
     * @var int
     */
    private $authorId;


    /**
     * Book constructor.
     *
     * @param int $authorId
     */
    public function __construct($authorId)
    {
        $this->authorId = (string) $authorId;
    }


    /**
     * @return string
     */
    public function getResourceName()
    {
        return 'book';
    }


    /**
     * @inheritdoc
     */
    public function getAuthorId()
    {
        return $this->authorId;
    }
}
