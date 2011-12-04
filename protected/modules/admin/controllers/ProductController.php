<?php

class ProductController extends AdminController {

    public function actionIndex($category = null) {
        $this->pageTitle = 'Products';

        $criteria = new CDbCriteria();
        $count = Product::model()->count($criteria);
        $pagination = new CPagination($count);

        $pagination->pageSize = 10;
        $pagination->applyLimit($criteria);
        
        $products = Product::model()->findAll($criteria);

        $this->render('index', array(
            'products' => $products,
            'pagination' => $pagination
        ));
    }
    
    public function actionNodes($id) {
        $this->pageTitle = 'Product nodes';

        $criteria = new CDbCriteria();
        $criteria->addCondition("product_id = {$id}");
        
        $count = ProductNode::model()->count($criteria);
        $pagination = new CPagination($count);

        $pagination->pageSize = 10;
        $pagination->applyLimit($criteria);
        
        $products = ProductNode::model()->findAll($criteria);

        $this->render('index_nodes', array(
            'productId' => $id,
            'products' => $products,
            'pagination' => $pagination
        ));
    }

    public function actionAdd() {
        $this->pageTitle = 'Products / Add product';

        $errors = array();

        $model = new Product;
        $contentModel = new Content;

        if (isset($_POST['Product'])) {
            $model->attributes = $_POST['Product'];
            $contentModel->attributes = $_POST['Content'];

            $transaction = Yii::app()->db->beginTransaction();
            if ($model->save()) {
                $contentModel->module = 'product';
                $contentModel->module_id = $model->id;
                $contentModel->language = Yii::app()->params['defaultLanguage'];

                $attachments = array();
                $attachments[] = $_POST['productBig'];
                
                if ($contentModel->save()) {
                    $result = Attachment::model()->saveAttachments($attachments, 'productBig', $model->id, $model->slug);
                    if (!is_array($result)) {
                        $transaction->commit();
                        $this->redirect(array('/admin/article'));
                    }
                    $errors = $result;
                    $transaction->rollback();
                } else {
                    $transaction->rollback();
                    $errors = $contentModel->getErrors();
                }
            } else {
                $transaction->rollback();
                $errors = $model->getErrors();
            }
        }

        $this->render('add', array(
            'errors' => $errors,
            'model' => $model,
            'contentModel' => $contentModel,
        ));
    }

    public function actionEdit($id) {
        $this->pageTitle = 'Products / Edit product';

        $errors = array();

        $model = Product::model()->findByPk($id);
        $contentModel = Content::model()->getModuleContent('product', $id);

        if (isset($_POST['Product'])) {
            $model->attributes = $_POST['Product'];
            $contentModel->attributes = $_POST['Content'];

            $transaction = Yii::app()->db->beginTransaction();
            if ($model->save()) {
                
                $attachments = array();
                $attachments[] = $_POST['productBig'];
                
                if ($contentModel->save()) {
                    $result = Attachment::model()->saveAttachments($attachments, 'productBig', $model->id, $model->slug);
                    if (!is_array($result)) {
                        $transaction->commit();
                        $this->redirect(array('/admin/product'));
                    }
                    $errors = $result;
                    $transaction->rollback();
                } else {
                    $transaction->rollback();
                    $errors = $contentModel->getErrors();
                }
            } else {
                $transaction->rollback();
                $errors = $model->getErrors();
            }
        }

        $this->render('edit', array(
            'errors' => $errors,
            'model' => $model,
            'contentModel' => $contentModel,
            'title' => $contentModel->title,
        ));
    }

    public function actionMovePU($id) {
        $model = Product::model()->findByPk($id);
        $sort = $model->sort;
        if ($sort > 1) {
            $upperModel = Product::model()->findBySql(
                "SELECT * FROM products WHERE sort < :sort", array(':sort' => $sort)
            );
            if ($upperModel) {
                $model->sort = $upperModel->sort;
                $model->save();
                $upperModel->sort = $sort;
                $upperModel->save();
            }
        }
        $this->redirect(array('/admin/product'));
    }

    public function actionMovePD($id) {
        $model = Product::model()->findByPk($id);
        $sort = $model->sort;
        $maxModel = Product::model()->findBySql("SELECT MAX(sort) as sort FROM products");
        if ($sort < $maxModel->sort) {
            $upperModel = Product::model()->findBySql(
                "SELECT * FROM products WHERE sort > :sort", array(':sort' => $sort)
            );
            if ($upperModel) {
                $model->sort = $upperModel->sort;
                $model->save();
                $upperModel->sort = $sort;
                $upperModel->save();
            }
        }
        $this->redirect(array('/admin/product'));
    }

    public function actionDelete($id) {
        $model = Product::model()->findByPk($id);
        $model->deleted = 1;
        $model->save();

        $this->redirect(array('/admin/product'));
    }

}
