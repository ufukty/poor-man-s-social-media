function logout() {
	request.ajax("GET", "ajax/authentication.php?action=logout", "", function (e) {
		window.location = "login.php";
	});
}

var post = {};
post.deletePost = function(postID) {
	request.ajax("POST", "ajax/deletepost.php", "postID=" + postID, function(e) {
		window.location.reload();
	});
};

var share = {};
share.change = function () {
	var dom_label = $.id("share--label");
	var dom_input = $.id('share--input');

	if (dom_input.files.length > 0) {
		var file = dom_input.files[0];

		dom_input.style.display = "none";
		dom_label.innerText = "Yükleniyor";

		var formdata = new FormData();
		formdata.append("image", file, file.name);
		request.ajax("POST", "ajax/newpost.php", formdata, function (response) {
			if (response.status) {
				dom_label.innerText = "Yüklendi";
			}
			else {
				dom_input.style.display = "block";
				dom_label.innerText = "Başarısız. Tekrar yüklemek için buraya bir fotoğraf sürükle veya tıklayarak seç";
			}
			window.location.reload();
		}, false);
	}
};
