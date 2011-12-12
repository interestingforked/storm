$(function () {
	
    // Preload images
    $.preloadCssImages();

    // CSS tweaks
    $('#header #nav li:last').addClass('nobg');
    $('.block_head ul').each(function() {
        $('li:first', this).addClass('nobg');
    });
    $('.block form input[type=file]').addClass('file');

    // Web stats
    $('table.stats').each(function() {	
        if($(this).attr('rel')) {
            var statsType = $(this).attr('rel');
        }
        else {
            var statsType = 'area';
        }
		
        var chart_width = ($(this).parent('.block_content').width()) - 60;
		
        $(this).hide().visualize({		
            type: statsType,	// 'bar', 'area', 'pie', 'line'
            width: chart_width,
            height: '240px',
            colors: ['#6fb9e8', '#ec8526', '#9dc453', '#ddd74c']
        });
    });

    // Sort table
    $("table.sortable").tablesorter({
        widgets: ['zebra']
    }).tablesorterPager({container: $("#pager")});
	
    $('.block table tr th.header').css('cursor', 'pointer');

    // Check / uncheck all checkboxes
    $('.check_all').click(function() {
        $(this).parents('form').find('input:checkbox').attr('checked', $(this).is(':checked'));   
    });

    // Set WYSIWYG editor
    $('.wysiwyg').wysiwyg({
        css: "/css/admin/wysiwyg.css",
        controls: {
            bold          : { visible : true },
            italic        : { visible : true },
            underline     : { visible : true },
            strikeThrough : { visible : true },
            justifyLeft   : { visible : true },
            justifyCenter : { visible : true },
            justifyRight  : { visible : true },
            justifyFull   : { visible : true },
            indent  : { visible : true },
            outdent : { visible : true },
            subscript   : { visible : true },
            superscript : { visible : true },
            undo : { visible : true },
            redo : { visible : true },
            insertOrderedList    : { visible : true },
            insertUnorderedList  : { visible : true },
            insertHorizontalRule : { visible : true },
            h4: {
                    visible: true,
                    className: 'h4',
                    command: ($.browser.msie || $.browser.safari) ? 'formatBlock' : 'heading',
                    arguments: ($.browser.msie || $.browser.safari) ? '<h4>' : 'h4',
                    tags: ['h4'],
                    tooltip: 'Header 4'
            },
            h5: {
                    visible: true,
                    className: 'h5',
                    command: ($.browser.msie || $.browser.safari) ? 'formatBlock' : 'heading',
                    arguments: ($.browser.msie || $.browser.safari) ? '<h5>' : 'h5',
                    tags: ['h5'],
                    tooltip: 'Header 5'
            },
            h6: {
                    visible: true,
                    className: 'h6',
                    command: ($.browser.msie || $.browser.safari) ? 'formatBlock' : 'heading',
                    arguments: ($.browser.msie || $.browser.safari) ? '<h6>' : 'h6',
                    tags: ['h6'],
                    tooltip: 'Header 6'
            },
            cut   : { visible : true },
            copy  : { visible : true },
            paste : { visible : true },
            html  : { visible: true },
            increaseFontSize : { visible : true },
            decreaseFontSize : { visible : true }
        }
    });

    // Modal boxes - to all links with rel="facebox"
    $('a[rel*=facebox]').facebox()

    // Messages
    $('.block .message').hide().append('<span class="close" title="Dismiss"></span>').fadeIn('slow');
    $('.block .message .close').hover(
        function() {
            $(this).addClass('hover');
        },
        function() {
            $(this).removeClass('hover');
        }
        );
		
    $('.block .message .close').click(function() {
        $(this).parent().fadeOut('slow', function() {
            $(this).remove();
        });
    });

    // Form select styling
    $("form select.styled").select_skin();

    // Tabs
    $(".tab_content").hide();
    $("ul.tabs li:first-child").addClass("active").show();
    $(".block").find(".tab_content:first").show();

    $("ul.tabs li").click(function() {
        $(this).parent().find('li').removeClass("active");
        $(this).addClass("active");
        $(this).parents('.block').find(".tab_content").hide();

        var activeTab = $(this).find("a").attr("href");
        $(activeTab).show();
        return false;
    });
	
    // Sidebar Tabs
    $(".sidebar_content").hide();
	
    if(window.location.hash && window.location.hash.match('sb')) {
	
        $("ul.sidemenu li a[href="+window.location.hash+"]").parent().addClass("active").show();
        $(".block .sidebar_content#"+window.location.hash).show();
    } else {
	
        $("ul.sidemenu li:first-child").addClass("active").show();
        $(".block .sidebar_content:first").show();
    }

    $("ul.sidemenu li").click(function() {
        var activeTab = $(this).find("a").attr("href");
        window.location.hash = activeTab;
	
        $(this).parent().find('li').removeClass("active");
        $(this).addClass("active");
        $(this).parents('.block').find(".sidebar_content").hide();			
        $(activeTab).show();
        return false;
    });	

    // Block search
    $('.block .block_head form .text').bind('click', function() {
        $(this).attr('value', '');
    });

    // Image actions menu
    $('ul.imglist li').hover(
        function() {
            $(this).find('ul').css('display', 'none').fadeIn('fast').css('display', 'block');
        },
        function() {
            $(this).find('ul').fadeOut(100);
        }
        );
		
    // Image delete confirmation
    $('ul.imglist .delete a').click(function() {
        if ($(this).parent().hasClass('nowarning')) {
            return true;
        }
        if (confirm("Are you sure you want to delete this image?")) {
            return true;
        } else {
            return false;
        }
    });
    
    // Image delete confirmation
    $('a.delete, a.ban, a.disable').click(function() {
        if (confirm("Are you sure you want to " + $(this).attr('class') + " this item?")) {
            return true;
        } else {
            return false;
        }
    });

    // Style file input
    $("input.file").filestyle({ 
        image: "/images/admin/upload.gif",
        imageheight : 30,
        imagewidth : 80,
        width : 250
    });
   
    // File upload
    if ($('#fileupload').length) {
        new AjaxUpload('fileupload', {
            action: '/admin/default/upload',
            autoSubmit: true,
            name: 'qqfile',
            responseType: 'json',
            onSubmit : function(file , ext) {
                $('.fileupload #uploadmsg').addClass('loading').text('Uploading...');
                this.disable();	
            },
            onComplete : function(file, response) {
                $('.fileupload #uploadmsg').removeClass('loading').text('Completed!');
                var fileParams = response.filename+'|'+response.image+'|'+response.mimetype+'|'+response.path;
                $('.fileupload #ytfileupload').val(fileParams);
                $('.fileupload .file').val(response.filename);
            }	
        });
    }

    // Date picker
    $.extend(DateInput.DEFAULT_OPTS, {
        stringToDate: function(string) {
            var matches;
            if (matches = string.match(/^(\d{4,4})-(\d{2,2})-(\d{2,2})$/)) {
                return new Date(matches[1], matches[2] - 1, matches[3]);
            } else {
                return null;
            };
        },

        dateToString: function(date) {
            var month = (date.getMonth() + 1).toString();
            var dom = date.getDate().toString();
            if (month.length == 1) month = "0" + month;
            if (dom.length == 1) dom = "0" + dom;
            return date.getFullYear() + "-" + month + "-" + dom;
        }
    });
    $('input.date_picker').date_input();
    
    $('#finder').elfinder({
        url : '/assets/connector.php',
        placesFirst : false
    })
    
    $('#product-form .select_buttons').click(function(){
        var arr = $(this).attr("name").split("2");
        var from = arr[0];
        var to = arr[1];
        $("#" + from + " option:selected").each(function(){
            $("#" + to).append($(this).clone());
            $(this).remove();
        });
    });
    $('#product-form #submit').click(function() {
        $('#categories option').each(function(index) {
            $(this).attr('selected',true);
        });
        $('#selected_categories option').each(function(index) {
            $(this).attr('selected',true);
        });		
        return true;
    });

    // Navigation dropdown fix for IE6
    if(jQuery.browser.version.substr(0,1) < 7) {
        $('#header #nav li').hover(
            function() {
                $(this).addClass('iehover');
            },
            function() {
                $(this).removeClass('iehover');
            }
            );
    }
	
    // IE6 PNG fix
    $(document).pngFix();
 	
});

