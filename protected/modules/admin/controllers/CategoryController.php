<?php

class CategoryController extends AdminController {

    public function actionIndex() {
        $this->pageTitle = 'Categories';
        
        $rootCategory = Category::model()->findByPk(1);
        $tableRows = $rootCategory->getTableRows();

        $this->render('index', array(
            'categories' => $tableRows['items'],
        ));
    }

    public function actionAdd() {
        $this->pageTitle = 'Categories / Add category';
        
        $errors = array();
        
        $rootCategory = Category::model()->findByPk(1);
        $categories = $rootCategory->getTableRows();
        
        $categoryModel = new Category;
        $contentModel = new Content;

        if (isset($_POST['Category'])) {
            $categoryModel->attributes = $_POST['Category'];
            $contentModel->attributes = $_POST['Content'];

            $categoryModel->image = Attachment::model()->saveImage($categoryModel->image, 'category');
            
            $transaction = Yii::app()->db->beginTransaction();
            if ($categoryModel->save()) {
                $contentModel->module = 'category';
                $contentModel->module_id = $categoryModel->id;
                $contentModel->language = Yii::app()->params['defaultLanguage'];

                if ($contentModel->save()) {
                    $transaction->commit();
                    $this->redirect(array('/admin/category'));
                } else {
                    $transaction->rollback();
                    $errors = $contentModel->getErrors();
                }
            } else {
                $transaction->rollback();
                $errors = $categoryModel->getErrors();
            }
        }

        $this->render('add', array(
            'errors' => $errors,
            'categories' => $categories,
            'categoryModel' => $categoryModel,
            'contentModel' => $contentModel,
        ));
    }
    
    public function actionEdit($id) {
        $this->pageTitle = 'Categories / Edit category';
        
        $errors = array();
        
        $rootCategory = Category::model()->findByPk(1);
        $categories = $rootCategory->getTableRows();
        
        $categoryModel = Category::model()->findByPk($id);
        $contentModel = Content::model()->getModuleContent('category', $id);

        if (isset($_POST['Category'])) {
            $categoryModel->attributes = $_POST['Category'];
            
            if (empty($_POST['Category']['image'])) {
                unset($_POST['Category']['image']);
            }
            $contentModel->attributes = $_POST['Content'];
            
            if (!empty($_POST['Category']['image'])) {
                $categoryModel->image = Attachment::model()->saveImage($_POST['Category']['image'], 'category');
            }
            
            $transaction = Yii::app()->db->beginTransaction();
            if ($categoryModel->save()) {
                if ($contentModel->save()) {
                    $transaction->commit();
                    $this->redirect(array('/admin/category'));
                } else {
                    $transaction->rollback();
                    $errors = $contentModel->getErrors();
                }
            } else {
                $transaction->rollback();
                $errors = $categoryModel->getErrors();
            }
        }

        $this->render('edit', array(
            'errors' => $errors,
            'categories' => $categories,
            'categoryModel' => $categoryModel,
            'contentModel' => $contentModel,
            'title' => $contentModel->title,
        ));
    }
    
    public function actionMoveU($id) {
        $model = Category::model()->findByPk($id);
        $sort = $model->sort;
        if ($sort > 1) {
            $upperModel = Category::model()->findBySql(
                "SELECT * FROM categories WHERE parent_id = :parent_id AND sort < :sort", array(
                ':parent_id' => $model->parent_id,
                ':sort' => $sort,
            ));
            if ($upperModel) {
                $model->sort = $upperModel->sort;
                $model->save();
                $upperModel->sort = $sort;
                $upperModel->save();
            }
        }
        $this->redirect(array('/admin/category'));
    }
    
    public function actionMoveD($id) {
        $model = Category::model()->findByPk($id);
        $sort = $model->sort;
        $maxModel = Category::model()->findBySql(
            "SELECT MAX(sort) as sort FROM categories WHERE parent_id = :parent_id", 
            array(':parent_id' => $model->parent_id)
        );
        if ($sort < $maxModel->sort) {
            $upperModel = Category::model()->findBySql(
                "SELECT * FROM categories WHERE parent_id = :parent_id AND sort > :sort", 
                array(
                    ':parent_id' => $model->parent_id,
                    ':sort' => $sort,
            ));
            if ($upperModel) {
                $model->sort = $upperModel->sort;
                $model->save();
                $upperModel->sort = $sort;
                $upperModel->save();
            }
        }
        $this->redirect(array('/admin/category'));
    }

    public function actionDelete($id) {
        $model = Category::model()->findByPk($id);
        $model->deleted = 1;
        $model->save();

        $this->redirect(array('/admin/category'));
    }

}
