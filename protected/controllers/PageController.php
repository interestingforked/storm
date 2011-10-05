<?php

class PageController extends Controller {

    public function actionIndex($id) {
        $page = Page::model()->getPage($id);
        if ($page->parent_id > 1) {
            $parentPages = array();
            $slugs = explode('/', $id);
            for ($i = 0; $i < (count($slugs) - 1); $i++) {
                $parentPages[] = Page::model()->getPage($slugs[$i]);
            }
            foreach ($parentPages as $parentPage) {
                $this->breadcrumbs[$parentPage->content->title] = array(
                    '/'.$parentPage->slug,
                );
            }
        }
        $this->breadcrumbs[] = $page->content->title;
        $this->render('index', array(
            'page' => $page,
        ));
    }

}