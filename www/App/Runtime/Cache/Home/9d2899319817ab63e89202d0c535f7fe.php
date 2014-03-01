<?php if (!defined('THINK_PATH')) exit();?><script>username = ["admin","country","province","city","district","production","transport","reception","this this for test","this this for test","yao","this this for test","this this for test","this this for test","this this for test","this this for test","gdbnwy","production2","sky","sky","sky","sky","sky","sky","sky","sky","sky","sky","sky","sky","sky","123","123456","123456","12345678","12345678","123456789","12345600","12345600","12345600","12345601","12345604","12345606","123456069","123456069","reception3","1234yao","yaotest","yaotest","12345678","12345678","188019","87654321","87654321","188019","188019","188019","188019","188019","188020","188020","188020","188020","188021","188022","188023","188024","188025","188026","188027","188028","188029","188030","188031","188032","188035","188037","188038","188039","188040","188041","188042","188043","188050","188051","188052","production","xinfuhuagong","123123213","12321321","12312321312312321","1232132","sky@gmail.com","sky@gmail.com123","sky@gmail.com123","sky@gmail.com12332","product","sky@gmail.com1232","sky@gmail.com123221"]; enterprise_scale = [{"enterprise_scale_id":"1","enterprise_scale_code":"1","enterprise_scale_name":"u7279u5927u578b"},{"enterprise_scale_id":"2","enterprise_scale_code":"2","enterprise_scale_name":"u5927u578bu4e00u6863"},{"enterprise_scale_id":"3","enterprise_scale_code":"3","enterprise_scale_name":"u5927u578bu4e8cu6863"},{"enterprise_scale_id":"4","enterprise_scale_code":"4","enterprise_scale_name":"u4e2du578bu4e00u6863"},{"enterprise_scale_id":"5","enterprise_scale_code":"5","enterprise_scale_name":"u4e2du578bu4e8cu6863"},{"enterprise_scale_id":"6","enterprise_scale_code":"6","enterprise_scale_name":"u5c0fu578b"},{"enterprise_scale_id":"7","enterprise_scale_code":"7","enterprise_scale_name":"u5176u4ed6"}];</script> <!DOCTYPE html>

