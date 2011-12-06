<?php

class ProductController extends AdminController {

    public function actionIndex($id = null) {
        $this->pageTitle = 'Products';

        $criteria = new CDbCriteria();
        /*

        $model = 'Product';
        if ($category != null) {
            $model = 'Category';
            $criteria->distinct = true;
            $criteria->with = 'products';
            $criteria->condition = 'category_id = '.$id;
        }
        $count = $model::model()->count($criteria);
        $pagination = new CPagination($count);
        
        $pagination->pageSize = 10;
        $pagination->applyLimit($criteria);
        
        $model = 'Category';
        $criteria->distinct = true;
        $criteria->with = 'products';
        $criteria->condition = 'category_id = '.$category;
        $products = $model::model()->findAll($criteria);

        */
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
                foreach ($_POST AS $k => $v) {
                    $k = str_replace('qq-upload-handler-iframe', '', $k);
                    if (preg_match('/tmpfile([0-9]+)/i', $k)) {
                        $attachments[] = $v;
                    }
                }
                
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

        $this->render('add', array(
            'errors' => $errors,
            'model' => $model,
            'contentModel' => $contentModel,
        ));
    }
    
    public function actionAddNode($id) {
        $this->pageTitle = 'Products / Nodes / Add product node';

        $errors = array();

        $model = new ProductNode;
        $product = Product::model()->findByPk($id);
        
        $colors = $this->classifier->getGroup('color');
        $sizes = $this->classifier->getGroup('size');

        if (isset($_POST['ProductNode'])) {
            $model->attributes = $_POST['ProductNode'];
            $model->product_id = $id;
            
            $attachments = array();
            foreach ($_POST AS $k => $v) {
                $k = str_replace('qq-upload-handler-iframe', '', $k);
                if (preg_match('/tmpfile([0-9]+)/i', $k)) {
                    $attachments[] = $v;
                }
            }

            $transaction = Yii::app()->db->beginTransaction();
            if ($model->save()) {
                $result = Attachment::model()->saveAttachments($attachments, 'productNode', $model->id, $product->slug);
                if (!is_array($result)) {
                    $transaction->commit();
                    $this->redirect(array('/admin/product/nodes/'.$id));
                }
            } else {
                $transaction->rollback();
                $errors = $model->getErrors();
            }
        }

        $this->render('add_node', array(
            'errors' => $errors,
            'model' => $model,
            'colors' => $colors,
            'sizes' => $sizes,
        ));
    }

    public function actionEdit($id) {
        $this->pageTitle = 'Products / Edit product';

        $errors = array();

        $model = Product::model()->findByPk($id);
        $contentModel = Content::model()->getModuleContent('product', $id);
        
        $attachmentModels = Attachment::model()->getAttachments('productBig', $id);

        if (isset($_POST['Product'])) {
            $model->attributes = $_POST['Product'];
            $contentModel->attributes = $_POST['Content'];

            $attachments = array();
            foreach ($_POST AS $k => $v) {
                $k = str_replace('qq-upload-handler-iframe', '', $k);
                if (preg_match('/tmpfile([0-9]+)/i', $k)) {
                    $attachments[] = $v;
                }
            }
            
            $transaction = Yii::app()->db->beginTransaction();
            if ($model->save()) {

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
            'attachmentModels' => $attachmentModels,
        ));
    }
    
    public function actionEditNode($id) {
        $this->pageTitle = 'Products / Nodes / Edit product node';

        $errors = array();

        $model = ProductNode::model()->findByPk($id);
        $product = $model->product;
        
        $colors = $this->classifier->getGroup('color');
        $sizes = $this->classifier->getGroup('size');
        
        $attachmentModels = Attachment::model()->getAttachments('productNode', $id);
        
        if (isset($_POST['ProductNode'])) {
            $model->attributes = $_POST['ProductNode'];
            
            $attachments = array();
            foreach ($_POST AS $k => $v) {
                $k = str_replace('qq-upload-handler-iframe', '', $k);
                if (preg_match('/tmpfile([0-9]+)/i', $k)) {
                    $attachments[] = $v;
                }
            }

            $transaction = Yii::app()->db->beginTransaction();
            if ($model->save()) {
                $result = Attachment::model()->saveAttachments($attachments, 'productNode', $model->id, $product->slug);
                if (!is_array($result)) {
                    $transaction->commit();
                    $this->redirect(array('/admin/product/nodes/'.$product->id));
                }
            } else {
                $transaction->rollback();
                $errors = $model->getErrors();
            }
        }

        $this->render('edit_node', array(
            'errors' => $errors,
            'model' => $model,
            'attachmentModels' => $attachmentModels,
            'colors' => $colors,
            'sizes' => $sizes,
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
    
    public function actionMoveNU($id) {
        $model = ProductNode::model()->findByPk($id);
        $sort = $model->sort;
        if ($sort > 1) {
            $upperModel = ProductNode::model()->findBySql(
                "SELECT * FROM product_nodes WHERE product_id = :product_id AND sort < :sort", 
                    array(':product_id' => $model->product_id, ':sort' => $sort)
            );
            if ($upperModel) {
                $model->sort = $upperModel->sort;
                $model->save();
                $upperModel->sort = $sort;
                $upperModel->save();
            }
        }
        $this->redirect(array('/admin/product/nodes/'.$model->product_id));
    }

    public function actionMovePD($id) {
        $model = Product::model()->findByPk($id);
        $sort = $model->sort;
        $maxModel = Product::model()->findBySql("SELECT MAX(sort) as sort FROM products");
        if ($sort < $maxModel->sort) {
            $upperModel = Product::model()->findBySql(
                "SELECT * FROM product_nodes WHERE sort > :sort", array(':sort' => $sort)
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
    
    public function actionMoveND($id) {
        $model = ProductNode::model()->findByPk($id);
        $sort = $model->sort;
        $maxModel = ProductNode::model()->findBySql("SELECT MAX(sort) as sort FROM product_nodes WHERE product_id = :product_id",
                array(':product_id' => $model->product_id));
        if ($sort < $maxModel->sort) {
            $upperModel = ProductNode::model()->findBySql(
                "SELECT * FROM product_nodes WHERE product_id = :product_id AND sort > :sort", 
                    array(':product_id' => $model->product_id, ':sort' => $sort)
            );
            if ($upperModel) {
                $model->sort = $upperModel->sort;
                $model->save();
                $upperModel->sort = $sort;
                $upperModel->save();
            }
        }
        $this->redirect(array('/admin/product/nodes/'.$model->product_id));
    }

    public function actionDelete($id) {
        $model = Product::model()->findByPk($id);
        $model->deleted = 1;
        $model->save();

        $this->redirect(array('/admin/product'));
    }
    
    public function actionDeleteNode($id) {
        $model = ProductNode::model()->findByPk($id);
        $model->deleted = 1;
        $model->save();

        $this->redirect(array('/admin/product/nodes/'.$model->product_id));
    }

}
