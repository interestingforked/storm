<?php

class ProductController extends AdminController {

    public function actionIndex($id = null) {
        $this->pageTitle = 'Products';
        
        $session = new CHttpSession();
        $session->open();
        
        $connection = Yii::app()->db;
        if ($id != null) {
            $sql = "SELECT DISTINCT p.id as p_id, p.active as p_active, p.slug as p_slug, p.sort as p_sort, p.created as p_created, "
                ."cp.title as p_title, c.id as c_id, c.slug as c_slug, c.sort as c_sort, cc.title as c_title "
                ."FROM products p LEFT JOIN contents cp ON cp.module = 'product' AND cp.module_id = p.id AND cp.language = 'ru' "
                ."LEFT OUTER JOIN product_category pc ON p.id = pc.product_id LEFT OUTER JOIN categories c ON c.id = pc.category_id "
                ."LEFT JOIN contents cc ON cc.module = 'category' AND cc.module_id = c.id AND cc.language = 'ru' "
                ."WHERE c.id = {$id} AND p.deleted = 0 ORDER BY p.sort";

            $session->add('lastViewedCategory', $id);
        } else {
            $sql = "SELECT DISTINCT p.id as p_id, p.active as p_active, p.slug as p_slug, p.sort as p_sort, p.created as p_created, cp.title as p_title "
                ."FROM products p LEFT JOIN contents cp ON cp.module = 'product' AND cp.module_id = p.id AND cp.language = 'ru' "
                ."WHERE p.deleted = 0 ORDER BY p.sort";
            
            $session->remove('lastViewedCategory');
        }
        $command = $connection->createCommand($sql);
        $dataReader = $command->query();
        
        $products = $dataReader->readAll();
        
        $this->render('index', array(
            'products' => $products,
            'categoryId' => $id,
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
		
		$session = new CHttpSession();
        $session->open();
		$categoryId = $session->get('lastViewedCategory');

        $this->render('index_nodes', array(
            'productId' => $id,
            'products' => $products,
            'pagination' => $pagination,
			'categoryId' => $categoryId,
        ));
    }

    public function actionAdd() {
        $this->pageTitle = 'Products / Add product';

        $errors = array();

        $model = new Product;
        $contentModel = new Content;
        
        $rootCategory = Category::model()->findByPk(1);
        $categories = $rootCategory->getOptionList();
        
        $activeCategories = array();

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
            
            $postCategories = array();
            foreach ($_POST['SelectedCategories'] AS $postCategory) {
                $postCategories[] = (int) trim($postCategory);
            }
            $model->setRelationRecords('categories', $postCategories);
            
            if ($model->save()) {
                $contentModel->module = 'product';
                $contentModel->module_id = $model->id;
                $contentModel->language = Yii::app()->params['defaultLanguage'];

                if ($contentModel->save()) {
                    $result = Attachment::model()->saveAttachments($attachments, 'productBig', $model->id, $model->slug);
                    if (!is_array($result)) {
                        $transaction->commit();
                        
                        $session = new CHttpSession();
                        $session->open();
                        $lastViewedCategory = $session->get('lastViewedCategory', '');
                        if ($lastViewedCategory != '') {
                            $lastViewedCategory = '/index/'.$lastViewedCategory;
                        }
                        $this->redirect(array('/admin/product'.$lastViewedCategory));
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
            'categories' => $categories,
            'activeCategories' => $activeCategories,
        ));
    }
    
    public function actionAddNode($id) {
        $this->pageTitle = 'Products / Nodes / Add product node';

        $errors = array();

        $model = new ProductNode;
        $product = Product::model()->findByPk($id);
        
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

        if (isset($_POST['ProductNode'])) {
			if ($_POST['ProductNode']['price'] == 0) {
				$_POST['ProductNode']['price'] = null;
			}
            $model->attributes = $_POST['ProductNode'];
            $model->product_id = $id;

            $attachments = array();
            foreach ($_POST AS $k => $v) {
                $k = str_replace('qq-upload-handler-iframe', '', $k);
                if (preg_match('/tmpfile([0-9]+)/i', $k)) {
                    $attachments[] = $v;
                }
            }
            
            if ( ! $nodes) {
                $model->main = 1;
            }

            $transaction = Yii::app()->db->beginTransaction();
            if ($model->save()) {
                $result = Attachment::model()->saveAttachments($attachments, 'productNode', $model->id, $product->slug);
                if (!is_array($result)) {
                    if (isset($_POST['attachments'])) {
                        foreach ($_POST['attachments'] AS $postAttachment) {
                            $attachmentModel = Attachment::model()->findByPk($postAttachment);
                            $attachmentModel->id = null;
                            $attachmentModel->isNewRecord = true;
                            $attachmentModel->module_id = $model->id;
                            $attachmentModel->save();
                        }
                    }
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
            'productAttachments' => $productAttachments,
        ));
    }

    public function actionEdit($id) {
        $this->pageTitle = 'Products / Edit product';

        $errors = array();

        $model = Product::model()->findByPk($id);
        $contentModel = Content::model()->getModuleContent('product', $id);
        
        $rootCategory = Category::model()->findByPk(1);
        $categories = $rootCategory->getOptionList();
        $selectedCategories = array();
        foreach ($model->categories AS $selectedCategory) {
            $selectedCategories[] = $selectedCategory->id . ' ';
        }
        $activeCategories = array();
        foreach ($categories AS $key => $value) {
            if (in_array($key, $selectedCategories)) {
                $activeCategories[$key] = $value;
                unset($categories[$key]);
            }
        }
        
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
            
            $postCategories = array();
            foreach ($_POST['SelectedCategories'] AS $postCategory) {
                $postCategories[] = (int) trim($postCategory);
            }
            $model->setRelationRecords('categories', $postCategories);
            
            if ($model->save()) {

                if ($contentModel->save()) {
                    $result = Attachment::model()->saveAttachments($attachments, 'productBig', $model->id, $model->slug);
                    if (!is_array($result)) {
                        $transaction->commit();
                        
                        $session = new CHttpSession();
                        $session->open();
                        $lastViewedCategory = $session->get('lastViewedCategory', '');
                        if ($lastViewedCategory != '') {
                            $lastViewedCategory = '/index/'.$lastViewedCategory;
                        }
                        $this->redirect(array('/admin/product'.$lastViewedCategory));
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
            'categories' => $categories,
            'activeCategories' => $activeCategories,
        ));
    }
    
    public function actionEditNode($id) {
        $this->pageTitle = 'Products / Nodes / Edit product node';

        $errors = array();

        $model = ProductNode::model()->findByPk($id);
        $product = $model->product;
        
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
        
        $attachmentModels = Attachment::model()->getAttachments('productNode', $id);
        
        if (isset($_POST['ProductNode'])) {
			if ($_POST['ProductNode']['price'] == 0) {
				$_POST['ProductNode']['price'] = null;
			}
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
                    if (isset($_POST['attachments'])) {
                        foreach ($_POST['attachments'] AS $postAttachment) {
                            $attachmentModel = Attachment::model()->findByPk($postAttachment);
                            $attachmentModel->id = null;
                            $attachmentModel->isNewRecord = true;
                            $attachmentModel->module_id = $model->id;
                            $attachmentModel->save();
                        }
                    }
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
            'productAttachments' => $productAttachments,
        ));
    }

    public function actionMovePU($id) {
        $categoryId = Yii::app()->getRequest()->getParam('category_id');
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
        $this->redirect(array('/admin/product/index/'.$categoryId));
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
                if ($model->sort == 1) {
                    $model->main = 1;
                    $model->save();
                    
                    $upperModel->main = 0;
                    $upperModel->save();
                }
            }
        }
        $this->redirect(array('/admin/product/nodes/'.$model->product_id));
    }

    public function actionMovePD($id) {
        $categoryId = Yii::app()->getRequest()->getParam('category_id');
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
        $this->redirect(array('/admin/product/index/'.$categoryId));
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
                if ($upperModel->sort == 1) {
                    $upperModel->main = 1;
                    $upperModel->save();
                    
                    $model->main = 0;
                    $model->save();
                }
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
