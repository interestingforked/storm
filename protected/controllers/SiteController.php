<?php

class SiteController extends Controller {

    public function actions() {
        return array(
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
        );
    }

    public function actionIndex() {
        $page = Page::model()->getPageByPlugin('article');
        $articles = Article::model()->getHomeArticle();

        $leftBlock = Block::model()->getBlock(1);
        $rightBlock = Block::model()->getBlock(2);

        $this->metaTitle = Yii::app()->params['indexTitle'];

        $this->render('index', array(
            'articles' => $articles,
            'page' => $page,
            'block1' => $leftBlock,
            'block2' => $rightBlock,
        ));
    }

    public function actionError() {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

}