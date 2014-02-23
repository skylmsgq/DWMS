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
        <div class="panel panel-default" id="div_header" style="margin-top:15px">
    <div class="panel-body" style="padding-top:0px">
        <img id="logo" src="__PUBLIC__/image/header_logo.jpg" alt="logo"/>
        <div id="webpage_title">
            <div id="datetime"></div>
            <h2 id="title">危险废物管理信息系统</h2>
            <p id="welcome">
                <span class="glyphicon glyphicon-user"></span> 欢迎您，<?php echo ((session('jurisdiction_name'))?(session('jurisdiction_name')):"环保局"); ?>的<?php echo ((session('username'))?(session('username')):"先生"); ?>
                <a id="password" href=#><span class="glyphicon glyphicon-edit"></span> 修改密码</a>
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


        <div class="panel panel-default">
            <div class="panel-body" id="content-container-panel"><script type="text/javascript">
DWMS_page_config = {
    "menu": [{
        "id": 0,
        "name": "首页",
        "url": "<?php echo U('Home/LoginReception/homepage');?>"
    }, {
        "id": 1,
        "name": "企业基本信息",
        "url": "<?php echo U('Home/ReceptionBasic/basic_sidebar');?>"
    }, {
        "id": 2,
        "name": "危废库存查询",
        "url": "<?php echo U('Home/ReceptionWarehouse/warehouse_sidebar');?>"
    }, {
        "id": 4,
        "name": "转移联单",
        "url": "<?php echo U('Home/ReceptionManifest/manifest_sidebar');?>"
    }],
}
</script>

<div id="index_menu_container"></div>
<script type="text/javascript">
DWMS_page_config.pageid = 0;
DWMS_index_menu_config={
 "menu": [
    {
       "id":0,
       "name":"企业基本信息",
       "url":"reception?id=basic_sidebar",
       "icon":"1.png" 
    },
      
       {
       "id":1,
       "name":"危废入库记录",
       "url":"#",
       "icon":"3.png" 
    },

       {
       "id":2,
       "name":"转移联单处理",
       "url":"#",
       "icon":"5.png" 
    },
     {
       "id":3,
       "name":"企业基本信息修改",
       "url":"#",
       "icon":"2.png" 
    },
    
      {
       "id":4,
       "name":"危废在库查询",
       "url":"#",
       "icon":"4.png" 
    },

       {
       "id":5,
       "name":"转移联单查询",
       "url":"#",
       "icon":"7.png" 
    },         
]};

</script>

<script type="text/javascript">
    function homepage_generator() {
    newHtml='<div class="panel panel-primary"><div class="panel-heading">功能菜单</div><div class="panel-body" style="padding-left:50px;padding_right:50px">';
        for(var idx in DWMS_index_menu_config.menu)
        {
            if(idx==0) //first row start
                    {
                        newHtml+='<div class="row" style="margin-bottom:20px;margin-top:20px">';
                    }
            else if(idx%4==0) //last row ending+next row start
                    {
                        newHtml+='</div><div class="row" style="margin-bottom:20px;margin-top:20px">';
                    }
                    newHtml +='<div class="col-md-3"><center><a href="'
                             +DWMS_index_menu_config.menu[idx].url
                             +' "><img src="__PUBLIC__/icons/'
                             +DWMS_index_menu_config.menu[idx].icon
                             +'"><h4>'
                             +DWMS_index_menu_config.menu[idx].name
                             +'</h4></a></center></div>';   
        }
        newHtml+="</div></div></div>";
        $("#index_menu_container").html(newHtml);
    }

    homepage_generator();
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