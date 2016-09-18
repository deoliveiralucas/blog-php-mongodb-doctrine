<?php

namespace DOLucas\Blog\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use DateTime;

/**
 * @ODM\Document(collection="posts")
 */
class Post
{

    /**
     * @ODM\Id
     */
    private $id;

    /**
     * @ODM\Field(type="string")
     */
    private $title;

    /**
     * @ODM\Field(type="string")
     */
    private $body;

    /**
     * @ODM\Field(type="string")
     */
    private $author;

    /**
     * @ODM\ReferenceMany(
     *    strategy="set",
     *    targetDocument="Comment",
     *    cascade="all",
     *    sort={"createdAt": "desc"}
     * )
     */
    private $comments = [];

    /**
     * @ODM\Field(type="date")
     */
    private $createdAt;

    /**
     * @param string $title
     * @param string $body
     * @param string $author
     */
    public function __construct(string $title, string $body, string $author)
    {
        $this->setTitle($title);
        $this->setBody($body);
        $this->setAuthor($author);
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
     * @param string $title
     */
    private function setTitle(string $title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getTitle() : string
    {
        return $this->title;
    }

    /**
     * @param string $body
     */
    private function setBody(string $body)
    {
        $this->body = $body;
    }

    /**
     * @return string
     */
    public function getBody() : string
    {
        return $this->body;
    }

    /**
     * @param string $author
     */
    private function setAuthor(string $author)
    {
        $this->author = $author;
    }

    /**
     * @return string
     */
    public function getAuthor() : string
    {
        return $this->author;
    }

    /**
     * @param Comment $comment
     */
    public function addComment(Comment $comment)
    {
        $this->comments[] = $comment;
    }

    /**
     * @return array
     */
    public function getComments() : array
    {
        return $this->comments->toArray();
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
