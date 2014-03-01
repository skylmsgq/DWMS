<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="zh-cn">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>危险废物管理信息系统</title>
    <!-- Bootstrap core CSS -->
    <link href="__PUBLIC__/css/bootstrap.min.css" rel="stylesheet">
    <link href="__PUBLIC__/css/jquery.dataTables.css" rel="stylesheet">
    <!-- My CSS -->
    <link href="__PUBLIC__/css/layout.css" rel="stylesheet">

</head>

<body style="background:url(__PUBLIC__/image/bg_4.jpg);background-position:center;background-repeat: no-repeat;background-attachment:fixed">
    <div class="container" id="div_container">
        <script type="text/javascript" src="__PUBLIC__/js/yourAlert.js"></script>
<script type="text/javascript">
function hide_page()
{
    $('#myModal_pass').modal('hide');
}

function show_page() {
     $("#model-content_pass").html('<center style="margin:50px"><h4>正在加载中...</h4><div class="progress progress-striped active" style="width: 50%"><div class="progress-bar"  role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div></div></center>');
      $.ajax({
        type: "get",
        url: "<?php echo U('Home/Login/show_page');?>",
        dataType: "json",
        success: function(data) {
            $("#model-content_pass").html(data);
            $('#myModal_pass').modal('show');
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            console.log("Error:Ajax_Content_Load" + errorThrown);
            console.log("XMLHttpRequest.status:" + XMLHttpRequest.status);
            console.log("XMLHttpRequest.readyState:" + XMLHttpRequest.readyState);
            console.log("textStatus:" + textStatus);
        }
    });
}

function ajaxAction(){
   
   //$("#model-content").html("<h1>hello</h1>");
   if(!$('#pass_list').valid()){
        return;
    }
    var passbag={};
   // var form_serialize = "" + $('#record_modify').serialize();
    //console.log(passbag);
    // if ($('#new_pass').val()!=$('#new_pass_again').val())
    // {
    //     //alert("新密码不一样");
    //     $('#new_prompt').html("输入新密码");
    //     $('#newnew_prompt').html("重新输入新密码 <font color='red'>密码不一致</font>");
    //     return;
    // }
    // if ($('#new_pass').val().length<6)
    // {
    //     $('#new_prompt').html("输入新密码 <font color='red'>密码长度至少为6位</font>");
    //     $('#newnew_prompt').html("重新输入新密码");
    //     return;
    // }
    passbag.old_pass=$.md5($('#old_pass').val());
    passbag.new_pass=$.md5($('#password').val());
    passbag.user_id=<?php echo (session('user_id')); ?>;
//    console.log(passbag);

     // $("#model-content_pass").html('<center style="margin:50px"><h4>修改中...</h4><div class="progress progress-striped active" style="width: 50%"><div class="progress-bar"  role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div></div></center>');

    $.ajax({
        type: "post",
        url: "<?php echo U('Home/Login/changepwd');?>",
        timeout: 2000,
        data: passbag,
        success: function(data) {
            console.log(data);
            if (data=="0")
                     // $("#model-content_pass").html("<h1>密码有误</h1> <center><button class='btn btn-info btn-lg' onclick='hide_page();'>关闭页面</button><center>");
                 myAlertFail("密码有误！");
            else if (data=="1")
                     // $("#model-content_pass").html("<h1>修改成功</h1> <center><button class='btn btn-info btn-lg' onclick='hide_page();'>关闭页面</button><center>");
                 myAlertSucc("修改成功！");
            else 
                     // $("#model-content_pass").html("<h1>未知错误</h1> <center><button class='btn btn-info btn-lg' onclick='hide_page();'>关闭页面</button><center>");   
                 myAlertFail("修改失败！");


 //           $('#myModal').html(data);
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            console.log("Error: Ajax_Content_Load " + errorThrown);
            console.log("XMLHttpRequest.status: " + XMLHttpRequest.status);
            console.log("XMLHttpRequest.readyState: " + XMLHttpRequest.readyState);
            console.log("textStatus: " + textStatus);
        }
    });

}
</script>
<!-- Modal -->
<div class="modal fade" id="myModal_pass" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width:70%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">修改密码</h4>
            </div>
            <div class="modal-body" id="model-content_pass">
                
            </div>
            <div class="modal-footer"></div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="panel panel-default" id="div_header" style="margin-top:15px">
    <div class="panel-body" style="padding-top:0px">
        <img id="logo" src="__PUBLIC__/image/header_logo.jpg" alt="logo"/>
        <div id="webpage_title">
            <div id="datetime"></div>
            <h2 id="title">危险废物管理信息系统</h2>
            <p id="welcome">
                <span class="glyphicon glyphicon-user"></span> 欢迎您，<?php echo ((session('username'))?(session('username')):"先生"); ?>
                <a id="password" href="#" onclick="show_page()"><span class="glyphicon glyphicon-edit"></span> 修改密码</a>
                <a id="logout" href="<?php echo U('Home/Login/logout');?>"><span class="glyphicon glyphicon-log-out"></span> 退出登录</a>
            </p>

        </div>
         <div id="header_button_container"></div>
    </div>
