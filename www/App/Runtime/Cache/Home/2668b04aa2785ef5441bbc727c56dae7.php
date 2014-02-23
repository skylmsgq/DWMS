<?php if (!defined('THINK_PATH')) exit();?><form role="form" id="manifest_submit">
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
                        <?php echo ($manifest["transport_unit_id"]); ?>
                    </td>
                    <td>接受单位</td>
                    <td>
                        <?php echo ($manifest["reception_unit_id"]); ?>
                    </td>
                </tr>                 
                <tr>
                    <td>危废编号</td>
                    <td>
                        <?php echo ($manifest["waste_id"]); ?>
                    </td>
                    <td>危废重量</td>
                    <td>
                        <?php echo ($manifest["waste_weight"]); ?>
                    </td>
                </tr>
                <tr>
                    <td>危废包装方式</td>
                    <td>
                        <?php echo ($manifest["waste_package"]); ?>
                    </td>
                    <td>危废外运目的</td>
                    <td>
                        <?php echo ($manifest["waste_goal"]); ?>
                    </td>
                </tr>
                <tr>
                    <td>应急措施</td>
                    <td>
                        <?php echo ($manifest["emergency_measure"]); ?>
                    </td>
                    <td>危废发运人</td>
                    <td>
                        <?php echo ($manifest["waste_shipper"]); ?>
                    </td>
                </tr>
                <tr>
                    <td>危废运达地</td>
                    <td>
                        <?php echo ($manifest["waste_destination"]); ?>
                        <!-- <?php echo ($reception_unit["reception_unit_address"]); ?> -->
                    </td>
                    <td>危废转移时间</td>
                    <td>
                        <?php echo ($manifest["waste_transport_time"]); ?>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>

</form>

<center>
    <button class="btn btn-warning btn-lg" onclick="ajaxAction()">提交备案</button>
    <button class="btn btn-info btn-lg" onclick="$('#myModal').modal('hide');">关闭页面</button>
</center>

<script type="text/javascript">
function ajaxAction() {
    $("#model-content").html('<center style="margin:50px"><h4>提交中...</h4><div class="progress progress-striped active" style="width: 50%"><div class="progress-bar"  role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div></div></center>');
    $.ajax({
        type: "post",
        url: "transfer_manifest_query_submited?manifest_id=" + manifest_id_json,
        timeout: 2000,
        data: {
            manifest_status_old: manifest_status_json
        },
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