<?php
require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../models/Culture.php';
class CultureController extends BaseController
{
    private Culture $cultureModel;

    public function __construct()
    {
        $this->cultureModel = new Culture();
    }

    public function index()
    {
        $itemsCulture = $this->cultureModel->findAll();

        $this->render('culture', [
            'itemsCulture' => $itemsCulture,
        ]);
    }
}
