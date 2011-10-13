<?php

class CategoryController extends Controller {

    public function actionIndex($id) {
        $category = Category::model()->getCategory($id);
        if ($category->parent_id > 1) {
            $parentCategories = array();
            $slugs = explode('/', $id);
            for ($i = 0; $i < (count($slugs) - 1); $i++) {
                $parentCategories[] = Category::model()->getCategory($slugs[$i]);
            }
            foreach ($parentCategories as $parentCategory) {
                $this->breadcrumbs[$parentCategory->content->title] = array(
                    '/'.$parentCategory->slug,
                );
            }
        }
        $this->breadcrumbs[] = $category->content->title;
        
        $this->metaTitle = $category->content->meta_title;
        $this->metaDescription = $category->content->meta_description;
        $this->metaKeywords = $category->content->meta_keywords;
        $this->background = $category->content->background;
        
        if ($category->childs) {
            $this->render('index', array(
                'category' => $category,
            ));
        } else {
            $products = array();
            if ($category->products) {
                foreach ($category->products AS $product) {
                    if ($product->active == 0)
                        continue;
                    $productContent = $product->getProduct();
                    if (isset($_GET['orderby'])) {
                        switch ($_GET['orderby']) {
                            case 'price':
                                $products[$productContent->mainNode->price.$productContent->id] = $productContent;
                                break;
                            case 'name':
                                $products[$productContent->content->title.$productContent->id] = $productContent;
                                break;
                            default:
                                $products[$productContent->sort.$productContent->id] = $productContent;
                        }
                    } else {
                        $products[] = $product;
                    }
                }
                if (isset($_GET['orderby'])) {
                    ksort($products);
                }
                $total = count($products);
                $limit = 6;
                $offset = 0;

                $page = (isset($_GET['page']) AND $_GET['page'] > 0) ? $_GET['page'] : 1;
                $pages = ceil($total / $limit);

                if ($page > 1) {
                    $offset = $limit * ($page - 1);
                }
                $nextpage = $page + 1;
                $prevpage = $page - 1;

                $this->render('products', array(
                    'category' => $category,
                    'products' => $products,
                    'total' => $total,
                    'page' => $page,
                    'pages' => $pages,
                    'offset' => $offset,
                    'limit' => $limit,
                    'nextpage' => $nextpage,
                    'prevpage' => $prevpage,
                ));
            } else {
                $this->render('no_products', array(
                    'category' => $category,
                ));
            }
        }
        
    }

}