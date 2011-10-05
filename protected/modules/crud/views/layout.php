<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <title>Simple CRUD application</title>
        <link rel="stylesheet" href="/css/crud/style.css" type="text/css" media="screen, projection" />
        <link rel="stylesheet" href="/css/crud/fileuploader.css" type="text/css" media="screen, projection" />
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6/jquery.min.js"></script>
        <script type="text/javascript" src="/js/jquery.easing-1.3.pack.js"></script> 
        <script type="text/javascript" src="/js/jquery.mousewheel-3.0.4.pack.js"></script> 
        <script type="text/javascript" src="/js/jquery.fancybox-1.3.4.pack.js"></script> 
        <link rel="stylesheet" type="text/css" href="/css/jquery.fancybox-1.3.4.css" media="screen" /> 
        <script type="text/javascript">
            $(document).ready(function() {
                $('.modal').fancybox({
                    'scrolling':'no', 'centerOnScroll':true, 'titleShow':false
                });
            });
            function createUploader(elem){
                var uploader = new qq.FileUploader({
                    element: document.getElementById(elem),
                    action: '/crud/default/upload',
                    onComplete: function(id, fileName, responseJSON){
                        if (responseJSON.success == true) {
                            id = id+"";
                            fileId = id.replace('qq-upload-handler-iframe', '');
                            $('#tmp-attachment-list')
                            .append('<li id="tmpfile'+fileId+'">'+
                                '<img src="/assets/thumb.php?src=/'+responseJSON.path+'&amp;w=100" />'+
                                '<div><a href="javascript:deleteTempAttachment('+fileId+')">Delete</a></div>'+
                                '<input type="hidden" name="tmpfile'+fileId+'" value="'+responseJSON.filename+'|'+responseJSON.image+'|'+responseJSON.mimetype+'|'+responseJSON.path+'" />'+
                                '</li>');
                        }
                    }
                });
            }
            function deleteTempAttachment(id) {
                var elem = id+"";
                id = elem.replace('/qq-upload-handler-iframe/', '');
                $('#tmpfile' + id).remove();
            }
            function deleteAttachment(id) {
                if (confirm('Are you sure you want to delete this picture?') == true) {
                    $.get('/crud/default/deleteattachment/' + id, null, function(responseText) {
                        if (responseText=='true') {$('#file' + id).remove();}
                        else {alert('Cannot delete picture!');}
                    }, 'html');
                }
            }
            function setAsMain(id) {
                if (confirm('Are you sure you want to set this picture as main?') == true) {
                    $.get('/crud/default/setasmain/' + id, null, function(responseText) {
                        if (responseText > 0) {
                            $('#mainMedia' + id).addClass('main-media');
                            $('#mainMedia' + responseText).removeClass('main-media');
                        }
                        else {alert('Cannot change attachment status!');}
                    }, 'html');
                }
            }
        </script>
    </head>
    <body>
        <div id="wrapper">
            <div id="header">
                <h1>Simple CRUD application</h1>
            </div>
            <div id="menu">
                <?php
                $this->widget('zii.widgets.CMenu', array(
                    'items' => $this->menu,
                    'activeCssClass' => 'active',
                    'activateParents' => true,
                ));
                ?>
                <div class="clear"></div>
            </div>
            <div id="content">
                <?php echo $content; ?>
            </div>
        </div>
        <div id="footer"><p>Simple CRUD application</p></div>
    </body>
</html>