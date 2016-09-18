<?php

namespace DOLucas\Blog\Validator;

use InvalidArgumentException as ArgumentException;

/**
 * @author Lucas de Oliveira <contato@deoliveiralucas.net>
 */
class PostValidator
{

    /**
     * @param array
     * @return bool
     * @throws ArgumentException
     */
    public function validate(array $params) : bool
    {
        if (! isset($params['title']) || trim($params['title']) == '') {
            throw new ArgumentException('O campo "title" é obrigatório');
        }
        if (! isset($params['body']) || trim($params['body']) == '') {
            throw new ArgumentException('O campo "body" é obrigatório');
        }
        if (! isset($params['author']) || trim($params['author']) == '') {
            throw new ArgumentException('O campo "author" é obrigatório');
        }
        return true;
    }
}
