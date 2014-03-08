$.validator.addMethod("cnRequired", $.validator.methods.required, "<span class=\"label label-danger\">此项为必填项</span>");

$.validator.addClassRules("required-cn", {
    cnRequired: true
});

$.validator.addMethod("cnNumber", $.validator.methods.number, "<span class=\"label label-danger\">此项必须为数字</span>");

$.validator.addClassRules("number-cn", {
    cnNumber: true
});

$(".required-cn").each(function() {
    var myprev = $(this).parent().prev();
    myprev.append(" <a style=\"color: red\">*</a>");
});


$.validator.addMethod("cnPwdEqual", function (value, element) {
			// bind to the blur event of the target in order to revalidate whenever the target field is updated
			// TODO find a way to bind the event just once, avoiding the unbind-rebind overhead
			var param="#password"
			var target = $(param);
			/* if ( this.settings.onfocusout ) {
				target.unbind(".validate-pwdEqual").bind("blur.validate-pwdEqual", function() {
					$(element).valid();
				});
			}*/
			return (value === target.val()) && (value.length > 5);
		}, "<span class=\"label label-danger\">两次密码必须一致且长度至少6位</span>");

$.validator.addClassRules("pwdEqual", { cnPwdEqual: true });

$.validator.addMethod("cnPwd_Equal", function (value, element) {
			// bind to the blur event of the target in order to revalidate whenever the target field is updated
			// TODO find a way to bind the event just once, avoiding the unbind-rebind overhead
			var param="#new_pass"
			var target = $(param);
			/* if ( this.settings.onfocusout ) {
				target.unbind(".validate-pwdEqual").bind("blur.validate-pwdEqual", function() {
					$(element).valid();
				});
			}*/
			return (value === target.val()) && (value.length > 5);
		}, "<span class=\"label label-danger\">两次密码必须一致且长度至少6位</span>");

$.validator.addClassRules("pwd_Equal", { cnPwd_Equal: true });


$.validator.addMethod("cnPwdEqual_1", function (value, element) {
			// bind to the blur event of the target in order to revalidate whenever the target field is updated
			// TODO find a way to bind the event just once, avoiding the unbind-rebind overhead
			// var param="#password"
			// var target = $(param);
			var a = 0;
			for (var idx in username){
				if(value == username[idx])
					return false;
			}
			// if(a==1)return (false);
			return true;
			// return ( username.indexOf(value)===-1 );
			/* if ( this.settings.onfocusout ) {
				target.unbind(".validate-pwdEqual").bind("blur.validate-pwdEqual", function() {
					$(element).valid();
				});
			}*/
			// return (value === target.val()) && (value.length > 5);
		}, "<span class=\"label label-danger\">此用户名已被注册</span>");

$.validator.addClassRules("pwdEqual_1", { cnPwdEqual_1: true });

$.validator.addMethod("cnPwdEqual_2", function (value, element) {
	   		var code = value.split(",");
	   		console.log(code);
			for (var idx in code){
				for (var i in waste_code){
					if(code[idx]==waste_code[i]){
						break;
					}
					return false;
				}
			}
			return true;
			}, "<span class=\"label label-danger\">危废代码错误</span>");

$.validator.addClassRules("pwdEqual_2", { cnPwdEqual_2: true });