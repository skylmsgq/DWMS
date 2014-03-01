<?php if (!defined('THINK_PATH')) exit();?><form role="form" id="device_detail">
    <div class="panel panel-primary">
        <div class="panel-heading">设备信息</div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover table-condensed">
                    <tr>
                        <td>设备名称</td>
                        <td>
                            <?php echo ($device["device_name"]); ?>
                        </td>
                        <td>设备类型</td>
                        <td>
                            <?php echo ($device["device_type"]); ?>
                        </td>
                    </tr>
                    <tr>
                        <td>设备序列号</td>
                        <td>
                            <?php echo ($device["device_serial_num"]); ?>
                        </td>
                        <td>设备管辖权属</td>
                        <td>
                            <?php echo ($device["jurisdiction_id"]); ?>
                        </td>
                    </tr>
                    <tr>
                        <td>设备归属企业类型</td>
                        <td>
                            <?php echo ($device["ownership_type"]); ?>
                        </td>
                        <td>设备归属企业编号</td>
                        <td>
                            <?php echo ($device["ownership_id"]); ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="panel panel-primary">
        <div class="panel-heading">设备归属单位信息</div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover table-condensed">
                    <tr>
                        <td>单位名称</td>
                        <td>
                            <?php echo ($unit["name"]); ?>
                        </td>
                        <td>单位电话</td>
                        <td>
                            <?php echo ($unit["phone"]); ?>
                        </td>
                    </tr>
                    <tr>
                        <td>单位地址</td>
                        <td>
                            <?php echo ($unit["address"]); ?>
                        </td>
                        <td>单位邮编</td>
                        <td>
                            <?php echo ($unit["postcode"]); ?>
                        </td>
                    </tr>
                    <tr>
                        <td>单位传真</td>
                        <td>
                            <?php echo ($unit["fax"]); ?>
                        </td>
                        <td>单位邮箱</td>
                        <td>
                            <?php echo ($unit["email"]); ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</form>

<center>
    <button class="btn btn-info btn-lg" onclick="$('#myModal').modal('hide');">关闭页面</button>
</center>