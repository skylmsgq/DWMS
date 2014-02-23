<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>

<html lang="zh-cn">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/waste/www/Public/image/favicon.png">

    <title>危险废物管理信息系统</title>

    <!-- Bootstrap core CSS -->
    <link href="/waste/www/Public/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/waste/www/Public/css/signin.css" rel="stylesheet">

    <script type="text/javascript" src="/waste/www/Public/js/jquery-2.0.3.min.js"></script>
    <script type="text/javascript" src="/waste/www/Public/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/waste/www/Public/js/jquery-validate.min.js"></script>
    <script type="text/javascript">
  
    function sel_city(province_id){
        console.log(province_id);
          $.ajax({
            type: "post",
            url: "/waste/www/index.php/Home/Register/select_city_name.html",
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
        console.log(city_id);
          $.ajax({
            type: "post",
            url: "/waste/www/index.php/Home/Register/select_county_name.html",
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
        console.log(county_name);
        $.ajax({
            type: "post",
            url: "/waste/www/index.php/Home/Register/select_code_jurisdiction.html",
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
                $('#jurisdiction_id').html('<option>管辖权属</option>');
                for (var idx in jurisdiction) {
                $('#jurisdiction_id').append('<option value="' + jurisdiction[idx].jurisdiction_id + '">' + jurisdiction[idx].jurisdiction_name + '</option>');
                }

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
            url: "/waste/www/index.php/Home/Register/select_code.html",
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
                code = JSON.parse(code_json);  
                $('#reception_unit_county_code').html('<option>区县代码</option>');
                for (var idx in county_name) {
                $('#reception_unit_county_code').append('<option value="' + code[idx].county_code + '">' + code[idx].county_code + '</option>');
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
    </script>
</head>

<body style="background:url(/waste/www/Public/image/bg_3.jpg) no-repeat;  background-color:#3D80AD;">
    <div class="container">
        <div class="panel panel-primary" id="login-panel" style="margin-top:20px">
            <div class="panel-heading">
                <h4>注册接受单位</h4>
            </div>
            <div class="panel-body" style="">

                <form role="form" method="post" id="receptionForm" action="/waste/www/index.php/Home/Register/do_reg/id/reception.html">

                    <div class="table-responsive">
                        <big>
                            <div class="alert alert-info">账户信息</div>
                            <table class="table table-striped table-bordered table-hover table-condensed">
                                <tr>
                                    <td>用户名</td>
                                    <td>
                                        <input type="text" class="form-control required-cn" name="username" id="username" placeholder="用户名">
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
                                    <td>接受单位名称</td>
                                    <td>
                                        <input type="text" class="form-control input-md required-cn" name="reception_unit_name" id="reception_unit_name">
                                    </td>
                                    <td>接受单位用户名称</td>
                                    <td>
                                        <input type="text" class="form-control input-md required-cn" name="reception_unit_username" id="reception_unit_username">
                                    </td>
                                </tr>
                                <tr>
                                    <td>接受单位组织机构代码</td>
                                    <td>
                                        <input type="text" class="form-control input-md required-cn" name="reception_unit_code" id="reception_unit_code">
                                    </td>
                                    <td>接受单位电话</td>
                                    <td>
                                        <input type="text" class="form-control input-md required-cn" name="reception_unit_phone" id="reception_unit_phone">
                                    </td>
                                </tr>
                                <tr>
                                    <td>接受单位地址</td>
                                    <td>
                                        <input type="text" class="form-control input-md required-cn" name="reception_unit_address" id="reception_unit_address">
                                    </td>
                                    <td>接受单位邮编</td>
                                    <td>
                                        <input type="text" class="form-control input-md required-cn" name="reception_unit_postcode" id="reception_unit_postcode">
                                    </td>
                                </tr>
                                <tr>
                                    <td>接受单位所在省</td>
                                    <td>
                                        <select type="text" class="form-control input-md required-cn" name="reception_unit_province" id="province_name" onchange="sel_city(this.options[this.options.selectedIndex].value)">
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
                                    <td>接受单位所在市</td>
                                    <td>
                                        <label class="sr-only" for="city_name">所在市：</label>
                                        <select type="text" class="form-control input-md required-cn" name="reception_unit_city" id="city_name" onchange="sel_county(this.options[this.options.selectedIndex].value)">
                                            <option>请选择所在市</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>接受单位所在区县</td>
                                    <td>
                                        <label class="sr-only" for="county_name">所在县：</label>
                                        <select type="text" class="form-control input-md required-cn" name="reception_unit_county" id="county_name" onchange="county_code_jurisdiction(this.options[this.options.selectedIndex].value)">
                                            <option>请选择所在区县</option>
                                        </select>
                                    </td>
                                    <td>接受单位所在区县代码</td>
                                    <td>
                                        <label class="sr-only" for="reception_unit_county_code">区县代码：</label>
                                        <select type="text" class="form-control input-md required-cn" name="reception_unit_county_code" id="reception_unit_county_code">
                                            <option>区县代码</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>接受单位管辖权属</td>
                                    <td>
                                        <label class="sr-only" for="jurisdiction_id">管辖权属：</label>
                                        <select type="text" class="form-control input-md required-cn" name="jurisdiction_id" id="jurisdiction_id">
                                            <option>管辖权属</option>
                                        </select>
                                    </td>
                                    <td>接受单位所属行业</td>
                                    <td>
                                        <input type="text" class="form-control input-md" name="reception_unit_trade" id="reception_unit_trade">
                                    </td>
                                </tr>
                                <tr>
                                    <td>接受单位乡镇街道</td>
                                    <td>
                                        <input type="text" class="form-control input-md" name="reception_unit_street" id="reception_unit_street">
                                    </td>
                                    <td>接受单位注册类型</td>
                                    <td>
                                        <select type="text" class="form-control input-md" name="reception_unit_registration_type" id="reception_unit_registration_type">
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
                                </tr>
                                <tr>
                                    <td>接受单位企业规模</td>
                                    <td>
                                        <select type="text" class="form-control input-md" name="reception_unit_enterprise_scale" id="reception_unit_enterprise_scale">
                                            <option>特大型</option>
                                            <option>大型一档</option>
                                            <option>大型二档</option>
                                            <option>中型一档</option>
                                            <option>中型二档</option>
                                            <option>小型</option>
                                            <option>其他</option>
                                        </select>
                                    </td>
                                    <td>接受单位许可证编号</td>
                                    <td>
                                        <input type="text" class="form-control input-md required-cn" name="reception_unit_license_num" id="reception_unit_license_num">
                                    </td>
                                </tr>
                                <tr>
                                    <td>接受单位许可证文号</td>
                                    <td>
                                        <input type="text" class="form-control input-md required-cn" name="reception_unit_reference_num" id="reception_unit_reference_num">
                                    </td>
                                    <td>许可证发证机关</td>
                                    <td>
                                        <input type="text" class="form-control input-md required-cn" name="license_issuing_authority" id="license_issuing_authority">
                                    </td>
                                </tr>
                                <tr>
                                    <td>许可证发证日期</td>
                                    <td>
                                        <input type="date" class="form-control input-md required-cn" name="license_issuing_date" id="license_issuing_date">
                                    </td>
                                    <td>许可证有效期至</td>
                                    <td>
                                        <input type="date" class="form-control input-md required-cn" name="license_expiry_date" id="license_expiry_date">
                                    </td>
                                </tr>
                                <tr>
                                    <td>接受单位环保联系人姓名</td>
                                    <td>
                                        <input type="text" class="form-control input-md required-cn" name="reception_unit_contacts_name" id="reception_unit_contacts_name">
                                    </td>
                                    <td>接受单位环保联系人电话</td>
                                    <td>
                                        <input type="text" class="form-control input-md required-cn" name="reception_unit_contacts_phone" id="reception_unit_contacts_phone">
                                    </td>
                                </tr>
                                <tr>
                                    <td>接受单位法人代码</td>
                                    <td>
                                        <input type="text" class="form-control input-md required-cn" name="reception_unit_legal_person_code" id="reception_unit_legal_person_code">
                                    </td>
                                    <td>接受单位法人姓名</td>
                                    <td>
                                        <input type="text" class="form-control input-md required-cn" name="reception_unit_legal_person_name" id="reception_unit_legal_person_name">
                                    </td>
                                </tr>
                                <tr>
                                    <td>接受单位法人电话</td>
                                    <td>
                                        <input type="text" class="form-control input-md required-cn" name="reception_unit_legal_person_phone" id="reception_unit_legal_person_phone">
                                    </td>
                                    <td>接受单位传真</td>
                                    <td>
                                        <input type="text" class="form-control input-md" name="reception_unit_fax" id="reception_unit_fax">
                                    </td>
                                </tr>
                                <tr>
                                    <td>接受单位邮箱地址</td>
                                    <td>
                                        <input type="text" class="form-control input-md" name="reception_unit_email" id="reception_unit_email">
                                    </td>
                                    <td>接受单位中心经度</td>
                                    <td>
                                        <input type="text" class="form-control input-md number-cn" name="reception_unit_longitude" id="reception_unit_longitude">
                                    </td>
                                </tr>
                                <tr>
                                    <td>接受单位中心纬度</td>
                                    <td>
                                        <input type="text" class="form-control input-md number-cn" name="reception_unit_latitude" id="reception_unit_latitude">
                                    </td>
                                </tr>

                            </table>
                        </big>
                    </div>

                    <center>
                        <button type="submit" class="btn btn-warning btn-lg">提交</button>
                    </center>
                </form>
                <script type="text/javascript" src="/waste/www/Public/js/jquery-myvalidate.js"></script>
                <script>
                $("#receptionForm").validate();
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