// File uploader
function createUploader(elem){
    var uploader = new qq.FileUploader({
        element: document.getElementById(elem),
        action: '/admin/default/upload',
        onComplete: function(id, fileName, response){
            if (response.success == true) {
                id = id+"";
                var fileId = id.replace('qq-upload-handler-iframe', '');
                var fileParams = response.filename+'|'+response.image+'|'+response.mimetype+'|'+response.path;
                $('#tmp-attachment-list')
                .append('<li id="tmpfile'+fileId+'">'+
                    '<img src="/assets/thumb.php?src=/'+response.path+'&amp;w=100" />'+
                    '<ul class="small">'+
                    '<li class="delete"><a href="javascript:deleteTempAttachment('+fileId+')">Delete</a></li>'+
                    '</ul>'+
                    '<input type="hidden" name="tmpfile'+fileId+'" value="'+fileParams+'" />'+
                    '</li>');
                $('#tempAttachments')
                .append('<input type="hidden" name="tmpfile'+fileId+'" value="'+fileParams+'" />');
            }
        }
    });
}
    
// Delete temporary attachment
function deleteTempAttachment(id) {
    var elem = id+"";
    id = elem.replace('/qq-upload-handler-iframe/', '');
    $('#tmpfile' + id).remove();
    $('#tempAttachments input[name=tmpfile'+id+']').remove();
}

// Delete temporary attachment
function selectAttachment(id) {
    var element = '<input type="hidden" name="attachments[]" value="' + id + '">';
    $('#selectedAttachments').append(element);
}
    
// Delete saved attachment
function deleteAttachment(id) {
    $.get('/admin/default/deleteattachment/' + id, null, function(responseText) {
        if (responseText == 'true')
            $('#file' + id).remove();
        else
            alert('Cannot delete attachment!');
    }, 'html');
}