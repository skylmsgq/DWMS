<?php if (!defined('THINK_PATH')) exit();?><form role="form" id="manifest_modify">
    <div class="panel panel-primary">
        <div class="panel-heading">产生单位信息</div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover table-condensed">
                <tr>
                    <td>单位名称</td>
                    <td>
                        <?php echo ($production_unit["production_unit_name"]); ?>
                    </td>
                    <td>单位用户名称</td>
                    <td>
                        <?php echo ($production_unit["production_unit_username"]); ?>
                    </td>
                </tr>
                <tr>
                    <td>法人代码</td>
                    <td>
                        <?php echo ($production_unit["production_unit_legal_person_code"]); ?>
                    </td>
                    <td>单位地址</td>
                    <td>
                        <?php echo ($production_unit["production_unit_address"]); ?>
                    </td>
                </tr>
                <tr>
                    <td>邮政编码</td>
                    <td>
                        <?php echo ($production_unit["production_unit_postcode"]); ?>
                    </td>
                    <td>所在区县</td>
                    <td>
                        <?php echo ($production_unit["waste_location_county"]); ?>
                    </td>
                </tr>
                <tr>
                    <td>联系人姓名</td>
                    <td>
                        <?php echo ($production_unit["production_unit_contacts_name"]); ?>
                    </td>
                    <td>联系电话</td>
                    <td>
                        <?php echo ($production_unit["production_unit_contacts_phone"]); ?>
                    </td>
                </tr>
                <tr>
                    <td>单位传真</td>
                    <td>
                        <?php echo ($production_unit["production_unit_fax"]); ?>
                    </td>
                    <td>产废设施所在地</td>
                    <td>
                        <?php echo ($production_unit["waste_location"]); ?>
                    </td>
                </tr> 
            </table>
            </div>
        </div>
    </div>     

    <div class="panel panel-primary">
        <div class="panel-heading">基本信息</div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover table-condensed">
                <tr>
                    <td>运输单位</td>
                    <td>
                        <?php echo ($t_name); ?>
                    </td>
                    <td>接受单位</td>
                    <td>
                        <?php echo ($r_name); ?>
                    </td>
                </tr>                 
                <tr>
                    <td>危废数量（袋/个）</td>
                    <td>
                        <?php echo ($manifest["waste_num"]); ?>
                    </td>
                    <td>危废重量（桶/公斤）</td>
                    <td>
                        <?php echo ($manifest["waste_weight"]); ?>
                    </td>
                </tr>
                <tr>
                    <td>危废包装方式</td>
                    <td>
                        <select type="text" name="waste_package" id="waste_package" class="form-control input-sm required-cn" placeholder="<?php echo ($manifest["waste_package"]); ?>" value="<?php echo ($manifest["waste_package"]); ?>">
                            
                        </select>
                    </td>
                    <td>危废外运目的</td>
                    <td>
                        <select type="text" name="waste_transport_goal" id="waste_transport_goal" class="form-control input-sm required-cn" placeholder="<?php echo ($manifest["waste_transport_goal"]); ?>" value="<?php echo ($manifest["waste_transport_goal"]); ?>">
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>应急措施</td>
                    <td>
                        <input type="text" name="emergency_measure" class="form-control input-sm" placeholder="<?php echo ($manifest["emergency_measure"]); ?>" value="<?php echo ($manifest["emergency_measure"]); ?>">
                    </td>
                    <td>危废发运人</td>
                    <td>
                        <input type="text" name="waste_shipper" class="form-control input-sm required-cn" placeholder="<?php echo ($manifest["waste_shipper"]); ?>" value="<?php echo ($manifest["waste_shipper"]); ?>">
                    </td>
                </tr>
                <tr>
                    <td>危废运达地</td>
                    <td>
                        <input type="text" name="waste_destination" class="form-control input-sm required-cn" placeholder="<?php echo ($manifest["waste_destination"]); ?>" value="<?php echo ($manifest["waste_destination"]); ?>">
                        <!-- <?php echo ($reception_unit["reception_unit_address"]); ?> -->
                    </td>
                    <td>危废转移时间</td>
                    <td>
                        <input type="date" name="waste_transport_time" class="form-control input-sm required-cn" placeholder="$manifest.waste_transport_time" value="<?php echo ($manifest["waste_transport_time"]); ?>">
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>

</form>

<center>
    <button class="btn btn-warning btn-lg" onclick="ajaxAction()">修改备案</button>
    <button class="btn btn-info btn-lg" onclick="$('#myModal').modal('hide');">关闭页面</button>
</center>
<script type="text/javascript" src="__PUBLIC__/js/jquery-validate.min.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/jquery-myvalidate.js"></script>
<script>
$("#manifest_modify").validate();
</script>
<script type="text/javascript">
$("#waste_package").html('<option>' + '<?php echo ($manifest["waste_package"]); ?>' + '</option>');
for(var idx in package_method){   
    $("#waste_package").append('<option value="' + package_method[idx].package_method + '">' + package_method[idx].package_method + '</option>')
}

$("#waste_transport_goal").html('<option>' + '<?php echo ($manifest["waste_transport_goal"]); ?>' + '</option>');
for(var idx in waste_disposal_method){   
    $("#waste_transport_goal").append('<option value="' + waste_disposal_method[idx].waste_disposal_method + '">' + waste_disposal_method[idx].waste_disposal_method + '</option>')
}

function ajaxAction() {
    if(!$('#manifest_modify').valid()){
        return;
    }
    var form_serialize = "" + $('#manifest_modify').serialize();

    $("#model-content").html('<center style="margin:50px"><h4>提交中...</h4><div class="progress progress-striped active" style="width: 50%"><div class="progress-bar"  role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div></div></center>');

    $.ajax({
        type: "post",
        url: "transfer_manifest_query_modified?manifest_id=" + manifest_id_json,
        timeout: 2000,
        data: form_serialize + '&manifest_status_old=' + manifest_status_json,
        success: function(data) {
            $('#myModal').modal('hide');
            $('#myModal').on('hidden.bs.modal', function(e) {
                refresh_page();
            });
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