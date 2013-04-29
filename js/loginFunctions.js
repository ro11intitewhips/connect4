function initLogin() {	
	$("span").hide();
	$("#usernameField").focus();
	
	$("#signIn").click(function() {
		checkLogin();
	});
	
	$("#signIn").keypress(function(e) {
		var keycode = (e.keyCode ? e.keyCode : e.which);
		e.preventDefault();
		
		if(keycode == '13') {
			checkLogin();
		}
	});
	
	$("#register").click(function() {
		$("#newUsernameField").focus();
	});
	
	$("#registerButton").click(function() {
		checkRegister();
	});
}

function checkLogin() {
	var userArray = new Array();
	userArray.push($("#usernameField").val());
	userArray.push($("#passwordField").val());
	
	if($("#loginForm").formValidation('validateLogin', userArray)) {
		initLoginAjax('startLogin', userArray[0] + '|' + userArray[1]);
		$("#loginForm")[0].reset();
		return true;
	}
	
	$("#loginForm")[0].reset();
	return false;
}

function checkRegister() {
	var newUserArray = new Array();
	newUserArray.push($("#newUsernameField").val());
	newUserArray.push($("#newPasswordField").val());
	
	//var obj = $('#registerModalForm').serializeObject();
	//console.log(obj['newPassword']);
	
	if($('#registerModalForm').formValidation('validateRegistration', newUserArray)) {
		//initRegisterAjax('startRegister', obj['newUsername'] + '|' + obj['newPassword']); //this will check uniqueness, cuz of db colun setting
		initRegisterAjax('startRegister', newUserArray[0] + '|' + newUserArray[1]);
		//initLoginAjax('startLogin', obj['newUsername'] + '|' + obj['newPassword']);
		//initLoginAjax('stargLogin', newUserArray[0] + '|' + newUserArray[1]);
		$("#registerModalForm")[0].reset();
		return true;
	}
	
	$("#registerModalForm")[0].reset();
	return false;
}

(function($) {
	var blankRegEx = new RegExp("\\s+");
	var feedback = false;
	
	var methods = {
		validateLogin : function(fields) {
			//console.log("hi silvy");
			$.each(fields, function() {
				if(blankRegEx.test(this) || this == "") {
					$(".alert").alert().show().fadeOut(5000);
				}
				else {
					feedback = true;
				}
			});
			
			return feedback;
		},
	
		validateRegistration : function(fields) {
			$.each(fields, function() {
				if(blankRegEx.test(this) || this == "") {
					$(".alert").alert().show().fadeOut(5000);
				}
				else {
					feedback = true;
				}
			});
			
			return feedback;
		}
	};
	
	$.fn.formValidation = function() {
		//console.log(method);
		//console.log(userArray);
		var method = arguments[0];
		//console.log(method);
		
		if(methods[method]) {
			//console.log("hello");
			//method = methods[method];
			//console.log(method);
			options = Array.prototype.slice.call(arguments, 1);
			//console.log(options);
			return methods[method].apply(method, options);
		}
		else {
			//console.log("hello2");
			//return methods.apply(this, options);
		}
		
		return false;
	}
})(jQuery);

// http://stackoverflow.com/questions/1184624/convert-form-data-to-js-object-with-jquery
$.fn.serializeObject = function() {
    var o = {};
    var a = this.serializeArray();
    $.each(a, function() {
        if (o[this.name] !== undefined) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
    return o;
};