</div>

<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=KDdzQZSRLv89h4yrti56L5Gy">
</script>
<script type="text/javascript" src="__PUBLIC__/js/jquery-2.0.3.min.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/bootstrap.min.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/highcharts.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/md5.js"></script>

        <div class="panel panel-default">
            <div class="panel-body" id="content-container-panel"><script type="text/javascript">
DWMS_page_config = {
    "menu": [{
        "id": 0,
        "name": "首页",
        "url": "<?php echo U('Home/LoginProduction/homepage');?>"
    }, {
        "id": 1,
        "name": "企业基本信息",
        "url": "<?php echo U('Home/ProductionBasic/basic_sidebar');?>"
    }, {
        "id": 2,
        "name": "危废库存查询",
        "url": "<?php echo U('Home/ProductionWarehouse/warehouse_sidebar');?>"
    }, {
        "id": 3,
        "name": "转移备案",
        "url": "<?php echo U('Home/ProductionRecord/record_sidebar');?>"
    }, {
        "id": 4,
        "name": "转移联单",
        "url": "<?php echo U('Home/ProductionManifest/manifest_sidebar');?>"
    }],
}
</script>

<script type="text/javascript">
DWMS_page_config.pageid = 3;
DWMS_sidebar_config = {
    "sidebar_groups": [{
        "sidebar_group_id": 0,
        "sidebar_group_title": "转移备案",
        "sidebar_group_content": [{
            "id": 0,
            "name": "转移备案申请",
            "url": "<?php echo U('Home/ProductionRecord/transfer_record_request');?>"
        }, {
            "id": 1,
            "name": "转移备案管理",
            "url": "<?php echo U('Home/ProductionRecord/transfer_record_query');?>"
        }]
    }, {
        "sidebar_group_id": 1,
        "sidebar_group_title": "扩展功能",
        "sidebar_group_content": [{
            "id": 0,
            "name": "扩展功能_1",
            "url": "#"
        }, {
            "id": 1,
            "name": "扩展功能_2",
            "url": "#"
        }]
    }]
}
</script>
<div class="row">
    <div class="col-md-3">
        <div id="sidebar_container">
        </div>
    </div>
    <div class="col-md-9">
        <div id="content_page">
        </div>
    </div>
