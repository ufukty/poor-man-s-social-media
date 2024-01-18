function scrollHandler(callback, scrollAxis, scrollableElement, optionalArg, callbackStable) {
  if (scrollableElement == undefined) scrollableElement = window;

  if (scrollableElement.lastKnowScrollPosition == undefined) scrollableElement.lastKnowScrollPosition = 0;
  if (scrollableElement.scrollHandlerTicking == undefined) scrollableElement.scrollHandlerTicking = false;

  scrollableElement.addEventListener('scroll', function(e) {

    if (scrollAxis == 'x' || scrollAxis == 'X')
      scrollableElement.lastKnowScrollPosition = scrollableElement.scrollLeft;
    else
      scrollableElement.lastKnowScrollPosition = scrollableElement.scrollY;

    if (!scrollableElement.scrollHandlerTicking) {
      window.requestAnimationFrame(function() {
        callback(scrollableElement.lastKnowScrollPosition, optionalArg);

        if (callbackStable != undefined)
          if (scrollableElement.timeout) clearTimeout(scrollableElement.timeout);
            scrollableElement.timeout = setTimeout(callbackStable, 100, scrollableElement.lastKnowScrollPosition, optionalArg);

        scrollableElement.scrollHandlerTicking = false;
      });
    }
    scrollableElement.scrollHandlerTicking = true;
  });
}

var profile = {
  actions: {
    othersToggle: function() {
      $.apply($.qu("div#profile-actions > *[class*='toggle']"), function(e) {
				animate.toggle(e);
			});
    },
    
    action: function(action) {
      /*
        action can be:
          follow,
          unfollow,
          confirm,
          deny,
          return,
          block,
          unblock
      */
      request.ajax("GET", "ajax/userAction.php?action=" + action + "&targetID=" + getURLVars()["id"], "", function(e) {
        var response = JSON.parse(e.response);
        targetURL("");
      });
    }
  },
  profileContent: {
    scrollToTab: function(pcListScrollableArea, targetTab, willItAnimate) {
      var clientWidth = document.body.clientWidth;
      pcListScrollableArea.scrollLeft = targetTab * clientWidth;
    },
    calculateCurrentTab: function(pcContainer) {
      var pcListContainer = pcContainer.children[3];
      var pcListScrollableArea = pcContainer.children[3].children[0];
      var clientWidth = document.body.clientWidth;
      
      var currentTabNumberFloat = pcListScrollableArea.scrollLeft / clientWidth;
      if (currentTabNumberFloat < 0.5) var currentTab = 0;
      else if (currentTabNumberFloat < 1.5) var currentTab = 1;
      else if (currentTabNumberFloat < 2.5) var currentTab = 2;
      else var currentTab = 0;
      return currentTab;
    },
    callWithListButtons: function(element, targetTab) {
      var pcContainer = element.parentNode.parentNode;
      var pcListContainer = pcContainer.children[3];
      var pcListScrollableArea = pcContainer.children[3].children[0];
      var pcFooter = pcContainer.children[2];
      var currentTab = this.calculateCurrentTab(pcContainer);

      if (pcListContainer.isListOpen == undefined)
        scrollHandler(this.callWithScrollEventListener, 'x', pcListScrollableArea, pcContainer, this.afterScroll);

      if (pcListContainer.isListOpen) {
        if (currentTab == targetTab) {
          // Liste kapatılacak
          animate.hide(pcListContainer);
          pcListContainer.isListOpen = false;
        } else {
          // Liste açıkken listede başka bir taba geçilecek
          this.scrollToTab(pcListScrollableArea, targetTab, true);
          pcFooter.children[targetTab].classList.add("active");
        }
        pcFooter.children[currentTab].classList.remove("active");
      } else {
        // İstenilen tab'ın pozisyonuna değiştirilip liste açılacak.
        animate.show(pcListContainer);
        this.scrollToTab(pcListScrollableArea, targetTab, false);
        pcListContainer.isListOpen = true;
        pcFooter.children[targetTab].classList.add("active");
      }
      return;
    },
    callWithScrollEventListener: function(position, pcContainer) {
      var pcFooter = pcContainer.children[2];
      var clientWidth = document.body.clientWidth;
      if (position % clientWidth == 0) return;
      var currentTab = profile.profileContent.calculateCurrentTab(pcContainer);
      pcFooter.children[0].classList.remove("active");
      pcFooter.children[1].classList.remove("active");
      pcFooter.children[2].classList.remove("active");
      pcFooter.children[currentTab].classList.add("active");
    },
    afterScroll: function(position, pcContainer) {
      var pcListScrollableArea = pcContainer.children[3].children[0];
      profile.profileContent.scrollToTab(pcListScrollableArea, profile.profileContent.calculateCurrentTab(pcContainer), true);
    }
  }
};

