<?php

class PageController extends Controller {

    public function actionIndex($id) {
        $page = Page::model()->getPage($id);
        if (!$page) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        if ($page->parent_id > 1) {
            if ($page->getparent->multipage == 1) {
                $page = Page::model()->getPage($page->getparent->slug);
                $id = $page->slug;
            }
            $parentPages = array();
            $slugs = explode('/', $id);
            array_pop($slugs);
            while (count($slugs) > 0) {
                $pageSlug = implode('/', $slugs);
                array_pop($slugs);
                $parentPage = Page::model()->getPage($pageSlug);
                if ($parentPage)
                    array_unshift($parentPages, $parentPage);
            }
            foreach ($parentPages as $parentPage) {
                $this->breadcrumbs[$parentPage->content->title] = array(
                    '/' . $parentPage->slug,
                );
            }
        }

        $this->metaTitle = $page->content->meta_title;
        $this->metaDescription = $page->content->meta_description;
        $this->metaKeywords = $page->content->meta_keywords;
        $this->background = $page->content->background;

        $this->breadcrumbs[] = $page->content->title;
        $this->render('index', array(
            'page' => $page,
        ));
    }

}