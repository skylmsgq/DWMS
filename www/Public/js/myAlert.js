function myAlertSucc(msg) {
	if (fullScreen) {
		$("#myAlertFull").html('<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>状态: </strong> ' + msg + ' </div>');
	} else {
		$("#myAlert").html('<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>状态: </strong> ' + msg + ' </div>');
	}
}

function myAlertFail(msg) {
	if (fullScreen) {
		$("#myAlertFull").html('<div class="alert alert-warning alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>错误: </strong> ' + msg + ' </div>');
	} else {
		$("#myAlert").html('<div class="alert alert-warning alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>错误: </strong> ' + msg + ' </div>');
	}
}

function myAlertInfo(msg){
	if (fullScreen) {
		$("#myAlertFull").html('<div class="alert alert-info alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>信息: </strong> ' + msg + ' </div>');
	} else {
		$("#myAlert").html('<div class="alert alert-info alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>信息: </strong> ' + msg + ' </div>');
	}
}
