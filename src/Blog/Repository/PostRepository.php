<?php

namespace DOLucas\Blog\Repository;

use DOLucas\Blog\Document\Post;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Cursor;

/**
 * @author Lucas de Oliveira <contato@deoliveiralucas.net>
 */
class PostRepository
{

    /**
     * @var DocumentManager
     */
    private $dm;

    /**
     * @var \Doctrine\Common\Persistence\ObjectRepository
     */
    private $queryBuilder;

    /**
     * @param DocumentManager $dm
     */
    public function __construct(DocumentManager $dm)
    {
        $this->dm = $dm;
        $this->queryBuilder = $dm->createQueryBuilder(Post::class);
    }

    /**
     * @param Post $post
     */
    public function save(Post $post) : void
    {
        $this->dm->persist($post);
        $this->dm->flush();
    }

    /**
     * @return Cursor
     */
    public function getAll() : Cursor
    {
        return $this
            ->queryBuilder
            ->sort('createdAt', 'desc')
            ->getQuery()
            ->execute();
    }

    /**
     * @param string $id
     * @return Post
     */
    public function getById(string $id) : Post
    {
        return $this
            ->queryBuilder
            ->field('_id')->equals($id)
            ->getQuery()
            ->getSingleResult();
    }
}
