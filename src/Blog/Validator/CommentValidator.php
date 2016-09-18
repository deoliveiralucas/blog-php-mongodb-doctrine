<?php

namespace DOLucas\Blog\Validator;

use InvalidArgumentException as ArgumentException;

/**
 * @author Lucas de Oliveira <contato@deoliveiralucas.net>
 */
class CommentValidator
{

    /**
     * @param array
     * @return bool
     * @throws ArgumentException
     */
    public function validate(array $params) : bool
    {
        if (! isset($params['username']) || trim($params['username']) == '') {
            throw new ArgumentException('O campo "username" é obrigatório');
        }
        if (! isset($params['comment']) || trim($params['comment']) == '') {
            throw new ArgumentException('O campo "comment" é obrigatório');
        }
        return true;
    }
}
