<?php

class Renderer {
    
    const RENDER_TABLE_ROW = 1;
    const RENDER_OPTION_LIST = 2;
    
    private $title = array();

    public function renderRecursive($items, $value = null, $renderType = self::RENDER_TABLE_ROW) {
        foreach ($items as $item) {
            if ($item['level'] == 1) {
                $this->title = array();
            }
            switch ($renderType) {
                case self::RENDER_TABLE_ROW:
                    echo $this->renderItemAsTableRow($item);
                    break;
                case self::RENDER_OPTION_LIST:
                    echo $this->renderItemAsOptionList($item, $value);
                    break;
            }
            if (isset($item['items']) && count($item['items'])) {
                $this->renderRecursive($item['items'], $value, $renderType);
            }
        }
    }
    
    public function renderItemAsTableRow($item) {
        echo '<tr><td><span style="padding:'.(($item['level'] > 1) ? ($item['level'] * 15) - 15 : 0).'px;"></span>';
        echo CHtml::link($item['linkTitle'], array('/admin/'.$item['controller'].'/view/'.$item['id'])).'</td>';
        echo '<td>'.$item['active'].'</td>';
        echo '<td>'.date("Y-m-d", strtotime($item['created'])).'</td>';
        echo '<td class="delete">';
        echo CHtml::link('Up', array('/admin/'.$item['controller'].'/moveu/'.$item['id'])).' ';
        echo CHtml::link('Down', array('/admin/'.$item['controller'].'/moved/'.$item['id'])).' ';
        echo '</td><td class="delete">';
        echo CHtml::link('View', array('/admin/'.$item['controller'].'/view/'.$item['id'])).' ';
        echo CHtml::link('Edit', array('/admin/'.$item['controller'].'/edit/'.$item['id'])).' ';
        echo CHtml::link('Delete', array('/admin/'.$item['controller'].'/delete/'.$item['id'])).' ';
        echo '</td></tr>';
    }
    
    public function renderItemAsOptionList($item, $value) {
        $this->title[$item['level']] = $item['linkTitle'];
        $selected = ($item['id'] == $value) ? ' selected' : '';
        echo '<option value="'.$item['id'].'"'.$selected.'>'.implode(' &raquo; ', $this->title).'</option>';
    }

}
