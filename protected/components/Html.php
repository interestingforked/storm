<?php


class Html extends CHtml {
    
    public static function formatTitle($title = null, $metaTitle = null) {
        if ($metaTitle)
            return $metaTitle;
        if ($title)
            return $title;
    }
    
}

?>
