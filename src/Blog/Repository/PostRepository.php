<?php

namespace DOLucas\Blog\Repository;

use DOLucas\Blog\Document\Post;
use Doctrine\ODM\MongoDB\DocumentManager;

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
    public function save(Post $post)
    {
        $this->dm->persist($post);
        $this->dm->flush();
    }

    /**
     * @return array
     */
    public function getAll()
    {
        return $this
            ->queryBuilder
            ->sort('createdAt', 'desc')
            ->getQuery()
            ->execute();
    }

    /**
     * @param string $id
     * @return array
     */
    public function getById(string $id)
    {
        return $this
            ->queryBuilder
            ->field('_id')->equals($id)
            ->getQuery()
            ->getSingleResult();
    }
}
