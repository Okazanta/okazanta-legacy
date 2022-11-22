<?php

/*
 * This file is part of Cachet.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CachetHQ\Cachet\Exceptions\Displayers;

use AltThree\Validator\ValidationException;
use Throwable;
use GrahamCampbell\Exceptions\Displayer\AbstractJsonDisplayer;
use Symfony\Component\HttpFoundation\JsonResponse;

class JsonValidationDisplayer extends AbstractJsonDisplayer
{    
    public function contentType()
    {
        return 'application/json';
    }
    
    public function display(Throwable $exception, string $id, int $code, array $headers)
    {
        $info = $this->info->generate($exception, $id, 400);

        $error = ['id' => $id, 'status' => $info['code'], 'title' => $info['name'], 'detail' => $info['detail'], 'meta' => ['details' => $exception->getMessageBag()->all()]];

        return new JsonResponse(['errors' => [$error]], 400, array_merge($headers, ['Content-Type' => $this->contentType()]));
    }

    public function canDisplay(Throwable $original, Throwable $transformed, int $code)
    {
        return $transformed instanceof ValidationException;
    }
}
