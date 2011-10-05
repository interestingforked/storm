<?php

class ProductController extends CrudController {

    public function actionIndex() {
        $data = array();

        $products = Product::model()->findAll();
        foreach ($products AS $product) {
            $categories = array();
            foreach ($product->categories AS $category) {
                $productCategory = array();
                $category->content = Content::model()->getModuleContent('category', $category->id);
                $productCategory[] = $category;
                $parent = $category->getparent;
                if ($parent) {
                    $parent->content = Content::model()->getModuleContent('category', $parent->id);
                    array_unshift($productCategory, $parent);
                }
                $categories[] = $productCategory;
            }
            $productData = array(
                'product' => $product->getProduct(),
                'categories' => $categories,
            );
            $data[] = $productData;
        }
        $this->render('index', array(
            'data' => $data,
        ));
    }

    public function actionNew() {
        $productModel = new Product;
        $contentModel = new Content;
        
        $category = Category::model()->findByPk(1);
        $categories = $category->getOptionList();

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model, 'product');

        $errors = array();
        
        if (isset($_POST['Product'])) {
            $productModel->attributes = $_POST['Product'];
            $contentModel->attributes = $_POST['Content'];

            $postCategories = array();
            foreach ($_POST['Categories'] AS $postCategory) {
                $postCategories[] = (int) trim($postCategory);
            }
            $productModel->setRelationRecords('categories', $postCategories);
            
            $attachments = array();
            foreach ($_POST AS $k => $v) {
                $k = str_replace('qq-upload-handler-iframe', '', $k);
                if (preg_match('/tmpfile([0-9]+)/i', $k)) {
                    $attachments[] = $v;
                }
            }
            $transaction = Yii::app()->db->beginTransaction();
            if ($productModel->save()) {
                $contentModel->module = 'product';
                $contentModel->module_id = $productModel->id;
                if ($contentModel->save()) {
                    $result = Attachment::model()->saveAttachments($attachments, 'product', $productModel->id);
                    if ( ! is_array($result))
                        $transaction->commit();
                        $this->redirect(array('/crud/product'));
                    $errors = $result;
                    $transaction->rollback();
                } else
                    $transaction->rollback();
                    $errors = $contentModel->getErrors();
            } else
                $transaction->rollback();
                $errors = $productModel->getErrors();
        }

        $this->render('new', array(
            'errors' => $errors,
            'categories' => $categories,
            'activeCategories' => null,
            'productModel' => $productModel,
            'contentModel' => $contentModel,
            'attachmentModels' => null,
        ));
    }

    public function actionEdit($id) {
        $productModel = Product::model()->findByPk($id);
        $contentModel = Content::model()->getModuleContent('product', $id);
        $categoryModels = $productModel->categories;

        $attachmentModels = Attachment::model()->getAttachments(array('product','productBig'), $id);
        
        $category = Category::model()->findByPk(1);
        $categories = $category->getOptionList();

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model, 'product');

        $errors = array();
        
        if (isset($_POST['Product'])) {
            $productModel->attributes = $_POST['Product'];
            $contentModel->attributes = $_POST['Content'];

            $postCategories = array();
            foreach ($_POST['Categories'] AS $postCategory) {
                $postCategories[] = (int) trim($postCategory);
            }
            $productModel->setRelationRecords('categories', $postCategories);
            
            $attachments = array();
            foreach ($_POST AS $k => $v) {
                $k = str_replace('qq-upload-handler-iframe', '', $k);
                if (preg_match('/tmpfile([0-9]+)/i', $k)) {
                    $attachments[] = $v;
                }
            }

            if ($productModel->save() AND $contentModel->save()) {
                $result = Attachment::model()->saveAttachments($attachments, 'product', $productModel->id);
                if ( ! is_array($result))
                    $this->redirect(array('/crud/product'));
                $errors = $result;
            } else {
                $errors = array_merge($productModel->getErrors(), $contentModel->getErrors());
            }    
        }

        $this->render('edit', array(
            'errors' => $errors,
            'categories' => $categories,
            'activeCategories' => $categoryModels,
            'productModel' => $productModel,
            'contentModel' => $contentModel,
            'attachmentModels' => $attachmentModels,
        ));
    }

    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            $this->loadModel('Product', $id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
        else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

}