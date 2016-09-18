<?php

namespace DOLucas\Blog\Service;

use DOLucas\Blog\Repository\PostRepository;
use DOLucas\Blog\Factory\PostFactory;
use DOLucas\Blog\Factory\CommentFactory;
use DOLucas\Blog\Document\Post;
use DOLucas\Blog\Validator\PostValidator;
use DOLucas\Blog\Validator\CommentValidator;
use Doctrine\ODM\MongoDB\Cursor;
use InvalidArgumentException as ArgumentException;

/**
 * @author Lucas de Oliveira <contato@deoliveiralucas.net>
 */
class PostService
{

    /**
     * @var PostRepository
     */
    private $repository;

    /**
     * @var PostFactory
     */
    private $postFactory;

    /**
     * @var CommentFactory
     */
    private $commentFactory;

    /**
     * @var PostValidator
     */
    private $postValidator;

    /**
     * @var CommentValidator
     */
    private $commentValidator;

    /**
     * @param PostRepository $postRepository
     * @param PostFactory $postFactory
     * @param CommentFactory $commentFactory
     * @param PostValidator $postValidator
     * @param CommentValidator $commentValidator
     */
    public function __construct(
        PostRepository $postRepository,
        PostFactory $postFactory,
        CommentFactory $commentFactory,
        PostValidator $postValidator,
        CommentValidator $commentValidator
    ) {
        $this->repository = $postRepository;
        $this->postFactory = $postFactory;
        $this->commentFactory = $commentFactory;
        $this->postValidator = $postValidator;
        $this->commentValidator = $commentValidator;
    }

    /**
     * @param array $params
     */
    public function create(array $params)
    {
        try {
            $this->postValidator->validate($params);

            $post = $this->postFactory->create(
                $params['title'],
                $params['body'],
                $params['author']
            );
            
            $this->repository->save($post);

            return [
                'status'  => 'success',
                'message' => 'Post inserido com sucesso'
            ];
        } catch (ArgumentException $e) {
            return [
                'status'  => 'error',
                'message' => $e->getMessage()
            ];
        } catch (Exception $e) {
            return [
                'status'   => 'error',
                'message'  => 'Ocorreu um problema ao inserir novo post',
                'internal' => $e->getMessage()
            ];
        }
    }

    /**
     * @return array
     */
    public function getAll()
    {
        return $this->toArray($this->repository->getAll());
    }

    /**
     * @param string $idPost
     * @return array
     */
    public function getById(string $idPost)
    {
        return $this->toArray($this->repository->getById($idPost));
    }

    /**
     * @param string $idPost
     * @param array $params
     * @return array
     */
    public function addComment(string $idPost, array $params)
    {
        try {
            $this->commentValidator->validate($params);

            $post = $this->repository->getById($idPost);

            $comment = $this->commentFactory->create(
                $params['username'],
                $params['comment']
            );

            $post->addComment($comment);

            $this->repository->save($post);

            return [
                'status'  => 'success',
                'message' => 'Comentário adicionado com sucesso'
            ];
        } catch (ArgumentException $e) {
            return [
                'status'  => 'error',
                'message' => $e->getMessage()
            ];
        } catch (Exception $e) {
            return [
                'status'   => 'error',
                'message'  => 'Ocorreu um problema ao adicionar comentário',
                'internal' => $e->getMessage()
            ];
        }
    }

    /**
     * @param array|Post $posts
     * @return array
     */
    public function toArray($posts) : array
    {
        $arrPost = [];

        if ($posts instanceof Cursor) {
            foreach ($posts as $post) {
                $arrPost[] = $this->postToArray($post);
            }

            return $arrPost;
        }

        if ($posts instanceof Post) {
            return $this->postToArray($posts);
        }

        return $arrPost;
    }

    /**
     * @param Post $post
     * @return array
     */
    protected function postToArray(Post $post) : array
    {
        return [
            'id'        => $post->getId(),
            'title'     => $post->getTitle(),
            'body'      => $post->getBody(),
            'author'    => $post->getAuthor(),
            'createdAt' => $post->getCreatedAt(),
            'comments'  => $this->commentsToArray($post->getComments())
        ];
    }

    /**
     * @param array $comments
     * @return array
     */
    protected function commentsToArray(array $comments) : array
    {
        $arrComments = [];
        foreach ($comments as $comment) {
            $arrComments[] = [
                'id'        => $comment->getId(),
                'username'  => $comment->getUsername(),
                'comment'   => $comment->getComment(),
                'createdAt' => $comment->getCreatedAt()
            ];
        }
        return $arrComments;
    }
}
