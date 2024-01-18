var $ = {
  find: function(key, cut) {
    if (typeof key == 'object') return key;
    var result;
    if (result = this.tg(key, cut)) return result;
    if (result = this.id(key)) return result;
    if (result = this.cl(key, cut)) return result;
    if (result = this.qu(key, cut)) return result;
    console.log("Finally: $.find(" + key + ") return false."); return false;
  },
  id: function(key) {
    if (typeof key == 'object') return key;
    var result = document.getElementById(key);
    if (result) { return result; }
    else { console.log("$.id(" + key + ") return false."); return false; }
  },
  cl: function(key, cut) {
    if (typeof key == 'object') return key;
    cut = cut || false;
    var result = document.getElementsByClassName(key);
    if (result.length >= 1) { if (cut === false) return result; else return result[0]; }
    else { console.log("$.cl(" + key + ") return false."); return false; }
  },
  tg: function(key, cut) {
    if (typeof key == 'object') return key;
    cut = cut || false;
    var result = document.getElementsByTagName(key);
    if (result.length >= 1) { if (cut === false) return result; else return result[0]; }
    else { console.log("$.tg(" + key + ") return false."); return false; }
  },
  qu: function(key, cut) {
    if (typeof key == 'object') return key;
    cut = cut || false;
    var result = document.querySelectorAll(key);
    if (result.length >= 1) { if (cut === false) return result; else return result[0]; }
    else { console.log("$.qu(" + key + ") return false."); return false; }
  },
  DOM: function(callback) {
    if (document.readyState == "complete" || document.readyState == "loaded" || document.readyState == "interactive") callback();
    else document.addEventListener("DOMContentLoaded", callback);
  },
  search: function(source, key) {
    if (!source || source.length < 1) { console.log("$.search(" + toString(source) + ", " + key + ") return false"); return false; }
    for (var i = 0; i < source.length; i++) if (source[i] === key) return true;
    return false;
  },
  apply: function(source, callback) {
    if (!source || source.length < 1) { console.log("$.apply(" + toString(source) + ", ...) return false"); return false; }
    for (var i = 0; i < source.length; i++) callback(source[i]);
  },
  after: function(elem) {
    return elem.nextSibling;
  },
  before: function(elem) {
    return elem.previousSibling;
  }
};

var measure = {
  width: function(elem) {
    elem = $.find(elem, true);
    return elem.offsetWidth;
  },
  height: function(elem) {
    elem = $.find(elem, true);
    return elem.offsetHeight;
  },
  y: function(elem) {
    elem = $.find(elem, true);
    var yPos = 0;
    while (elem) {
      if (elem.tagName == "BODY") {
        var yScroll = elem.scrollTop || document.documentElement.scrollTop;
        yPos += (elem.offsetTop - yScroll + elem.clientTop);
      } else {
        yPos += (elem.offsetTop - elem.scrollTop + elem.clientTop);
      }
      elem = elem.offsetParent;
    }
    return yPos;
  },
  x: function(elem) {
    var xPos = 0;
    elem = $.find(elem, true);
    while (elem) {
      if (elem.tagName == "BODY") {
        var xScroll = elem.scrollLeft || document.documentElement.scrollLeft;
        xPos += (elem.offsetLeft - xScroll + elem.clientLeft);
      } else {
        xPos += (elem.offsetLeft - elem.scrollLeft + elem.clientLeft);
      }
      elem = elem.offsetParent;
    }
    return xPos;
  }
};

var animate = {
  currentlyProcessing: undefined,
  toggle: function(element) {
    var elem = $.find(element, true);
    if (elem.classList.contains("toggle-off")) this.show(elem);
    else if (elem.classList.contains("toggle-on")) this.hide(elem);
  },
  show: function(element) {
    this.clear();
    var elem = $.find(element, true);
    
    if (elem.classList.contains("toggle-off")) {
      
      setTimeout(function() {
        if (elem.style.display === "") {
          elem.classList.remove("toggle-off");
          elem.classList.add("toggle-on");
        }
      }, 100);
      elem.style.display = "";
    }
  },
  hide: function(element) {
    this.clear();
    var elem = $.find(element);
    if (elem.classList.contains("toggle-on")) {
      elem.classList.remove("toggle-on");
      elem.classList.add("toggle-off");
    }
  },
  blink: function(element) {
    var elem = $.find(element);
    setTimeout(function() {
      animate.clear();
      elem.classList.remove("blink");
    }, 400);
    elem.classList.add("blink");
  },
  isAnimated: function(element) {
    var elem = $.find(element);
    if (typeof elem.style.transition !== "undefined" && elem.style.transition !== "") return true;
    console.log("!!! animate.isAnimated(" + toString(element) + ") return false. There is no transition rules for " + toString(element));
    return false;
  },
  clear: function(element) {
    if (this.currentlyProcessing !== undefined) {
      this.currentlyProcessing.clearTimeout();
      this.currentlyProcessing = undefined;
    }
  }
};

