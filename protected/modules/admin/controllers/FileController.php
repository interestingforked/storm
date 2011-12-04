<?php

class FileController extends AdminController {

    public function actionIndex() {
        $this->pageTitle = 'Files';
        $this->render('index');
    }

}
