<?php if (!defined('THINK_PATH')) exit();?><form role="form" id="device_modify">
    <div class="panel panel-primary">
        <div class="panel-heading">设备信息</div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover table-condensed">
                    <tr>
                        <td>设备名称</td>
                        <td>
                            <input type="text" name="device_name" class="form-control input-sm" placeholder="<?php echo ($device["device_name"]); ?>" value="<?php echo ($device["device_name"]); ?>">
                        </td>
                        <td>设备类型</td>
                        <td>
                            <input type="text" name="device_type" class="form-control input-sm" placeholder="<?php echo ($device["device_type"]); ?>" value="<?php echo ($device["device_type"]); ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>设备序列号</td>
                        <td>
                            <input type="text" name="device_serial_num" class="form-control input-sm" placeholder="<?php echo ($device["device_serial_num"]); ?>" value="<?php echo ($device["device_serial_num"]); ?>">
                        </td>
                        <td>设备管辖权属</td>
                        <td>
                            <input type="text" name="jurisdiction_id" class="form-control input-sm" placeholder="<?php echo ($device["jurisdiction_id"]); ?>" value="<?php echo ($device["jurisdiction_id"]); ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>设备归属企业类型</td>
                        <td>
                            <input type="text" name="ownership_type" class="form-control input-sm" placeholder="<?php echo ($device["ownership_type"]); ?>" value="<?php echo ($device["ownership_type"]); ?>">
                        </td>
                        <td>设备归属企业编号</td>
                        <td>
                            <input type="text" name="ownership_id" class="form-control input-sm" placeholder="<?php echo ($device["ownership_id"]); ?>" value="<?php echo ($device["ownership_id"]); ?>">
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

<script type="text/javascript">
function ajaxAction() {
    var form_serialize = "" + $('#device_modify').serialize();

    $("#model-content").html('<center style="margin:50px"><h4>提交中...</h4><div class="progress progress-striped active" style="width: 50%"><div class="progress-bar"  role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div></div></center>');

    $.ajax({
        type: "post",
        url: "device_management_modified?record_id=" + record_id_json,
        timeout: 2000,
        data: form_serialize,
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