</div>
<script type="text/javascript">
function sidebar_generator() {
    if (typeof(DWMS_sidebar_config) == 'undefined') {
        console.log("Error:var DWMS_sidebar_config Not Found.");
        return;
    }

    var grp_idx, itm_idx;
    var newHtml = '<div class="panel-group" id="accordion">';
    var tmpid = "";
    for (grp_idx in DWMS_sidebar_config.sidebar_groups) {

        newHtml += '<div class="panel panel-primary"><div class="panel-heading"><a data-toggle="collapse" data-toggle="collapse" data-parent="#accordion" style="color:white" href="#collapse_' + grp_idx + '"><h4 class="panel-title"><span class="glyphicon glyphicon-th-list"> ' + DWMS_sidebar_config.sidebar_groups[grp_idx].sidebar_group_title + ' </h4></a></div><div id="collapse_' + grp_idx;

        if (grp_idx == 0) {
            newHtml += '" class="panel-collapse collapse in" ><div class="panel-body" ><ul class="nav nav-pills nav-stacked DWMS-sidebar-content">';
        } else {
            newHtml += '"class="panel-collapse collapse"><div class="panel-body" ><ul class="nav nav-pills nav-stacked DWMS-sidebar-content">';
        }


        for (itm_idx in DWMS_sidebar_config.sidebar_groups[grp_idx].sidebar_group_content) {
            tmpid = "sidebarItem_" + grp_idx + "_" + itm_idx;
            newHtml += '<li id="' + tmpid + '"><a href="#" onclick="refresh_sidebar(\'' + tmpid + '\'); fetch_page(\'' + DWMS_sidebar_config.sidebar_groups[grp_idx].sidebar_group_content[itm_idx].url + '\')"><span class="glyphicon glyphicon-book"></span> ' + DWMS_sidebar_config.sidebar_groups[grp_idx].sidebar_group_content[itm_idx].name + '</a></li>'
        }

        newHtml += "</ul></div></div></div>";

    }
    newHtml += "</div>";
    $("#sidebar_container").html(newHtml);
}

sidebar_generator();


function fetch_page(ajaxURL) {

    last_ajaxURL = ajaxURL;
    $("#content_page").html('<center style="margin-top:100px"><h4>努力地加载中...</h4><div class="progress progress-striped active" style="width: 50%"><div class="progress-bar"  role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div></div></center>');

    $.ajax({
        type: "get",
        url: ajaxURL,
        dataType: "json",
        success: function(data) {
            $("#content_page").hide();
            $("#content_page").html(data);
            $("#content_page").fadeIn();
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            console.log("Error:Ajax_Content_Load" + errorThrown);
            console.log("XMLHttpRequest.status:" + XMLHttpRequest.status);
            console.log("XMLHttpRequest.readyState:" + XMLHttpRequest.readyState);
            console.log("textStatus:" + textStatus);
        }
    });
}

function refresh_sidebar(itemID) {
    $(".DWMS-sidebar-content").children().removeClass('active');
    $("#" + itemID).addClass('active');
}


last_ajaxURL = 0;

function refresh_page() {
    if (last_ajaxURL == 0) {
        console.log("Error:last_ajaxURL undefined.");
        return -1;
    }
    fetch_page(last_ajaxURL);
    return 0;
}

$("#sidebarItem_0_0 a").click();

</script>

</div>
        </div>
        <!-- My JavaScript-->
<script type="text/javascript" src="__PUBLIC__/js/datetime.js"></script>

<div class="panel panel-info" id="div_footer">
    <div class="panel-heading"></div>
    <div class="panel panel-body" id="footer-content">
    	<b>危险废物管理信息系统 DWMS</b> Powered By ThinkPHP
        <br/>Copyright © 2014-2015<br/> <span class="glyphicon glyphicon-send"></span> SJTU OMNILab
    </div>
</div>


        <script type="text/javascript">
function menu_generator() {
    if (typeof(DWMS_page_config) == 'undefined') {
        console.log("Error:var DWMS_page_config Not Found.");
        return;
    }
    var idx;
    var newHtml = '<ul class="nav nav-pills">';
    for (idx in DWMS_page_config.menu) {

        if (DWMS_page_config.menu[idx].id == DWMS_page_config.pageid) {
            newHtml += '<li class="active"><a><span class="glyphicon glyphicon-folder-open"></span> ' + DWMS_page_config.menu[idx].name + '</a></li>';
        } else {
            newHtml += '<li><a href="' + DWMS_page_config.menu[idx].url + '"><span class="glyphicon glyphicon-folder-close"></span> ' + DWMS_page_config.menu[idx].name + '</a></li>';
        }
    }
    newHtml += "</ul>";
    $("#header_button_container").html(newHtml);
}

menu_generator();

</script>

    </div>
</body>

</html>