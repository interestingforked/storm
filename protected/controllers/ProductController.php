<?php

class ProductController extends Controller {

    public function actionIndex($id) {
        $id = explode('/', $id);
        $productId = end($id);
        array_pop($id);
		$categoryId = '/';
        $category = null;
        if (count($id) > 0) {
            $categoryId = implode('/', $id);
            $category = Category::model()->getCategory($categoryId);
            if ($category->parent_id > 1) {
                $parentCategories = array();
                $slugs = explode('/', $categoryId);
                for ($i = 0; $i < (count($slugs) - 1); $i++)
                    $parentCategories[] = Category::model()->getCategory($slugs[$i]);
                foreach ($parentCategories as $parentCategory)
                    $this->breadcrumbs[$parentCategory->content->title] = array('/'.$parentCategory->slug);
            }
            $this->breadcrumbs[$category->content->title] = array('/'.$categoryId);
        }
        $productId = explode('-', $productId);
        $productId = end($productId);
        $productModel = Product::model()->findByPk($productId);
        
        $nodeId = (isset($_GET['node']) AND $_GET['node'] > 0) ? $_GET['node'] : 0;
        $product = $productModel->getProduct($nodeId);
        
        $this->metaTitle = $product->content->meta_title;
        $this->metaDescription = $product->content->meta_description;
        $this->metaKeywords = $product->content->meta_keywords;
        
        $this->breadcrumbs[] = $product->content->title;
        $this->render('index', array(
            'category' => $category,
            'categoryLink' => $categoryId,
            'product' => $product,
        ));
    }
    
    public function actionNotify() {
        if ($_POST) {
            if (Notifying::model()->checkNotify($_POST) == 0) {
                $notify = new Notifying();
                $notify->product_id = $_POST['productId'];
                $notify->product_node_id = $_POST['productNodeId'];
                $notify->email = $_POST['email'];
                $notify->save();
            }
            Yii::app()->controller->redirect($_POST['returnUrl']);
        } else {
            Yii::app()->controller->redirect('/');
        }
    }

}