function menu(target) {
	// standartmenu, searchmenu,
	// arasındaki geçişleri ayarlar
	"use strict";
	
	var menus = $.qu("div#menu.public > div");
	var activeMenu;
	for (var i = 0; i < menus.length; i++) { if (menus[i].classList.contains("active")) { activeMenu = menus[i]; break; } }
	if (target === activeMenu.id) return;
	
	activeMenu.classList.remove("active");
	$.find(target).classList.add("active");
	
	
	if (target === "searchmenu") {
		
		// * -> searchmenu
		$.find("searchlabel").focus();
		
	} else if (activeMenu.id === "searchmenu") {
		
		// searchmenu -> *
		$.find("searchlabel").blur();
		$.find("searchlabel").value = "";
		
	} else if (target === 'loginmenu') {
		
		// * -> loginmenu
		$("usernamelabel").focus();
		
	} else if (activeMenu.id === "loginmenu") {
		
		// loginmenu -> *
		$.find("usernamelabel").blur();
		$.find("usernamelabel").value = "";
		$.find("passwordlabel").blur();
		$.find("passwordlabel").value = "";
		
	} else if (target === "loginmenu") {
		// * -> loginmenu
		$.find("usernamelabel").focus();
	}
}

var login = {
	username: {
		_regex_uname_avoid: /([^a-zA-Z0-9\u00c0-\u024f.\-_])/g,
		_regex_email_avoid: /([^a-zA-Z0-9\u00c0-\u024f@.\-_])/g,
		_check: function() {
			var inputUserName = $.qu("div#username > input", true).value; 
			
			if (!inputUserName.length) return messages.un[1];
			if (inputUserName.indexOf("@") === -1) {	
				if (inputUserName.length < 6) return messages.un[2];
				else if (inputUserName.length > 20) return messages.un[3];
				else if ((error = this._regex_uname_avoid.exec(inputUserName)) !== null) return messages.un[6] + '"' + error[0] + '"';
			} else {
				if (inputUserName.length < 10) return messages.un[4];
				else if (inputUserName.length > 60) return messages.un[5];
				else if ((error = this._regex_email_avoid.exec(inputUserName)) !== null) return messages.un[6] + '"' + error[0] + '"';
			}
			
			return messages.un[0];
		},
		onfocus: function() {
			var title = $.qu("div#username > input", true);
			component.input.title.push(title, "");
		},
		onblur: function() {
			var title = $.qu("div#username > input", true);
			var message = this._check();
			component.input.title.push(title, message);
			return (message === "") ? true : false;
		}
	},
	password: {
		_regex_password: /^((?=[\S\u00c0-\u024f@#$%^&+=.\-_* ]*?[A-Z])(?=[\S\u00c0-\u024f@#$%^&+=.\-_* ]*?[a-z])(?=[\S\u00c0-\u024f@#$%^&+=.\-_* ]*?[0-9]).{6,})[\S\u00c0-\u024f@#$%^&+=.\-_* ]$/,
		_check: function() {
			var inputPassword = $.qu("div#password > input", true).value; 
			
			if (!inputPassword.length) return messages.pw[1];
			else if (inputPassword.length < 8) return messages.pw[2];
			else if (!this._regex_password.test(inputPassword)) return messages.pw[3];
			
			return messages.pw[0];
		},
		onfocus: function() {
			var title = $.qu("div#password > input", true);
			component.input.title.push(title, "");
		},
		onblur: function() {
			var title = $.qu("div#password > input", true);
			var message = this._check();
			component.input.title.push(title, message);
			return (message === "") ? true : false;
		}
	},
	submit: {
		_message: function(toShow) {
			$.apply($.qu("div#load-message > div"), function(e) { animate.hide(e); });
			if (toShow !== undefined) animate.show($.qu("div#load-message > div." + toShow, true));
		},
		_request: function(id, password) {
			login.submit._message("one");

			request.ajax("POST", "ajax/authentication.php?action=login", "id=" + id + "&password=" + password, function(e) {
				var response = JSON.parse(e.response);
				setTimeout(function() {
					if (response.response == "success") {
						if (returnURL != undefined) window.location.assign(returnURL);
						else window.location.assign("profile.php");
					} else if (response.response == "incorrect") {
						login.submit._message("two");
					}
				},300);
			});
		},
		_requestControl: function() {
			var check1 = login.username.onblur();
			var check2 = login.password.onblur();
			
			if (!check1 || !check2) return;

			var id = $.qu("div#username > input")[0].value;
			var password = $.qu("div#password > input")[0].value;
			this._request(id, password);
		},
		click: function(event, field) {
			if (field === "submit") {
				this._requestControl();
				return;
			}

			var pressedKey = event.which || event.keyCode;
			if (pressedKey !== 13) return; // 13 = enter

			if ($.qu("div#username > input", true).value === "")
				$.qu("div#username > input", true).focus();
			else if ($.qu("div#password > input", true).value === "")
				$.qu("div#password > input", true).focus();
			else
				this._requestControl();
		}
	}
};

var signup = {
	name: {
		_check: function() {
			var inputUserName = $.qu("div#name > input", true).value; 
			
			if (!inputUserName.length) return messages.na[1];
			
			return messages.na[0];
		},
		onfocus: function() {
			var title = $.qu("div#name > input", true);
			component.input.title.push(title, "");
		},
		onblur: function() {
			var title = $.qu("div#name > input", true);
			var message = this._check();
			component.input.title.push(title, message);
			return (message === "") ? true : false;
		}
	},
	surname: {
		_check: function() {
			var inputUserName = $.qu("div#surname > input", true).value; 
			
			if (!inputUserName.length) return messages.na[1];
			
			return messages.na[0];
		},
		onfocus: function() {
			var title = $.qu("div#surname > input", true);
			component.input.title.push(title, "");
		},
		onblur: function() {
			var title = $.qu("div#surname > input", true);
			var message = this._check();
			component.input.title.push(title, message);
			return (message === "") ? true : false;
		}
	},
	email: {
		_regex_email_avoid: /([^a-zA-Z0-9\u00c0-\u024f@.\-_])/g,
		_check: function() {
			var inputUserName = $.qu("div#email > input", true).value; 
			
			if (inputUserName.length < 10) return messages.un[4];
			else if (inputUserName.length > 60) return messages.un[5];
			else if ((error = this._regex_email_avoid.exec(inputUserName)) !== null) return messages.un[6] + '"' + error[0] + '"';
			
			return messages.un[0];
		},
		onfocus: function() {
			var title = $.qu("div#email > input", true);
			component.input.title.push(title, "");
		},
		onblur: function() {
			var title = $.qu("div#email > input", true);
			var message = this._check();
			component.input.title.push(title, message);
			return (message === "") ? true : false;
		}
	},
	username: {
		_regex_uname_avoid: /([^a-zA-Z0-9\u00c0-\u024f.\-_])/g,
		_check: function() {
			var inputUserName = $.qu("div#username > input", true).value; 
			
			if (inputUserName.length < 6) return messages.un[2];
			else if (inputUserName.length > 20) return messages.un[3];
			else if ((error = this._regex_uname_avoid.exec(inputUserName)) !== null) return messages.un[6] + '"' + error[0] + '"';
			
			return messages.un[0];
		},
		onfocus: function() {
			var title = $.qu("div#username > input", true);
			component.input.title.push(title, "");
		},
		onblur: function() {
			var title = $.qu("div#username > input", true);
			var message = this._check();
			component.input.title.push(title, message);
			return (message === "") ? true : false;
		}
	},
	password: {
		_regex_password: /^((?=[\S\u00c0-\u024f@#$%^&+=.\-_* ]*?[A-Z])(?=[\S\u00c0-\u024f@#$%^&+=.\-_* ]*?[a-z])(?=[\S\u00c0-\u024f@#$%^&+=.\-_* ]*?[0-9]).{6,})[\S\u00c0-\u024f@#$%^&+=.\-_* ]$/,
		_check: function() {
			var inputPassword = $.qu("div#password > input", true).value; 
			
			if (!inputPassword.length) return messages.pw[1];
			else if (inputPassword.length < 8) return messages.pw[2];
			else if (!this._regex_password.test(inputPassword)) return messages.pw[3];
			
			return messages.pw[0];
		},
		onfocus: function() {
			var title = $.qu("div#password > input", true);
			component.input.title.push(title, "");
		},
		onblur: function() {
			var title = $.qu("div#password > input", true);
			var message = this._check();
			component.input.title.push(title, message);
			return (message === "") ? true : false;
		}
	},
	submit: {
		_message: function(toShow) {
			$.apply($.qu("div#load-message > div"), function(e) { animate.hide(e); });
			if (toShow !== undefined) animate.show($.qu("div#load-message > div." + toShow, true));
		},
		_request: function(name, surname, email, username, password) {
			login.submit._message("one");

			request.ajax("POST", "ajax/authentication.php?action=signup", "name=" + name + "&surname=" + surname +  "&email=" + email + "&username=" + username + "&password=" + password, function(e) {
				var response = JSON.parse(e.response);
				setTimeout(function() {
					if (response.response == "success") {
						login.submit._message("three");
						if (returnURL != undefined) window.location.assign(returnURL);
						else window.location.assign("login.php");
					} else if (response.response == "email-registered") {
						login.submit._message("two");
					} else if (response.response == "username-taken") {
						login.submit._message("four");
					}
				},300);
			});
		},
		_requestControl: function() {
			var check1 = login.username.onblur();
			var check2 = login.password.onblur();
			
			if (!check1 || !check2) return;

			var name 		= $.qu("div#name > input")[0].value;
			var surname 	= $.qu("div#surname > input")[0].value;
			var email 		= $.qu("div#email > input")[0].value;
			var username 	= $.qu("div#username > input")[0].value;
			var password 	= $.qu("div#password > input")[0].value;
			this._request(name, surname, email, username, password);
		},
		click: function(event, field) {
			if (field === "submit") {
				this._requestControl();
				return;
			}

			var pressedKey = event.which || event.keyCode;
			if (pressedKey !== 13) return; // 13 = enter

			if ($.qu("div#name > input", true).value === "")
				$.qu("div#name > input", true).focus();
			else if ($.qu("div#surname > input", true).value === "")
				$.qu("div#surname > input", true).focus();
			else if ($.qu("div#email > input", true).value === "")
				$.qu("div#email > input", true).focus();
			else if ($.qu("div#username > input", true).value === "")
				$.qu("div#username > input", true).focus();
			else if ($.qu("div#password > input", true).value === "")
				$.qu("div#password > input", true).focus();
			else
				this._requestControl();
		}
	}
};
