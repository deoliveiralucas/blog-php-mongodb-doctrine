<?php

namespace DOLucas\Blog\Factory;

use DOLucas\Blog\Document\Post;
use DateTime;

/**
 * @author Lucas de Oliveira <contato@deoliveiralucas.net>
 */
class PostFactory
{

    /**
     * @param string $title
     * @param string $body
     */
    public function create($title, $body, $author)
    {
        $post = new Post($title, $body, $author);
        return $post;
    }
}
