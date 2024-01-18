/* 
ÖNEMLİ
- Kütüphane async olarak eklendiğinde toggle() çalışmaz.

SÜRÜM NOTLARI 1.0 -> 2.0

- 2.0 kütüphanesi önceki kütüphaneye göre yazılmış sayfalarla uyumlu değildir. (Geriye uyumsuz)
- $(x, y) fonksiyonu artık iki parça: tek değer döneceği durumlarda $(x), birden çok değer döneceği durumlarda $$(x) kullanın.

SÜRÜM NOTLARI 2.0 -> 2.1

- $ajax(x, y, z, t) fonksiyonu eklendi.

SÜRÜM NOTLARI 2.1 -> 2.2

- $(), $$() fonksiyonlarına tag ismine göre döndürme ve zaten object gönderildiğinde algılama özelliği eklendi.
- $ajax() fonksiyonu IE5/6 uyumluluğu için düzenlendi. (Geriye uyumlu)

SÜRÜM NOTLARI 2.2 -> 2.3

- toggle(), show(), hide(), $apply(), $find() fonksiyonu ve addEventListener'ı eklendi

*/

/* 
	$(Object) şeklinde çağrıldığında Object elemanını döndürür.
	$("Tag Name") şeklinde çağrıldığında sayfada etkitet ismi "Tag Name" olan tüm elemanlardan birini (ilkini) döndürür.
	$("ID Name") şeklinde çağrıldığında sayfada ID ismi "ID Name" olan tek elemanı döndürür.
	$("Class Name") şeklinde çağrıldığında sayfada Class ismi "Class name" olan tüm elemanlardan birini (ilkini) döndürür.
	$("Query") şeklinde çağrıldığında sayfada Query'nin karşılığı olan tüm elemanlardan birini (ilkini) döndürür.
*/
function $(key) {

	
	var temp;
	
	// key zaten bir objeyse aynen geri döndürülür
	if (typeof key == 'object') return key;
	
	// Tag için arama
	temp = document.getElementsByTagName(key);
	if (temp != null && temp != undefined && temp.length > 0) {
		return temp[0];
	}
	
	// ID için arama
	temp = document.getElementById(key);
	if (temp != null && temp != undefined) return temp;
	
	// Class için arama
	temp = document.getElementsByClassName(key);
	if (temp != null && temp != undefined && temp.length > 0) {
		return temp[0];
	}
	
	// QuerySelector için arama
	temp = document.querySelectorAll(key);
	if (temp != null && temp != undefined && temp.length > 0) {
		return temp[0];
	}
	
	console.log("$(" + key + ") return false.");
	return false;
}

/* 
	$(Object) şeklinde çağrıldığında Object elemanını döndürür.
	$("Tag Name") şeklinde çağrıldığında sayfada etkitet ismi "Tag Name" olan tüm elemanları döndürür.
	$$("ID Name") şeklinde çağrıldığında sayfada ID ismi "ID Name" olan tüm elemanları döndürür.
	$$("Class Name") şeklinde çağrıldığında sayfada Class ismi "Class name" olan tüm elemanları döndürür.
	$$("Query") şeklinde çağrıldığında sayfada Query'nin karşılığı olan tüm elemanları döndürür.
*/
function $$(key) {

	var temp;
	
	// key zaten bir objeyse aynen geri döndürülür
	if (typeof key == 'object') return key;
	
	// Tag için arama
	temp = document.getElementsByTagName(key);
	if (temp != null && temp != undefined && temp.length > 0) {
		return temp;
	}
	
	// ID için arama
	temp = document.getElementById(key);
	if (temp != null && temp != undefined) return temp;
	
	// Class için arama
	temp = document.getElementsByClassName(key);
	if (temp != null && temp != undefined && temp.length > 0) {
		return temp;
	}
	
	// QuerySelector için arama
	temp = document.querySelectorAll(key);
	if (temp != null && temp != undefined && temp.length > 0) {
		return temp;
	}

	console.log("$$(" + key + ") return false.");
	return false;
}

/*
	Kullanılacak elemanda class="toggle-on" veya class="toggle-off" eklenmesi
	ve iki durum için CSS kurallarının yazılması yeterlidir. Geçişler bittiğinde
	display=none ekler.
	Bir buton veya başka bir tür tetikleyiciyle kullanımı: onclick="toggle(elementID);"
*/
function toggle(element) {

	"use strict";
	
	var elem = $(element);
	if (elem.classList.contains("toggle-off")) {
		setTimeout(function(){
			elem.classList.remove("toggle-off");
			elem.classList.add("toggle-on");
		}, 5);
		elem.style.display = "";
	} else {
		elem.classList.remove("toggle-on");
		elem.classList.add("toggle-off");
	}
}
function show(element) {
	"use strict";
	
	var elem = $(element);
	if (elem.classList.contains("toggle-off")) {
		setTimeout(function(){
			elem.classList.remove("toggle-off");
			elem.classList.add("toggle-on");
		}, 5);
		elem.style.display = "";
	}
}
function hide(element) {
	"use strict";
	
	var elem = $(element);
	if (elem.classList.contains("toggle-on")) {
		elem.classList.remove("toggle-on");
		elem.classList.add("toggle-off");
	}
}

