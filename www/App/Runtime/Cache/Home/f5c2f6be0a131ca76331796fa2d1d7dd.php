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

<body style="background:url(/waste/www/Public/image/bg_3.jpg) no-repeat;  background-color:#3D80AD;">
    <div class="container">
        <div class="panel panel-primary" id="login-panel" style="margin-top:20px">
            <div class="panel-heading">
                <h4>注册生产单位</h4>
            </div>
            <div class="panel-body" style="">

                <form role="form" method="post" id="productionForm" action="/waste/www/index.php/Home/Register/do_reg/id/production.html">

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
<!--                                     <td>产废设施所在地</td>
                                    <td>
                                        <input type="text" class="form-control input-md required-cn" name="waste_location" id="waste_location">
                                    </td> -->
                                    <td>产废设施所属省</td>
                                    <td>
                                         <select type="text" class="form-control input-md required-cn" id="province_name" name="production_unit_province" value=this.options[this.options.selectedIndex].value onchange="sel_city(this.options[this.options.selectedIndex].value)">
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
                                        <select type="text" class="form-control input-md" name="production_unit_trade" id="production_unit_trade">
                                        <option value=1>农业</option>
                                        <option value=2>林业</option>
                                        <option value=3>畜牧业</option>
                                        <option value=4>渔业</option>
                                        <option value=5>农、林、牧、渔服务业</option>
                                        <option value=6>采掘业</option>
                                        <option value=7>煤炭采选业</option>
                                        <option value=8>石油和天然气开采业</option>
                                        <option value=9>黑色金属矿采选业</option>
                                        <option value=10>有色金属矿采选业</option>
                                        <option value=11>非金属矿采选业</option>
                                        <option value=12>采盐业</option>
                                        <option value=13>其他矿采选业</option>
                                        <option value=14>木材及竹材采运业</option>
                                        <option value=15>制造业</option>
                                        <option value=16>食品加工业</option>
                                        <option value=17>食品制造业</option>
                                        <option value=18>饮料制造业</option>
                                        <option value=19>烟草加工业</option>
                                        <option value=20>纺织业</option>
                                        <option value=21>服装及其他纤维制品制造业</option>
                                        <option value=22>皮革、毛皮、羽绒及其制品业</option>
                                        <option value=23>木材加工及竹、藤、棕、草制品业</option>
                                        <option value=24>家具制造业</option>
                                        <option value=25>造纸及纸制品业</option>
                                        <option value=26>印刷业，记录媒介的复制</option>
                                        <option value=27>文教体育用品制造业</option>
                                        <option value=28>石油加工及炼焦业</option>
                                        <option value=29>化学原料及化学制品制造业</option>
                                        <option value=30>医药制造业</option>
                                        <option value=31>生物制品业</option>
                                        <option value=32>化学纤维制造业</option>
                                        <option value=33>橡胶制品业</option>
                                        <option value=34>塑料制品业</option>
                                        <option value=35>非金属矿物制品业</option>
                                        <option value=36>黑色金属冶炼及压延加工业</option>
                                        <option value=37>有色金属冶炼及压延加工业</option>
                                        <option value=38>金属制品业</option>
                                        <option value=39>日用金属制品业</option>
                                        <option value=40>普通机械制造业</option>
                                        <option value=41>锅炉及原动机制造业</option>
                                        <option value=42>金属加工机械制造业</option>
                                        <option value=43>通用设备制造业</option>
                                        <option value=44>冶金、矿山、机电工业专用设备制造业</option>
                                        <option value=45>石化及其他工业专用设备制造业</option>
                                        <option value=46>轻纺工业专用设备制造业</option>
                                        <option value=47>农、林、牧、渔、水利业机械制造业</option>
                                        <option value=48>医疗器械制造业</option>
                                        <option value=49>其他专用设备制造业</option>
                                        <option value=50>专用机械设备修理业</option>
                                        <option value=51>铁路运输设备制造业</option>
                                        <option value=52>汽车制造业</option>
                                        <option value=53>摩托车制造业</option>
                                        <option value=54>自行车制造业</option>
                                        <option value=55>电车制造业</option>
                                        <option value=56>船舶制造业</option>
                                        <option value=57>航空航天器制造业</option>
                                        <option value=58>交通运输设备修理业</option>
                                        <option value=59>其他交通运输设备制造业</option>
                                        <option value=60>武器弹药制造业</option>
                                        <option value=61>电气机械及器材制造业</option>
                                        <option value=62>电子及通信设备制造业</option>
                                        <option value=63>通信设备制造业</option>
                                        <option value=64>电子计算机制造业</option>
                                        <option value=65>日用电子器具制造业</option>
                                        <option value=66>仪器仪表及文化、办公用机械制造业</option>
                                        <option value=67>其他制造业</option>
                                        <option value=68>电力、煤气及水的生产和供应业</option>
                                        <option value=69>电力、蒸汽、热水的生产和供应业</option>
                                        <option value=70>煤气生产和供应业</option>
                                        <option value=71>自来水的生产和供应业</option>
                                        <option value=72>建筑业</option>
                                        <option value=73>土木工程建筑业</option>
                                        <option value=74>线路、管道和设备安装业</option>
                                        <option value=75>装修装饰业</option>
                                        <option value=76>地质勘查业、水利管理业</option>
                                        <option value=77>地质勘查业</option>
                                        <option value=78>水利管理业</option>
                                        <option value=79>交通运输、仓储及邮电通信业</option>
                                        <option value=80>铁路运输业</option>
                                        <option value=81>公路运输业</option>
                                        <option value=82>管道运输业</option>
                                        <option value=83>水上运输业</option>
                                        <option value=84>航空运输业</option>
                                        <option value=85>交通运输辅助业</option>
                                        <option value=86>其他交通运输业</option>
                                        <option value=87>仓储业</option>
                                        <option value=88>邮电通信业</option>
                                        <option value=89>批发和零售贸易、餐饮业</option>
                                        <option value=90>食品、饮料、烟草和家庭日用品批发业</option>
                                        <option value=91>能源、材料和机械电子设备批发业</option>
                                        <option value=92>其他批发业</option>
                                        <option value=93>零售业</option>
                                        <option value=94>商业经纪与代理业</option>
                                        <option value=95>餐饮业</option>
                                        <option value=96>金融、保险业</option>
                                        <option value=97>金融业</option>
                                        <option value=98>保险业</option>
                                        <option value=99>房地产业</option>
                                        <option value=100>房地产开发与经营业</option>
                                        <option value=101>房地产管理业</option>
                                        <option value=102>房地产经纪与代理业</option>
                                        <option value=103>社会服务业</option>
                                        <option value=104>公共设施服务业</option>
                                        <option value=105>居民服务业</option>
                                        <option value=106>旅馆业</option>
                                        <option value=107>租赁服务业</option>
                                        <option value=108>旅游业</option>
                                        <option value=109>娱乐服务业</option>
                                        <option value=110>信息、咨询服务业</option>
                                        <option value=111>计算机应用服务业</option>
                                        <option value=112>其他社会服务业</option>
                                        <option value=113>卫生、体育和社会福利业</option>
                                        <option value=114>卫生</option>
                                        <option value=115>体育</option>
                                        <option value=116>社会福利保障业</option>
                                        <option value=117>教育、文化艺术及广播电影电视业</option>
                                        <option value=118>教育</option>
                                        <option value=119>文化艺术业</option>
                                        <option value=120>广播电影电视业</option>
                                        <option value=121>科学研究和综合技术服务业</option>
                                        <option value=122>科学研究业</option>
                                        <option value=123>气象</option>
                                        <option value=124>地震</option>
                                        <option value=125>测绘</option>
                                        <option value=126>技术监督</option>
                                        <option value=127>海洋环境</option>
                                        <option value=128>环境保护</option>
                                        <option value=129>技术推广和科技交流服务业</option>
                                        <option value=130>工程设计业</option>
                                        <option value=131>其他综合技术服务业</option>
                                        <option value=132>国家机关、政党机关和社会团体</option>
                                        <option value=133>国家机关</option>
                                        <option value=134>政党机关</option>
                                        <option value=135>社会团体</option>
                                        <option value=136>基层群众自治组织</option>
                                        <option value=137>其他行业</option>
                                        <option value=138>其他行业</option>
                                        <option value=139></option>


                                        </select>   
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
                                            <option>特大型</option>
                                            <option>大型一档</option>
                                            <option>大型二档</option>
                                            <option>中型一档</option>
                                            <option>中型二档</option>
                                            <option>小型</option>
                                            <option>其他</option>
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
                <script type="text/javascript" src="/waste/www/Public/js/jquery-myvalidate.js"></script>
                <script>
                $("#productionForm").validate();
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