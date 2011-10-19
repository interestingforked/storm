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
		
		$productAttachments = array();
		$nodes = ProductNode::model()->findAllByAttributes(array('product_id' => $id));
		if ($nodes) {
			foreach ($nodes AS $node) {
				$nodeAttachments = Attachment::model()->getAttachments('productNode', $node->id);
				if ($nodeAttachments) {
					$productAttachments = array_merge($productAttachments, $nodeAttachments);
				}
			}
		}
		
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
                            ), "product_id = {$model->product_id} AND main = 1 AND id != {$model->id}");
                }
				
				if (isset($_POST['attachments'])) {
					foreach ($_POST['attachments'] AS $postAttachment) {
						$attachmentModel = Attachment::model()->findByPk($postAttachment);
						$attachmentModel->id = null;
						$attachmentModel->isNewRecord = true;
						$attachmentModel->module_id = $model->id;
						$attachmentModel->save();
					}
				}

                $productModel = Product::model()->findByPk($model->product_id);
                $result = Attachment::model()->saveAttachments($attachments, 'productNode', $model->id, $productModel->slug);
                if (!is_array($result))
                    $this->redirect(array('/crud/productnode/index/' . $model->product_id));
                $errors = $result;
            }
        }

        $this->render('new', array(
            'model' => $model,
            'errors' => $errors,
            'colors' => $colors,
            'sizes' => $sizes,
			'productAttachments' => $productAttachments,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionEdit($id) {
        $model = ProductNode::model()->findByPk($id);

		$productAttachments = array();
		$nodes = ProductNode::model()->findAllByAttributes(array('product_id' => $model->product_id));
		if ($nodes) {
			foreach ($nodes AS $node) {
				$nodeAttachments = Attachment::model()->getAttachments('productNode', $node->id);
				if ($nodeAttachments) {
					$productAttachments = array_merge($productAttachments, $nodeAttachments);
				}
			}
		}
		
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

				if (isset($_POST['attachments'])) {
					foreach ($_POST['attachments'] AS $postAttachment) {
						$attachmentModel = Attachment::model()->findByPk($postAttachment);
						$attachmentModel->id = null;
						$attachmentModel->isNewRecord = true;
						$attachmentModel->module_id = $model->id;
						$attachmentModel->save();
					}
				}
				
                $productModel = Product::model()->findByPk($model->product_id);
                $result = Attachment::model()->saveAttachments($attachments, 'productNode', $model->id, $productModel->slug);		
                if (!is_array($result))
                    $this->redirect(array('/crud/productnode/index/' . $model->product_id));
                $errors = $result;
            }
        }

        $this->render('edit', array(
            'model' => $model,
            'errors' => $errors,
            'colors' => $colors,
            'sizes' => $sizes,
            'attachments' => $nodeAttachments,
			'productAttachments' => $productAttachments,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $model = ProductNode::model()->findByPk($id);
        $model->deleted = 1;
        $model->save();
        $this->redirect(array('/crud/productnode/index/' . $model->product_id));
    }

}
