<?php if (!defined('THINK_PATH')) exit();?><form role="form" id="pass_list">
    <div class="panel panel-primary">
        <div class="panel-heading"><?php echo ($unit_name); ?></div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-bordered table-condensed">
                    <tr>
                        <td id="old_prompt" class="col-md-6">用户名     </td>
                        <td class="col-md-6">
                            <?php echo (session('username')); ?>
                        </td>       
                    </tr>
                    
                    <tr>
                        <td id="old_prompt" class="col-md-6">输入旧密码     </td>
                        <td class="col-md-6">
                            <input type="password" name="old_pass" id="old_pass" class="form-control required-cn" >
                        </td>       
                    </tr>
<!--                     <tr>
                        <td id="new_prompt" class="col-md-6">输入新密码     </td>
                        <td class="col-md-6">
                            <input type="password" name="password" id="password" class="form-control required-cn">
                        </td>
                    </tr>
 -->                    <tr>              
                        <td id="new_prompt" class="col-md-6">输入新密码     </td>
                        <td class="col-md-6">
                            <input type="password" name="new_pass" id="new_pass" class="form-control required-cn " >
                        </td>
                    </tr>

                    <tr>              
                        <td id="newnew_prompt" class="col-md-6">重新输入新密码     </td>
                        <td class="col-md-6">
                            <input type="password" name="new_pass_again" id="new_pass_again" class="form-control required-cn pwd_Equal" >
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</form>
<div id="myAlert"></div>
<center>
    <button class="btn btn-warning btn-lg" onclick="ajaxAction()">确认修改</button>
    <button class="btn btn-info btn-lg" onclick="$('#myModal_pass').modal('hide');">关闭页面</button>
</center>
<script type="text/javascript" src="__PUBLIC__/js/jquery-validate.min.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/jquery-myvalidate.js"></script>
<script>
$("#pass_list").validate();
</script>