// sayfadaki toggle nesneleri için addEventListener, manuel çağrılmaz
document.addEventListener("DOMContentLoaded", function() {
	"use strict";
	var elementsArray = $$("toggle-on");
	for (var i = 0; i < elementsArray.length; i++) {
		elementsArray[i].addEventListener("transitionend", function(event) {
			if (event.target.classList.contains("toggle-off")) {
				event.target.style.display = "none";
			}
		}, true);
	}
	elementsArray = $$("toggle-off");
	for (i = 0; i < elementsArray.length; i++) {
		elementsArray[i].style.display = "none";
		elementsArray[i].addEventListener("transitionend", function(event) {
			if (event.target.classList.contains("toggle-off")) {
				event.target.style.display = "none";
			}
		}, true);
	}
});

/*
	formMethod			: Form methodu
	targetURL			: Ajax sorgusunun gönderileceği sayfa
	stringToSend		: Gönderilecek bilgi
	functionToBeCalled	: Sunucudan veri geldiğinde çağırılacak fonksiyon
	
	Örnek kullanım;
	
	$ajax("POST", "check.php", "username=loremipsum&pass=123456", function(ajaxObject) {
		alert(ajaxObject.responseText);
	});
*/
function $ajax(formMethod, targetURL, stringToSend, functionToBeCalledWithArg) {

	
	var ajaxObject;
	
	if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		ajaxObject = new XMLHttpRequest();
	} else {
		// code for IE6, IE5
		ajaxObject = new ActiveXObject("Microsoft.XMLHTTP");
	}
	ajaxObject.open(formMethod, targetURL, true);	
	ajaxObject.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	
	ajaxObject.onreadystatechange = function() {
		if (ajaxObject.readyState === 4 && ajaxObject.status === 200) {
			functionToBeCalledWithArg(ajaxObject);
		}
	};
	
	ajaxObject.send(stringToSend);
}

/*
	"el" argümanı bir HTML elemanı,
	fonksiyonun dönüş değeri elementin 
		sayfanın soluna uzaklığı: x
		sayfanın üstüne uzaklığı: y
		genişliği: width
		yüksekliği: height
	özelliklerini içeren nesnedir.
*/
function getPositionAndSizes(el) {

	var xPos = 0;
	var yPos = 0;
	var offW = el.offsetWidth;
	var offH = el.offsetHeight;

	while (el) {
		if (el.tagName == "BODY") {
			// deal with browser quirks with body/window/document and page scroll
			var xScroll = el.scrollLeft || document.documentElement.scrollLeft;
			var yScroll = el.scrollTop || document.documentElement.scrollTop;

			xPos += (el.offsetLeft - xScroll + el.clientLeft);
			yPos += (el.offsetTop - yScroll + el.clientTop);
		} else {
			// for all other non-BODY elements
			xPos += (el.offsetLeft - el.scrollLeft + el.clientLeft);
			yPos += (el.offsetTop - el.scrollTop + el.clientTop);
		}

		el = el.offsetParent;
	}
	
	return {
		x: xPos,
		y: yPos,
		width: offW,
		height: offH
	};
}

function $apply(node, callback) {
	if (!node || node.length < 1) { console.log("$apply(" + toString(node) + ", ...) returned false"); return false; }
	for (var i = 0; i < node.length; i++) callback(node[i]);
}

function $find(node, key) {
	if (!node || node.length < 1) { console.log("$find(" + toString(node) + ", " + key + ") returned false"); return false; }
	for (var i = 0; i < node.length; i++) if (node[i] === key) return true;
	return false;
}


document.addEventListener("DOMContentLoaded", function() {
	// Üstünde bilgi alanı bulunan giriş alanları için
	// sayfa yüklemesine zamanlı otomatik alan ekleyici
	// HTML'de bu tür bir giriş alanı oluşturmak için kullanım:
	// <input class="input-x-title">
	$apply($$("input[class*='title']"), function(param) {
		var div = document.createElement("div");
		div.classList.add("input-title");
		param.parentNode.insertBefore(div, param);
	});
});