var component = {
  search: {
    inClassDef: function(elem, key) {
      if (elem.className.search(key) === -1) return false;
      else return true;
    }
  },
  
  input: {
    title: {
      _elements: [],
      _construct: function() {
        $.apply($.qu("input[class*='title']"), function(param) {
          component.input.title._elements[component.input.title._elements.length] = param;
          var div = document.createElement("div");
          div.classList.add("input-title");
          div.classList.add("toggle-off");
          param.parentNode.insertBefore(div, param);
        });
      },
      _check: function(elem) {
        if (!component.search.inClassDef(elem, "title")) return false;
        return true;
      },
      _getTitle: function(elem) {
        return $.before(elem);
      },
      push: function(elem, nextMessage) {  
        if (typeof elem !== "object") elem = $.find(elem);
        if (!this._check(elem)) {
          console.log("component.input.title.push(" + toString(elem) + ", " + nextMessage + ") return false. (Not a title object.)");
          return false;
        }
        currentTitleDiv = this._getTitle(elem);

        if (animate.currentProcess !== undefined) {
          clearTimeout(this.currentProcess);
          animate.currentProcess = undefined;
        }

        if (currentTitleDiv.innerHTML === "" && nextMessage !== "") {
          // 1. Açılma (empty -> *)
          currentTitleDiv.innerHTML = nextMessage;
          animate.show(currentTitleDiv);
        } else if (currentTitleDiv.innerHTML !== "" && nextMessage === "") {
          // 2. Kapanma (* -> empty)
          animate.currentProcess = setTimeout(function() {
            currentTitleDiv.innerHTML = nextMessage;
          }, 200);
          animate.hide(currentTitleDiv);
        } else if (currentTitleDiv.innerHTML !== nextMessage) {
          // 3. Değişme (* -> **)
          animate.currentProcess = setTimeout(function() {
            currentTitleDiv.innerHTML = nextMessage;
          }, 200);
          animate.blink(currentTitleDiv);
        } else if (currentTitleDiv.innerHTML === nextMessage) {
          // 4. Değişmeme (empty -> empty / * -> *)
          // ...Burada yapılacak bir şey yok
        } else {
          console.log("??? component.input.title.push");
        }
        return;
      },
      get: function(elem) {  
        if (typeof elem !== "object") elem = $.find(elem);
        if (!this._check(elem)) {
          console.log("component.input.title.push(" + toString(elem) + ", " + nextMessage + ") return false. (Not a title object.)");
          return false;
        }
        return this._getTitle(elem).innerHTML;
      }
    }
  }
};


var request = {
  ajax: function (formMethod, targetURL, data, functionToBeCalledWithArg, setHeader = true) {
    var ajaxObject;
    
    if (window.XMLHttpRequest) {
      // code for IE7+, Firefox, Chrome, Opera, Safari
      ajaxObject = new XMLHttpRequest();
    } else {
      // code for IE6, IE5
      ajaxObject = new ActiveXObject("Microsoft.XMLHTTP");
    }
    ajaxObject.open(formMethod, targetURL, true);	
    setHeader ? ajaxObject.setRequestHeader("Content-type", "application/x-www-form-urlencoded") : "";
    
    ajaxObject.onreadystatechange = function() {
      if (ajaxObject.readyState === 4 && ajaxObject.status === 200) {
        functionToBeCalledWithArg(ajaxObject);
      }
    };
    
    ajaxObject.send(data);
  }
};

var css = {

};

function targetURL(url) {
  window.location.assign(url);
}

function getScrollMaxY() {
  return document.documentElement.scrollHeight - document.documentElement.clientHeight;
}

function getURLVars() {
  var vars = {};
  var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
    vars[key] = value;
  });
  return vars;
}


$.DOM(function() {
  console.log("---------Beginnig to setup interface elements---------");

  component.input.title._construct();

  // For elements with toggle-on/off classes
  $.apply($.cl("toggle-on"), function(elem) {
    animate.isAnimated(elem);
    elem.addEventListener("transitionend", function(event) {
      if (event.target.classList.contains("toggle-off")) {
        event.target.style.display = "none";
      }
    }, true);
  });
  $.apply($.cl("toggle-off"), function(elem) {
    animate.isAnimated(elem);
    elem.style.display = "none";
    elem.addEventListener("transitionend", function(event) {
      if (event.target.classList.contains("toggle-off")) {
        event.target.style.display = "none";
      }
    }, true);
  });
  
  console.log("---------Ending to setup interface elements---------");
});