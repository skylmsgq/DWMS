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

    // $.ajax({
    //         type: "post",
    //         url: "/waste/www/index.php/Home/Register/select_code.html",
    //         dataType: "json",
    //         data:{
    //             'name': county_name
    //         },
    //         success: function(code_json) {
    //             // county_code = JSON.parse(county_code_json);
    //             // $('#waste_location_county_code').html('<option>区县代码</option>');
    //             // for (var idx in county_code) {
    //             // $('#waste_location_county_code').append('<option value="' + county_code[idx].county_id + '">' + county_name[idx].county_code + '</option>');
    //             // }
    //             var code = JSON.parse(code_json);  
    //            // $('#waste_location_county_code').html('<option>区县代码</option>');
    //             console.log(code);
    //            // for (var idx in county_name) {
    //             $('#waste_location_county_code').html("<td>"+code[0]['county_code']+"</td>");
    //           //  }   

    //         },
    //         error: function(XMLHttpRequest, textStatus, errorThrown) {
    //             console.log("Error:Ajax_Content_Load" + errorThrown);
    //             console.log("XMLHttpRequest.status:" + XMLHttpRequest.status);
    //             console.log("XMLHttpRequest.readyState:" + XMLHttpRequest.readyState);
    //             console.log("textStatus:" + textStatus);
    //         }
    //     });
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
                                         <select type="text" class="form-control input-md required-cn" id="province_name" onchange="sel_city(this.options[this.options.selectedIndex].value)">
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
                                        <select type="text" class="form-control input-md required-cn" id="city_name" onchange="sel_county(this.options[this.options.selectedIndex].value)">
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
                                    <!-- <td>产废设施所在区县代码</td> -->
                                    <!-- <td> -->
<!--                                    <input type="text" class="form-control input-md required-cn" name="waste_location_county_code" id="waste_location_county_code">
 -->                   
<!--                                     <select type="text" class="form-control input-md required-cn" name="waste_location_county_code" id="waste_location_county_code">
                                            <option>区县代码</option>
                                        </select>                                    
                                    </td>

 -->
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
                                        <select type="text" class="form-control input-md" name="production_unit_registration_type" id="production_unit_registration_type">
                                        <option>1010</option>
                                        <option>1020</option>
                                        <option>1030</option>
                                        <option>1040</option>
                                        <option>1050</option>
                                        <option>2</option>
                                        <option>2060</option>
                                        <option>2070</option>
                                        <option>2080</option>
                                        <option>2090</option>
                                        <option>2100</option>
                                        <option>2103</option>
                                        <option>2110</option>
                                        <option>2120</option>
                                        <option>3</option>
                                        <option>3130</option>
                                        <option>3140</option>
                                        <option>3150</option>
                                        <option>3160</option>
                                        <option>3170</option>
                                        <option>3180</option>
                                        <option>3190</option>
                                        <option>3200</option>
                                        <option>3210</option>
                                        <option>3220</option>
                                        <option>3230</option>
                                        <option>3240</option>
                                        <option>3250</option>
                                        <option>3260</option>
                                        <option>3270</option>
                                        <option>3275</option>
                                        <option>3280</option>
                                        <option>3290</option>
                                        <option>3300</option>
                                        <option>3310</option>
                                        <option>3320</option>
                                        <option>3330</option>
                                        <option>3340</option>
                                        <option>3348</option>
                                        <option>3350</option>
                                        <option>3351</option>
                                        <option>3352</option>
                                        <option>3353</option>
                                        <option>3361</option>
                                        <option>3362</option>
                                        <option>3363</option>
                                        <option>3364</option>
                                        <option>3365</option>
                                        <option>3367</option>
                                        <option>3368</option>
                                        <option>3371</option>
                                        <option>3372</option>
                                        <option>3373</option>
                                        <option>3374</option>
                                        <option>3375</option>
                                        <option>3376</option>
                                        <option>3377</option>
                                        <option>3378</option>
                                        <option>3379</option>
                                        <option>3390</option>
                                        <option>3400</option>
                                        <option>3410</option>
                                        <option>3411</option>
                                        <option>3414</option>
                                        <option>3417</option>
                                        <option>3420</option>
                                        <option>3430</option>
                                        <option>4</option>
                                        <option>4440</option>
                                        <option>4450</option>
                                        <option>4460</option>
                                        <option>5</option>
                                        <option>5470</option>
                                        <option>5480</option>
                                        <option>5490</option>
                                        <option>6</option>
                                        <option>6500</option>
                                        <option>6510</option>
                                        <option>7</option>
                                        <option>7520</option>
                                        <option>7530</option>
                                        <option>7540</option>
                                        <option>7550</option>
                                        <option>7560</option>
                                        <option>7570</option>
                                        <option>7580</option>
                                        <option>7590</option>
                                        <option>7600</option>
                                        <option>8</option>
                                        <option>8610</option>
                                        <option>8620</option>
                                        <option>8630</option>
                                        <option>8640</option>
                                        <option>8650</option>
                                        <option>8670</option>
                                        <option>9</option>
                                        <option>9680</option>
                                        <option>9700</option>
                                        <option>10</option>
                                        <option>10720</option>
                                        <option>10730</option>
                                        <option>10740</option>
                                        <option>11</option>
                                        <option>11750</option>
                                        <option>11760</option>
                                        <option>11780</option>
                                        <option>11790</option>
                                        <option>11800</option>
                                        <option>11810</option>
                                        <option>11820</option>
                                        <option>11830</option>
                                        <option>11840</option>
                                        <option>12</option>
                                        <option>12850</option>
                                        <option>12860</option>
                                        <option>12870</option>
                                        <option>13</option>
                                        <option>13890</option>
                                        <option>13900</option>
                                        <option>13910</option>
                                        <option>14</option>
                                        <option>14920</option>
                                        <option>14931</option>
                                        <option>14932</option>
                                        <option>14933</option>
                                        <option>14934</option>
                                        <option>14935</option>
                                        <option>14936</option>
                                        <option>14937</option>
                                        <option>14938</option>
                                        <option>14939</option>
                                        <option>15</option>
                                        <option>15940</option>
                                        <option>15950</option>
                                        <option>15960</option>
                                        <option>15970</option>
                                        <option>16</option>
                                        <option>16990</option>
                                        <option></option>

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