<?php

class Image {

    public static function thumb($image, $width = false, $height = false) {
        $thumbUrl = Yii::app()->params['thumbUrl'];
        $thumbUrl .= '?src='.$image;
        if ($width)
            $thumbUrl .= '&w='.$width;
        if ($height)
            $thumbUrl .= '&h='.$height;
        return $thumbUrl;
    }

}