/*global jQuery, document */

var Pager = (function ($) {
    'use strict';
    return (function () {
        var current;
        var buttons = $("div.art-pager>*");
        this.commentsPerPage = 2;
        this.activePageId = 1;

        var self = this;

        this.init = function (ctrl) {
            $("div.art-pager a").live("click", { _ctrl: ctrl }, this.numberClick);
            
            if (this.activePageId > 0)
                this.execute(this.activePageId);
        };

        this.numberClick = function (e) {

            if (e.data._ctrl === true && !e.ctrlKey) {
                return false;
            }

            reload();
            current = buttons.index(this);

            var strId = self.getButtonId(this);
            self.execute(strId);

            return false;
        };

        this.getButtonId = function (button) {
            var strId = button.textContent;

            if (strId.indexOf("Prev") !== -1) {
                strId = "prev";
            }
            else if (strId.indexOf("Next") !== -1) {
                strId = "next";
            }
            else if (strId.indexOf("...") !== -1)
                strId = "more";

            return strId;
        };

        this.getActivePage = function () {
            return this.activePageId;
        };

        this.setActivePage = function (newId) {
            this.activePageId = newId;
            this.execute(newId);
        };

        this.setCommentsPerPageCount = function (count) {
            this.commentsPerPage = count;
        };

        this.execute = function (strId) {
        
            var activeId = 0;

            // Get id of active node
            var activeNodes = $("div.art-pager span.active");

            if (activeNodes.length > 0) {
                var activeNodeSpan = activeNodes[0];

                var activeButton = activeNodeSpan.parentNode;
                var activeButtonLabel = activeNodeSpan.firstChild.textContent;

                activeId = parseInt(activeButtonLabel, 10);

                // Set previous active button to link
                if (activeId !== strId) {
                    var link = document.createElement('a');
                    link.setAttribute('href', '#');

                    var linkText = document.createTextNode(activeButtonLabel);
                    link.appendChild(linkText);

                    activeButton.replaceChild(link, activeNodeSpan);
                }
            }

            // Process id

            var commentsCount = $("div.art-comment").length;
            var pagesCount = Math.floor((commentsCount + this.commentsPerPage - 1) / this.commentsPerPage);

            if (strId === "prev" && activeId > 0) {

                this.activePageId = activeId - 1;

            } else if ((strId === "next" || strId === "more") && activeId > 0) {

                this.activePageId = activeId + 1;

                if (this.activePageId > pagesCount)
                    this.activePageId = pagesCount;

            } else {

                this.activePageId = parseInt(strId, 10);
            }

            switchToPage(this.activePageId);

            setCurrentPageButtonActive(this.activePageId);
            processPrevButton(this.activePageId);
            processNextButton(this.activePageId, pagesCount);
        };

        function setCurrentPageButtonActive(pageId) {

            var newActiveButtonLinksArray = $("div.art-pager a:contains('" + pageId + "')");
            if (newActiveButtonLinksArray.length === 0) return;

            var activeButtonLink = newActiveButtonLinksArray[0];
            var newActiveButton = activeButtonLink.parentNode;

            var newActiveSpan = document.createElement('span');
            newActiveSpan.setAttribute('class', 'active');

            var newActiveButtonText = document.createTextNode(pageId);
            newActiveSpan.appendChild(newActiveButtonText);

            newActiveButton.replaceChild(newActiveSpan, activeButtonLink);
        }

        function processPrevButton(curPageId) {

            var prevLinkArray = $("div.art-pager a:contains('Prev')");
            if (prevLinkArray.length === 0) return;

            var prevButton = prevLinkArray[0];
            if (curPageId > 1) {
                prevButton.style.display = "";
            } else {
                prevButton.style.display = "none";
            }
        }

        function processNextButton(curPageId, pagesCount) {
        
            var nextLinkArray = $("div.art-pager a:contains('Next')");
            if (nextLinkArray.length === 0) return;

            var nextButton = nextLinkArray[0];

            if (curPageId < pagesCount) {
                nextButton.style.display = "";
            } else {
                nextButton.style.display = "none";
            }
        }

        function switchToPage(pageId) {
            if (!pageId) return;

            var comments = $("div.art-comment");
            var commentsPerPage = self.commentsPerPage;

            var i = 0;

            // hide comments before
            for (; i < comments.length && i < (pageId - 1) * commentsPerPage; i = i + 1) {
                comments[i].style.display = "none";
            }

            // show current page comments
            for (i = (pageId - 1) * commentsPerPage; i < comments.length && i < pageId * commentsPerPage; i = i + 1) {
                comments[i].style.display = "";
            }

            // hide comments after
            for (i = pageId * commentsPerPage; i < comments.length; i = i + 1) {
                comments[i].style.display = "none";
            }
        }

        function reload() {
            buttons = $("div.art-pager>*");
        }
    });
})(jQuery);
jQuery(function () {
    'use strict';
    document.commentsPager = new Pager();
    document.commentsPager.init();
});