<?php

namespace DOLucas\Blog\Factory;

use DOLucas\Blog\Document\Comment;
use DateTime;

/**
 * @author Lucas de Oliveira <contato@deoliveiralucas.net>
 */
class CommentFactory
{

    /**
     * @param string $username
     * @param string $text
     */
    public function create($username, $text)
    {
        $comment = new Comment($username, $text);
        return $comment;
    }
}
