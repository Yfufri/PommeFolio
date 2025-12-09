<?php

class ErrorController extends BaseController
{
    public function notFound(): void
    {
        http_response_code(404);
        $this->render('error');
    }
}
