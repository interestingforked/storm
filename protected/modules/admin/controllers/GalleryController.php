<?php

class GalleryController extends AdminController {

    public function actionIndex() {
        $this->pageTitle = 'Gallery';

        $criteria = new CDbCriteria();
        $galleries = Gallery::model()->sorted2()->findAll($criteria);

        $this->render('index', array(
            'galleries' => $galleries,
        ));
    }

    public function actionDelete($id) {
        $model = Gallery::model()->findByPk($id);
        $model->deleted = 1;
        $model->save();

        $this->redirect(array('/admin/gallery'));
    }

}
