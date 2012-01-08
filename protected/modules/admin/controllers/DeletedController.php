<?php

class DeletedController extends AdminController {

    public function actionIndex() {
        $this->pageTitle = 'Deleted items';

        $connection = Yii::app()->db;
        
        // Products
        $sql = "SELECT DISTINCT p.id as p_id, p.slug as p_slug, p.created as p_created, cp.title as p_title "
            ."FROM products p LEFT JOIN contents cp ON cp.module = 'product' AND cp.module_id = p.id AND cp.language = 'ru' "
            ."WHERE p.deleted = 1 ORDER BY p.created";
        $command = $connection->createCommand($sql);
        $dataReader = $command->query();
        $products = $dataReader->readAll();
        
        // Product Nodes
        $sql = "SELECT DISTINCT pn.id as p_id, p.slug as p_slug, pn.created as p_created, cp.title as p_title "
            ."FROM product_nodes pn LEFT JOIN products p ON p.id = pn.product_id "
            ."LEFT JOIN contents cp ON cp.module = 'product' AND cp.module_id = p.id AND cp.language = 'ru' "
            ."WHERE p.deleted = 1 ORDER BY p.created";
        $command = $connection->createCommand($sql);
        $dataReader = $command->query();
        $productNodes = $dataReader->readAll();
        
        // Products
        $sql = "SELECT DISTINCT p.id as p_id, p.slug as p_slug, p.created as p_created, cp.title as p_title "
            ."FROM pages p LEFT JOIN contents cp ON cp.module = 'page' AND cp.module_id = p.id AND cp.language = 'ru' "
            ."WHERE p.deleted = 1 ORDER BY p.created";
        $command = $connection->createCommand($sql);
        $dataReader = $command->query();
        $pages = $dataReader->readAll();
        
        // Articles
        $sql = "SELECT DISTINCT p.id as p_id, p.slug as p_slug, p.created as p_created, cp.title as p_title "
            ."FROM articles p LEFT JOIN contents cp ON cp.module = 'article' AND cp.module_id = p.id AND cp.language = 'ru' "
            ."WHERE p.deleted = 1 ORDER BY p.created";
        $command = $connection->createCommand($sql);
        $dataReader = $command->query();
        $articles = $dataReader->readAll();
        
        // Gallery
        $sql = "SELECT DISTINCT p.id as p_id, p.slug as p_slug, p.created as p_created, cp.title as p_title "
            ."FROM gallery p LEFT JOIN contents cp ON cp.module = 'gallery' AND cp.module_id = p.id AND cp.language = 'ru' "
            ."WHERE p.deleted = 1 ORDER BY p.created";
        $command = $connection->createCommand($sql);
        $dataReader = $command->query();
        $galleries = $dataReader->readAll();

        $this->render('index', array(
            'products' => $products,
            'productNodes' => $productNodes,
            'pages' => $pages,
            'articles' => $articles,
            'galleries' => $galleries,
        ));
    }
    
    public function actionRestore($id) {
        $module = Yii::app()->getRequest()->getParam('module');
        if ( ! $module) {
            $this->redirect(array('/admin/deleted'));
        }
        
        switch ($module) {
            case 'product':
                $model = Product::model()->findByPk($id);
                if ($model->deleted == 1) {
                    $model->deleted = 0;
                    $model->save();
                }
                break;
            case 'productnode':
                $model = ProductNode::model()->findByPk($id);
                if ($model->deleted == 1) {
                    $model->deleted = 0;
                    $model->save();
                }
                break;
            case 'page':
                $model = Page::model()->findByPk($id);
                if ($model->deleted == 1) {
                    $model->deleted = 0;
                    $model->save();
                }
                break;
            case 'article':
                $model = Article::model()->findByPk($id);
                if ($model->deleted == 1) {
                    $model->deleted = 0;
                    $model->save();
                }
                break;
            case 'gallery':
                $model = Gallery::model()->findByPk($id);
                if ($model->deleted == 1) {
                    $model->deleted = 0;
                    $model->save();
                }
                break;
        }
        
        $this->redirect(array('/admin/deleted'));
    }
    
    public function actionDelete($id) {
        $module = Yii::app()->getRequest()->getParam('module');
        if ( ! $module) {
            $this->redirect(array('/admin/deleted'));
        }
        
        switch ($module) {
            case 'product':
                $model = Product::model()->findByPk($id);
                if ($model AND $model->deleted == 1) {
                    foreach ($model->productNodes AS $node) {
                        $node->delete();
                    }
                    $contents = Content::model()->findAllByAttributes(array(
                        'module' => 'product',
                        'module_id' => $model->id,
                    ));
                    foreach ($contents AS $content) {
                        $content->delete();
                    }
                    $model->delete();
                }
                break;
            case 'productnode':
                $model = ProductNode::model()->findByPk($id);
                if ($model AND $model->deleted == 1) {
                    $cartItems = CartItem::model()->findAllByAttributes(array(
                        'product_node_id' => $model->id,
                    ));
                    foreach ($cartItems AS $cartItem) {
                        $cartItem->delete();
                    }
                    $wishlistItems = WishlistItem::model()->findAllByAttributes(array(
                        'product_node_id' => $model->id,
                    ));
                    foreach ($wishlistItems AS $wishlistItem) {
                        $wishlistItem->delete();
                    }
                    $model->delete();
                }
                break;
            case 'page':
                $model = Page::model()->findByPk($id);
                if ($model AND $model->deleted == 1) {
                    $contents = Content::model()->findAllByAttributes(array(
                        'module' => 'page',
                        'module_id' => $model->id,
                    ));
                    foreach ($contents AS $content) {
                        $content->delete();
                    }
                    $model->delete();
                }
                break;
            case 'article':
                $model = Article::model()->findByPk($id);
                if ($model AND $model->deleted == 1) {
                    $contents = Content::model()->findAllByAttributes(array(
                        'module' => 'article',
                        'module_id' => $model->id,
                    ));
                    foreach ($contents AS $content) {
                        $content->delete();
                    }
                    $model->delete();
                }
                break;
            case 'gallery':
                $model = Gallery::model()->findByPk($id);
                if ($model AND $model->deleted == 1) {
                    $contents = Content::model()->findAllByAttributes(array(
                        'module' => 'gallery',
                        'module_id' => $model->id,
                    ));
                    foreach ($contents AS $content) {
                        $content->delete();
                    }
                    $model->delete();
                }
                break;
        }
        
        $this->redirect(array('/admin/deleted'));
    }

}
