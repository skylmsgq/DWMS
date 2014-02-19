function myAlertSucc(msg) {
    $("#noSelectionAlert").html('<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>状态: </strong> ' + msg + ' </div>');
}

function myAlertFail(msg) {
    $("#noSelectionAlert").html('<div class="alert alert-warning alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>错误: </strong> ' + msg + ' </div>');
}