<html lang="zh-cn">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/DWMS/www/Public/image/favicon.png">

    <title>危险废物管理信息系统</title>

    <!-- Bootstrap core CSS -->
    <link href="/DWMS/www/Public/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/DWMS/www/Public/css/signin.css" rel="stylesheet">

    <script type="text/javascript" src="/DWMS/www/Public/js/jquery-2.0.3.min.js"></script>
    <script type="text/javascript" src="/DWMS/www/Public/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/DWMS/www/Public/js/jquery-validate.min.js"></script>
    <script type="text/javascript">



    function sel_city(province_id){
        // console.log(province_id);
          $.ajax({
            type: "post",
            url: "/DWMS/www/index.php/Home/Register/select_city_name.html",
            dataType: "json",
            data:{
                'id': province_id
            },
            success: function(city_name_json) {
                city_name = JSON.parse(city_name_json);
                $('#city_name').html('<option>请选择所在市</option>');
                for (var idx in city_name) {
                $('#city_name').append('<option value="' + city_name[idx].county_id + '">' + city_name[idx].county_name + '</option>');
                }   
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                console.log("Error:Ajax_Content_Load" + errorThrown);
                console.log("XMLHttpRequest.status:" + XMLHttpRequest.status);
                console.log("XMLHttpRequest.readyState:" + XMLHttpRequest.readyState);
                console.log("textStatus:" + textStatus);
            }
         });
    }

     function sel_county(city_id){
        // console.log(city_id);
          $.ajax({
            type: "post",
            url: "/DWMS/www/index.php/Home/Register/select_county_name.html",
            dataType: "json",
            data:{
                'id': city_id
            },
            success: function(county_name_json) {
                county_name = JSON.parse(county_name_json);
                $('#county_name').html('<option>请选择所在区县</option>');
                for (var idx in county_name) {
                $('#county_name').append('<option value="' + county_name[idx].county_name + '">' + county_name[idx].county_name + '</option>');
                }
                
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                console.log("Error:Ajax_Content_Load" + errorThrown);
                console.log("XMLHttpRequest.status:" + XMLHttpRequest.status);
                console.log("XMLHttpRequest.readyState:" + XMLHttpRequest.readyState);
                console.log("textStatus:" + textStatus);
            }
         });
    }

    function county_code_jurisdiction(county_name){
        // console.log(county_name);
        $.ajax({
            type: "post",
            url: "/DWMS/www/index.php/Home/Register/select_code_jurisdiction.html",
            dataType: "json",
            data:{
                'name': county_name
            },
            success: function(jurisdiction_json) {
                // county_code = JSON.parse(county_code_json);
                // $('#waste_location_county_code').html('<option>区县代码</option>');
                // for (var idx in county_code) {
                // $('#waste_location_county_code').append('<option value="' + county_code[idx].county_id + '">' + county_name[idx].county_code + '</option>');
                // }
                jurisdiction = JSON.parse(jurisdiction_json);  
                $('#jurisdiction_id').html('<option value="' + jurisdiction[0].jurisdiction_id + '">' + jurisdiction[0].jurisdiction_name + '</option>');
                // for (var idx in jurisdiction) {
                // $('#jurisdiction_id').append('<option value="' + jurisdiction[idx].jurisdiction_id + '">' + jurisdiction[idx].jurisdiction_name + '</option>');
                // }

            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                console.log("Error:Ajax_Content_Load" + errorThrown);
                console.log("XMLHttpRequest.status:" + XMLHttpRequest.status);
                console.log("XMLHttpRequest.readyState:" + XMLHttpRequest.readyState);
                console.log("textStatus:" + textStatus);
            }
        });

    $.ajax({
            type: "post",
            url: "/DWMS/www/index.php/Home/Register/select_code.html",
            dataType: "json",
            data:{
                'name': county_name
            },
            success: function(code_json) {
                // county_code = JSON.parse(county_code_json);
                // $('#waste_location_county_code').html('<option>区县代码</option>');
                // for (var idx in county_code) {
                // $('#waste_location_county_code').append('<option value="' + county_code[idx].county_id + '">' + county_name[idx].county_code + '</option>');
                // }
                var code = JSON.parse(code_json);  
               // $('#waste_location_county_code').html('<option>code[0]['county_code']</option>');
                console.log(code);
               // for (var idx in county_name) {
                $('#waste_location_county_code').html("<option>"+code[0]['county_code']+"</option>");
              //  }   

            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                console.log("Error:Ajax_Content_Load" + errorThrown);
                console.log("XMLHttpRequest.status:" + XMLHttpRequest.status);
                console.log("XMLHttpRequest.readyState:" + XMLHttpRequest.readyState);
                console.log("textStatus:" + textStatus);
            }
        });
    }
    </script>

</head>

