<?php

namespace nx\Exception;

use Psr\Container\NotFoundExceptionInterface;

class NotFound extends \InvalidArgumentException implements NotFoundExceptionInterface{
}