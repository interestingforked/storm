<?php

class DefaultController extends AdminController {

    public function actionIndex() {
        $this->pageTitle = 'Dashboard';
        
        $lastOrders = Order::model()->getLastOrders(10);
        $lastUsers = User::model()->getLastUsers(10);
        
        $this->render('index', array(
            'lastOrders' => $lastOrders,
            'lastUsers' => $lastUsers,
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

    public function actionUpload() {
        $allowed_extensions = array('jpg', 'jpeg', 'jpe', 'gif', 'png', 'bmp', 'tiff', 'tif');
        $size_limit = Yii::app()->params['size_limit'];
        $upload_dir = Yii::app()->params['tmp_upload_dir'];

        $uploader = new Uploader($allowed_extensions, $size_limit);
        $result = $uploader->handleUpload($upload_dir);
        echo htmlspecialchars(json_encode($result), ENT_NOQUOTES);
    }

    public function actionDeleteAttachment($id) {
        $attachment = Attachment::model()->findByPk($id);
        if ($attachment) {
            $otherAttachments = Attachment::model()->findAllByAttributes(array(
                'module' => $attachment->module,
                'image' => $attachment->image,
            ));
            switch ($attachment->module) {
                case 'page':        $directory = 'pages';       break;
                case 'background':  $directory = 'backgrounds'; break;
                default:            $directory = 'images';
            }
            if (count($otherAttachments) == 1) {
                try {
                    unlink(Yii::app()->basePath . DIRECTORY_SEPARATOR . '..' . Yii::app()->params[$directory] . $attachment->image);
                } catch (Exception $e) {
                    
                }
            }
            $attachment->delete();
            echo 'true';
        }
    }

    public function actionSetAsMain($id) {
        $attachment = Attachment::model()->findByPk($id);
        if ($attachment) {
            $result = 'true';
            $mainAttachment = Attachment::model()->getAttachment('productBig', $attachment->module_id);
            if ($mainAttachment) {
                $mainAttachment->module = 'product';
                $mainAttachment->save();
                $result = $mainAttachment->id;
            }
            $attachment->module = 'productBig';
            $attachment->save();
            echo $result;
        }
    }

}