<body style="background:url(/DWMS/www/Public/image/bg_3.jpg) no-repeat;  background-color:#3D80AD;">
    <div class="container">
        <div class="panel panel-primary" id="login-panel" style="margin-top:20px">
            <div class="panel-heading">
                <h4>注册生产单位</h4>
            </div>
            <div class="panel-body" style="">

                <form role="form" method="post" id="productionForm" action="/DWMS/www/index.php/Home/Register/do_reg/id/production.html">

                    <div class="table-responsive">
                        <big>
                            <div class="alert alert-info">账户信息</div>
                            <table class="table table-striped table-bordered table-hover table-condensed">
                                <tr>
                                    <td>用户名</td>
                                    <td>
                                        <input type="text" class="form-control required-cn pwdEqual_1" name="username" id="username" placeholder="用户名">
                                    </td>
                                </tr>
                                <tr>
                                    <td>密码</td>
                                    <td>
                                        <input type="password" class="form-control required-cn" name="password" id="password" placeholder="密码">
                                    </td>
                                </tr>
                                <tr>
                                    <td>确认密码</td>
                                    <td>
                                        <input type="password" class="form-control required-cn pwdEqual" id="re-password" placeholder="确认密码">
                                    </td>
                                </tr>
                                <tr>
                                    <td>电子邮件</td>
                                    <td>
                                        <input type="email" class="form-control" name="email" id="email" placeholder="电子邮件">
                                    </td>
                                </tr>
                                <tr>
                                    <td>手机号码</td>
                                    <td>
                                        <input type="text" class="form-control" name="phone_num" id="phone_num" placeholder="手机号码">
                                    </td>
                                </tr>
                            </table>
                            <div class="alert alert-info">企业信息</div>
                            <table class="table table-striped table-bordered table-hover table-condensed">

                                <tr>
                                    <td>产生单位名称</td>
                                    <td>
                                        <input type="text" class="form-control input-md required-cn" name="production_unit_name" id="production_unit_name">
                                    </td>
                                    <td>产生单位用户名称</td>
                                    <td>
                                        <input type="text" class="form-control input-md required-cn" name="production_unit_username" id="production_unit_username">
                                    </td>
                                </tr>
                                <tr>
                                    <td>产生单位组织机构代码</td>
                                    <td>
                                        <input type="text" class="form-control input-md required-cn" name="production_unit_code" id="production_unit_code">
                                    </td>
                                    <td>产生单位电话</td>
                                    <td>
                                        <input type="text" class="form-control input-md required-cn" name="production_unit_phone" id="production_unit_phone">
                                    </td>
                                </tr>
                                <tr>
                                    <td>产生单位地址</td>
                                    <td>
                                        <input type="text" class="form-control input-md required-cn" name="production_unit_address" id="production_unit_address">
                                    </td>
                                    <td>产生单位邮编</td>
                                    <td>
                                        <input type="text" class="form-control input-md required-cn" name="production_unit_postcode" id="production_unit_postcode">
                                    </td>
                                </tr>
                                <tr>
                                    <td>产废设施所属省</td>
                                    <td>
                                         <select type="text" class="form-control input-md required-cn" id="province_name" name="production_unit_province" onchange="sel_city(this.options[this.options.selectedIndex].value)">
                                          <option value="1">北京市</option>
                                          <option value="2">天津市</option>
                                          <option value="3">河北省</option>
                                          <option value="4">山西省</option>
                                          <option value="5">内蒙古自治区</option>
                                          <option value="6">辽宁省</option>
                                          <option value="7">吉林省</option>
                                          <option value="8">黑龙江省</option>
                                          <option value="9">上海市</option>
                                          <option value="10">江苏省</option>
                                          <option value="11">浙江省</option>
                                          <option value="12">安徽省</option>
                                          <option value="13">福建省</option>
                                          <option value="14">江西省</option>
                                          <option value="15">山东省</option>
                                          <option value="16">河南省</option>
                                          <option value="17">湖北省</option>
                                          <option value="18">湖南省</option>
                                          <option value="19">广东省</option>
                                          <option value="20">广西壮族自治区</option>
                                          <option value="21">海南省</option>
                                          <option value="22">重庆市</option>
                                          <option value="23">四川省</option>
                                          <option value="24">贵州省</option>
                                          <option value="25">云南省</option>
                                          <option value="26">西藏自治区</option>
                                          <option value="27">陕西省</option>
                                          <option value="28">甘肃省</option>
                                          <option value="29">青海省</option>
                                          <option value="30">宁夏回族自治区</option>
                                          <option value="31">新疆维吾尔自治区</option>
                                          <option value="32">台湾省</option>
                                          <option value="33">香港特别行政区</option>
                                        </select>
                                    </td>
                                    <td>产废设施所属市</td>
                                    <td>
                                        <select type="text" class="form-control input-md required-cn" id="city_name" name="production_unit_city" onchange="sel_county(this.options[this.options.selectedIndex].value)">
                                            <option>请选择所在市</option>
                                        </select>
                                        <!-- <input type="text" class="form-control input-md required-cn" name="waste_location" id="waste_location"> -->
                                    </td>
                                </tr>
                                <tr>
                                    <td>产废设施所属区县</td>
                                    <td>
                                        <select type="text" class="form-control input-md required-cn" name="waste_location_county" id="county_name" onchange="county_code_jurisdiction(this.options[this.options.selectedIndex].value)">
                                            <option>请选择所在区县</option>
                                        </select>
                                    </td>
                                    <td>产废设施所在地</td>
                                    <td>
                                        <input type="text" class="form-control input-md required-cn" name="waste_location" id="waste_location">
                                    </td>
                                </tr>
                                <tr>
                                    <td>产废设施所在区县代码</td>
                                    <td>
                               <!--     <input type="text" class="form-control input-md required-cn" name="waste_location_county_code" id="waste_location_county_code"> -->
                   
                                    <select type="text" class="form-control input-md required-cn" name="waste_location_county_code" id="waste_location_county_code">
                                            <!-- <option>区县代码</option> -->
                                        </select>                                    
                                    </td>


                                    
                                    <!-- <td id="waste_location_county_code"></td> -->
                                    <td>产生单位管辖权属</td>
                                    <td>
                                        <select type="text" class="form-control input-md required-cn" name="jurisdiction_id" id="jurisdiction_id">
                                            <option>管辖权属</option>
                                        </select>
                                        
                                    </td>
                                </tr>
                                <tr>
                                    <td>产生单位所属行业</td>
                                    <td>
                                        <input type="text" class="form-control input-md" name="production_unit_trade" id="production_unit_trade">  
                                    </td>
                                    <td>产生单位乡镇街道</td>
                                    <td>
                                        <input type="text" class="form-control input-md" name="production_unit_street" id="production_unit_street">
                                    </td>
                                </tr>
                                <tr>
                                    <td>产生单位注册类型</td>
                                    <td>
                                        <select type="text" class="form-control input-md" name="production_unit_registration_type" id="production_unit_registration_type">
                                            <option>国有企业</option>
                                            <option>集体企业</option>
                                            <option>股份合作企业</option>
                                            <option>国有联营企业</option>
                                            <option>集体联营企业</option>
                                            <option>国有与集体联企业</option>
                                            <option>其他联营企业</option>
                                            <option>有限责任公司</option>
                                            <option>国有独资的有限责任公司</option>
                                            <option>其他有限责任公司</option>
                                            <option>股份有限公司</option>
                                            <option>私营独资企业</option>
                                            <option>私营合作企业</option>
                                            <option>私营有限责任公司</option>
                                            <option>私营股份有限公司</option>
                                            <option>其他内资</option>
                                            <option>与港、澳、台商合资经营企业</option>
                                            <option>与港、澳、台商合作经营企业</option>
                                            <option>港、澳、台商独资经营企业</option>
                                            <option>港、澳、台商投资股份有限公司</option>
                                            <option>中外合资经营企业</option>
                                            <option>中外合作经营企业</option>
                                            <option>外商独资企业</option>
                                            <option>外商投资股份有限公司</option>
                                            <option>外商投资股份有限公司</option>
                                        </select>   
                                    </td>
                                    <td>产生单位企业规模</td>
                                    <td>
                                        <!-- <select type="text" class="form-control input-md" name="production_unit_enterprise_scale" id="production_unit_enterprise_scale"> -->
                                        <select type="text" class="form-control input-md required-cn" name="production_unit_enterprise_scale" id="production_unit_enterprise_scale">
                                            <!-- <option>特大型</option>
                                            <option>大型一档</option>
                                            <option>大型二档</option>
                                            <option>中型一档</option>
                                            <option>中型二档</option>
                                            <option>小型</option>
                                            <option>其他</option> -->
                                        </select>  
                                    </td>
                                </tr>
                                <tr>
                                    <td>产生单位环保联系人姓名</td>
                                    <td>
                                        <input type="text" class="form-control input-md required-cn" name="production_unit_contacts_name" id="production_unit_contacts_name">
                                    </td>
                                    <td>产生单位环保联系人电话</td>
                                    <td>
                                        <input type="text" class="form-control input-md required-cn" name="production_unit_contacts_phone" id="production_unit_contacts_phone">
                                    </td>
                                </tr>
                                <tr>
                                    <td>产生单位法人代码</td>
                                    <td>
                                        <input type="text" class="form-control input-md required-cn" name="production_unit_legal_person_code" id="production_unit_legal_person_code">
                                    </td>
                                    <td>产生单位法人姓名</td>
                                    <td>
                                        <input type="text" class="form-control input-md required-cn" name="production_unit_legal_person_name" id="production_unit_legal_person_name">
                                    </td>
                                </tr>
                                <tr>
                                    <td>产生单位法人电话</td>
                                    <td>
                                        <input type="text" class="form-control input-md required-cn" name="production_unit_legal_person_phone" id="production_unit_legal_person_phone">
                                    </td>
                                    <td>产生单位传真</td>
                                    <td>
                                        <input type="text" class="form-control input-md" name="production_unit_fax" id="production_unit_fax">
                                    </td>
                                </tr>
                                <tr>
                                    <td>产生单位邮箱地址</td>
                                    <td>
                                        <input type="text" class="form-control input-md" name="production_unit_email" id="production_unit_email">
                                    </td>
                                    <td>产生单位中心经度</td>
                                    <td>
                                        <input type="text" class="form-control input-md number-cn" name="production_unit_longitude" id="production_unit_longitude">
                                    </td>
                                </tr>
                                <tr>
                                    <td>产生单位中心纬度</td>
                                    <td>
                                        <input type="text" class="form-control input-md number-cn" name="production_unit_latitude" id="production_unit_latitude">
                                    </td>
                                     <td>产生单位主要危废物代码</td>
                                    <td>
                                        <select type="text" class="form-control input-md" name="production_unit_waste" id="production_unit_waste">
                                            <option>900-999-49</option>
                                            <option>900-047-49</option>
                                            <option>900-046-49</option>
                                            <option>900-045-49</option>
                                            <option>900-044-49</option>
                                            <option>900-043-49*</option>
                                            <option>900-042-49</option>
                                            <option>900-041-49</option>
                                            <option>900-040-49*</option>
                                            <option>900-039-49</option>
                                            <option>900-038-49</option>
                                            <option>800-006-49</option>
                                            <option>332-001-48</option>
                                            <option>331-029-48</option>
                                            <option>331-028-48*</option>
                                            <option>331-027-48*</option>
                                            <option>331-026-48</option>
                                            <option>331-025-48</option>
                                            <option>331-024-48</option>
                                            <option>331-023-48</option>
                                            <option>331-022-48</option>
                                            <option>331-021-48</option>
                                            <option>331-020-48</option>
                                            <option>331-019-48</option>
                                            <option>331-018-48</option>
                                        </select>
                                        <!-- <input type="text" class="form-control input-md" name="production_unit_waste" id="production_unit_waste"> -->
                                    </td>
                                </tr>
                            </table>
                        </big>
                    </div>

                    <center>
                        <button type="submit" class="btn btn-warning btn-lg">提交</button>
                    </center>
                </form>
                <script type="text/javascript" src="/DWMS/www/Public/js/jquery-myvalidate.js"></script>
                <script>
                $("#productionForm").validate();
                for (var idx in enterprise_scale) {
                    $('#production_unit_enterprise_scale').append('<option>' + {enterprise_scale[idx].enterprise_scale_name} + '</option>');
                 }
                </script>


            </div>
        </div>
        <div class="panel panel-info" id="login-panel" style="margin-top:20px">
            <div class="panel-heading">
                <h3></h3>
            </div>
            <div class="panel-body">
                <footer class="bs-footer" role="contentinfo">
                    <div class="text-center padder clearfix txt-shadow">

                        <div class="blank-div"></div>
                        危险废物管理信息系统
                        <br/>Copyright © 2014-2015
                        <br/>
                        <span class="glyphicon glyphicon-send"></span>
                        <b>SJTU OMNILab</b>
                    </div>

                </footer>
            </div>
        </div>
    </div>
    <!-- /container -->

    <!-- Placed at the end of the document so the pages load faster -->
    <!-- jQuery core JavaScript -->

</body>

</html>