var listHandler = {
  mode: false,
  index_currentSpawnedNode: -1,
  index_currentLoadedNode: -1,
  profileContacts: false,
  contactsList: false,
  loading: false,
  nodesArray: [],
  ended: false,

  construct: function() {
    if (typeof contactListMode == "undefined") return;

    scrollHandler(function(position) {
      if (typeof contactListMode != "undefined")
        if (position + 300 > getScrollMaxY()) listHandler.contentLoader();
    }, 'y', window);
    
    listHandler.mode = contactListMode;
    listHandler.profileContacts = $.id("profile-contacts");
    listHandler.contactsList = $.id("contacts-list");
    listHandler.contentLoader();
  },
  nodeSpawner: function() {
    var container = document.createElement("a");
  
    var photoDiv = document.createElement("div");
    photoDiv.setAttribute("class", "photo");
    container.appendChild(photoDiv);

    var nameDiv = document.createElement("div");
    nameDiv.setAttribute("class", "name");
    container.appendChild(nameDiv);

    listHandler.nodesArray.push(listHandler.contactsList.appendChild(container));
    listHandler.index_currentSpawnedNode++;
  },
  updateNode: function(id, photo, name) {
    var currentNode = listHandler.nodesArray[listHandler.index_currentLoadedNode + 1];
    var currentPhotoDiv = currentNode.children[0];
    var currentNameDiv = currentNode.children[1];

    currentNode.setAttribute("href", "profile.php?id=" + id);

    var imageTag = document.createElement("img");
    
    var imageFile = new Image();
    imageFile.onload = function() {
      imageTag.src = imageFile.src;
      currentPhotoDiv.appendChild(imageTag);
    };
    imageFile.src = photo;

    var textNode = document.createTextNode(name);
    currentNameDiv.appendChild(textNode);

    listHandler.index_currentLoadedNode++;
  },

  contentLoader: function() {
    if (listHandler.ended == true) return;

    if (listHandler.loading == true) return;
    else listHandler.loading = true;
    
    for (var i = 0; i < 20; i++) 
      listHandler.nodeSpawner();

    request.ajax("GET", "ajax/profileContactsList.php?listType=" + listHandler.mode + "&from=" + (listHandler.index_currentLoadedNode + 1), "", function(e) {
      listHandler.loading = false;
      
      try {
        var response = JSON.parse(e.response);
      } catch (e) {
        listHandler.deleteNodes("");
        animate.show($.id("error"));
        listHandler.ended = true;
        return;
      }
      
      if (response.status == "no friend") {
        listHandler.deleteNodes("");
        animate.show($.id("no-contacts"));
        listHandler.ended = true;
        return;
      }
      
      if (response.status == "no more friend") {
        listHandler.deleteUnloadedNodes("");
        listHandler.ended = true;
        return;
      }

      if (response.status == "success") {
        for (var i = 0; i < response.list.length; i++)
          listHandler.updateNode(
            response.list[i].friendID,
            response.list[i].photo,
            response.list[i].fullname
          );

        if (listHandler.index_currentLoadedNode != listHandler.index_currentSpawnedNode) {
          listHandler.deleteUnloadedNodes();
          listHandler.ended = true;
        }

        return;
      }

      animate.show($.id("error"));
      listHandler.deleteUnloadedNodes();
      listHandler.ended = true;
      
      return;
    });
  },

  deleteNodes: function () {
    listHandler.profileContacts.removeChild(listHandler.contactsList);
    return false;
  },
  deleteUnloadedNodes: function () {
    for (var i = listHandler.index_currentLoadedNode + 1; i <= listHandler.index_currentSpawnedNode; i++) {
      var that = listHandler.nodesArray[i];
      that.parentElement.removeChild(that);
    }
    return;
  }
};
$.DOM(listHandler.construct);

