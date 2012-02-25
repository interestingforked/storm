<?php

class Renderer {
    
    const RENDER_TABLE_ROW = 1;
    const RENDER_OPTION_LIST = 2;
    const RENDER_CATEGORY_ROW = 3;
    
    private $icons = array();
    private $title = array();
    
    public function __construct($icons = array()) {
        $this->icons = $icons;
    }

    public function renderRecursive($items, $value = null, $renderType = self::RENDER_TABLE_ROW) {
        $itemCount = count($items);
        $count = 0;
        foreach ($items as $item) {
            $count++;
            if ($item['level'] == 1) {
                $this->title = array();
            }
            switch ($renderType) {
                case self::RENDER_TABLE_ROW:
                    echo $this->renderItemAsTableRow($item, ($count == 1), ($count == $itemCount));
                    break;
                case self::RENDER_CATEGORY_ROW:
                    echo $this->renderItemAsTableRow($item, ($count == 1), ($count == $itemCount), true);
                    break;
                case self::RENDER_OPTION_LIST:
                    echo $this->renderItemAsOptionList($item, $value);
                    break;
            }
            if (isset($item['items']) && count($item['items'])) {
                if (!($renderType == self::RENDER_OPTION_LIST && $item['multipage'] == 1))
                    $this->renderRecursive($item['items'], $value, $renderType);
            }
        }
    }
    
    public function renderItemAsTableRow($item, $first = false, $last = false, $category = false) {
        echo '<tr><td><span style="padding:'.(($item['level'] > 1) ? ($item['level'] * 15) - 15 : 0).'px;"></span>';
        echo CHtml::link($item['linkTitle'], array('/admin/'.$item['controller'].'/edit/'.$item['id'])).'</td>';
        echo '<td>'.($item['active'] ? 'Active' : 'Disabled').'</td>';
        echo '<td>'.$item['created'].'</td>';
        if ($category) {
            echo '<td>'.CHtml::link('Products', array('/admin/product/index/'.$item['id'])).'</td>';
        }
        echo '<td class="delete">';
        if ( ! $first)
            echo CHtml::link($this->icon('arrow_up'), array('/admin/'.$item['controller'].'/moveu/'.$item['id'])).' ';
        else
            echo $this->icon('empty');
        if ( ! $last)
            echo CHtml::link($this->icon('arrow_down'), array('/admin/'.$item['controller'].'/moved/'.$item['id'])).' ';
        else
            echo $this->icon('empty');
        echo '</td><td class="delete">';
        echo CHtml::link('View', array('/'.$item['slug']), array('target' => '_blank')).' ';
        echo CHtml::link('Edit', array('/admin/'.$item['controller'].'/edit/'.$item['id'])).' ';
        echo CHtml::link('Delete', array('/admin/'.$item['controller'].'/delete/'.$item['id']), array('class' => 'delete')).' ';
        echo '</td></tr>';
    }
    
    public function renderItemAsOptionList($item, $value) {
        $this->title[$item['level']] = $item['linkTitle'];
        $selected = ($item['id'] == $value) ? ' selected' : '';
        echo '<option value="'.$item['id'].'"'.$selected.'>'.implode(' &raquo; ', $this->title).'</option>';
    }
    
    private function icon($imageName) {
        return '<img src="'.$this->icons[$imageName].'" alt="'.$imageName.'" />';
    }

}
