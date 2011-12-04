<?php

/**
 * CLinkPager class file.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @link http://www.yiiframework.com/
 * @copyright Copyright &copy; 2008-2011 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

/**
 * CLinkPager displays a list of hyperlinks that lead to different pages of target.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @version $Id: CLinkPager.php 2799 2011-01-01 19:31:13Z qiang.xue $
 * @package system.web.widgets.pagers
 * @since 1.0
 */
class LinkPager extends CLinkPager {
    
    const CSS_SELECTED_PAGE = 'active';

    public function init() {
        parent::init();
        $this->firstPageLabel = '&laquo;&laquo;';
        $this->lastPageLabel = '&raquo;&raquo;';
        $this->nextPageLabel = '&raquo;';
        $this->prevPageLabel = '&laquo;';
        $this->htmlOptions = array(
            'class' => 'pagination right'
        );
    }

    public function run() {
        $buttons = $this->createPageButtons();
        if (empty($buttons))
            return;
        echo CHtml::tag('div', $this->htmlOptions, implode("\n", $buttons));
    }

    protected function createPageButtons() {
        if (($pageCount = $this->getPageCount()) <= 1)
            return array();

        list($beginPage, $endPage) = $this->getPageRange();
        $currentPage = $this->getCurrentPage(false); // currentPage is calculated in getPageRange()
        $buttons = array();

        // first page
        $buttons[] = $this->createPageButton($this->firstPageLabel, 0, self::CSS_FIRST_PAGE, $currentPage <= 0, false);

        // prev page
        if (($page = $currentPage - 1) < 0)
            $page = 0;
        $buttons[] = $this->createPageButton($this->prevPageLabel, $page, self::CSS_PREVIOUS_PAGE, $currentPage <= 0, false);

        // internal pages
        for ($i = $beginPage; $i <= $endPage; ++$i)
            $buttons[] = $this->createPageButton($i + 1, $i, self::CSS_INTERNAL_PAGE, false, $i == $currentPage);

        // next page
        if (($page = $currentPage + 1) >= $pageCount - 1)
            $page = $pageCount - 1;
        $buttons[] = $this->createPageButton($this->nextPageLabel, $page, self::CSS_NEXT_PAGE, $currentPage >= $pageCount - 1, false);

        // last page
        $buttons[] = $this->createPageButton($this->lastPageLabel, $pageCount - 1, self::CSS_LAST_PAGE, $currentPage >= $pageCount - 1, false);

        return $buttons;
    }

    protected function createPageButton($label, $page, $class, $hidden, $selected) {
        if ($hidden OR $selected)
            $class .= ' ' . ($hidden ? self::CSS_HIDDEN_PAGE : self::CSS_SELECTED_PAGE);
        return CHtml::link($label, $this->createPageUrl($page), array('class' => $class));
    }

}
