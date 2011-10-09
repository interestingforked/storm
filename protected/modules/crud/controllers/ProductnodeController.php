<?php

class ProductnodeController extends CrudController {

    public function actionIndex($id = 0) {
        $data = array();

        $product = null;
        if ($id > 0) {
            $productModel = Product::model()->findbyPk($id);
            $products = $productModel->productNodes;
        } else {
            $products = ProductNode::model()->findAll();
        }
        foreach ($products AS $productNode) {
            $data[] = $productNode;
        }
        $this->render('index', array(
            'data' => $data,
            'id' => $id
        ));
    }

    public function actionNew($id) {
        $model = new ProductNode();
 
        $colors = $this->classifier->getGroup('color');
        $sizes = $this->classifier->getGroup('size');

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        
        $errors = array();

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
            
            if ($model->save()) {
                
                if ($model->main == 1) {
                    ProductNode::model()->updateAll(array(
                        'main' => 0
                    ), "product_id = {$model->product_id} AND main = 1");
                }
                
                $result = Attachment::model()->saveAttachments($attachments, 'productNode', $model->id);
                if ( ! is_array($result))
                    $this->redirect(array('/crud/productnode/index/'.$model->product_id));
                $errors = $result;
            }
        }

        $this->render('new', array(
            'model' => $model,
            'errors' => $errors,
            'colors' => $colors,
            'sizes' => $sizes,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionEdit($id) {
        $model = ProductNode::model()->findByPk($id);
        
        $nodeAttachments = Attachment::model()->getAttachments('productNode', $id);
        
        $colors = $this->classifier->getGroup('color');
        $sizes = $this->classifier->getGroup('size');

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        
        $errors = array();

        if (isset($_POST['ProductNode'])) {
            $model->attributes = $_POST['ProductNode'];
            
            $attachments = array();
            foreach ($_POST AS $k => $v) {
                $k = str_replace('qq-upload-handler-iframe', '', $k);
                if (preg_match('/tmpfile([0-9]+)/i', $k)) {
                    $attachments[] = $v;
                }
            }
            
            if ($model->save()) {
                
                if ($model->main == 1) {
                    ProductNode::model()->updateAll(array(
                        'main' => 0
                    ), "product_id = {$model->product_id} AND main = 1 AND id != {$model->id}");
                }
                
                $result = Attachment::model()->saveAttachments($attachments, 'productNode', $model->id);
                if ( ! is_array($result))
                    $this->redirect(array('/crud/productnode/index/'.$model->product_id));
                $errors = $result;
            }
        }

        $this->render('edit', array(
            'model' => $model,
            'errors' => $errors,
            'colors' => $colors,
            'sizes' => $sizes,
            'attachments' => $nodeAttachments
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            $this->loadModel($id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
        else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

}
