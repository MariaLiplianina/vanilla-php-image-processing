<?php

declare(strict_types=1);

namespace App\Modules\Image\UI\API\Controller;

class BaseController
{
    public function jsonError(string $message): string
    {
        $errors['message'] = $message;

        return json_encode($errors);
    }
}
