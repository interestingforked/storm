<?php

class GalleryController extends Controller {

    public function actionIndex() {
        $pluginPage = Page::model()->getPage($_GET['plugin']);

        $galleries = Gallery::model()->getGalleries($pluginPage->id);

        $total = count($galleries);
        $limit = 9;
        $offset = 0;

        $page = (isset($_GET['page']) AND $_GET['page'] > 0) ? $_GET['page'] : 1;
        $pages = ceil($total / $limit);

        if ($page > 1) {
            $offset = $limit * ($page - 1);
        }
        $nextpage = $page + 1;
        $prevpage = $page - 1;

        $this->background = $pluginPage->content->background;
        $this->breadcrumbs[] = $pluginPage->content->title;
        if (count($galleries) > 0 AND $galleries[0]->pagination != 1) {
            $this->render('index_nopages', array(
                'pluginPage' => $pluginPage,
                'galleries' => $galleries,
            ));
        } else {
            $this->render('index', array(
                'pluginPage' => $pluginPage,
                'galleries' => $galleries,
                'total' => $total,
                'page' => $page,
                'pages' => $pages,
                'offset' => $offset,
                'limit' => $limit,
                'nextpage' => $nextpage,
                'prevpage' => $prevpage,
            ));
        }
    }

    public function actionView($id) {
        $pluginPage = Page::model()->getPageByPlugin('gallery');

        $gallery = Gallery::model()->getGalleryBySlug($id);

        $this->background = $pluginPage->content->background;
        $this->breadcrumbs[$pluginPage->content->title] = array('/' . $pluginPage->slug);
        $this->breadcrumbs[] = $gallery->content->title;
        $this->render('view', array(
            'pluginPage' => $pluginPage,
            'gallery' => $gallery,
        ));
    }

}