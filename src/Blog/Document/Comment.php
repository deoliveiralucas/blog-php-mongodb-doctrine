<?php

namespace DOLucas\Blog\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use DateTime;

/**
 * @ODM\Document(collection="comments")
 */
class Comment
{

    /**
     * @ODM\Id
     */
    private $id;

    /**
     * @ODM\Field(type="string")
     */
    private $username;

    /**
     * @ODM\Field(type="string")
     */
    private $comment;

    /**
     * @ODM\Field(type="date")
     */
    private $createdAt;

    /**
     * @param string $username
     * @param string $comment
     */
    public function __construct($username, $comment)
    {
        $this->setUsername($username);
        $this->setComment($comment);
        $this->setCreatedAt(new DateTime());
    }

    /**
     * @return string
     */
    public function getId() : string
    {
        return $this->id;
    }

    /**
     * @param string $username
     */
    private function setUsername(string $username)
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getUsername() : string
    {
        return $this->username;
    }

    /**
     * @param string $comment
     */
    private function setComment(string $comment)
    {
        $this->comment = $comment;
    }

    /**
     * @return string
     */
    public function getComment() : string
    {
        return $this->comment;
    }

    /**
     * @param DateTime
     */
    private function setCreatedAt(DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt() : DateTime
    {
        return $this->createdAt;
    }
}
