<?php if (!defined('THINK_PATH')) exit();?><form role="form" id="gps_request">
    <div class="panel panel-primary">
        <div class="panel-heading">请选择绑定 GPS</div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover table-condensed">
                    <tr>
                        <td>
                            <select type="text" id="device_id" name="device_id" class="form-control input-sm" placeholder="GPS 序列号">
                                <option>GPS 序列号</option>
                            </select>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</form>
<center>
    <button class="btn btn-warning btn-lg" id="button_submit" data-loading-text="正在提交..." data-complete-text="提交成功！" onclick="ajaxAction()">提交</button>
    <button class="btn btn-info btn-lg" onclick="$('#myModal').modal('hide');">关闭页面</button>
</center>

<script type="text/javascript">

$('#device_id').html('<option>GPS 序列号</option>');
for (var idx in device) {
$('#device_id').append('<option value="' + device[idx].device_id + '">' + device[idx].device_serial_num + '</option>');
    }

function ajaxAction() {
    $('#button_submit').button('loading');
    $.ajax({
        type: "post",
        url: "vehicle_gps_binding_request_form",
        timeout: 2000,
        data: $('#gps_request').serialize() + '&vehicle_id=' + vehicle_id,
        success: function(data) {
            $('#button_submit').button('complete');
            setTimeout("$('#button_submit').button('reset')", 3000);
            $('input').val('');
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            alert('保存失败，请重新保存。');
            console.log("Error: Ajax_Content_Load " + errorThrown);
            console.log("XMLHttpRequest.status: " + XMLHttpRequest.status);
            console.log("XMLHttpRequest.readyState: " + XMLHttpRequest.readyState);
            console.log("textStatus: " + textStatus);
        }
    });

}
</script>