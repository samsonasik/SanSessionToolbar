/**
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license.
 */

/**
 * The ';' is places there for wrong closed modules
 *
 * @this win
 * document is now doc, which reffers only to the local scope
 * @instance
 * The value of undefined is guaranteed as being truly
 * undefined. This is to avoid issues with undefined being
 * mutable pre-ES5. Comment was taking from http://addyosmani.com/blog/essential-js-namespacing/
 */
;(function (win, doc, undefined) {
    'use strict';

    /**
     * IE 8+
     */
    win.fakejQuery = doc.querySelectorAll.bind(doc)
    var sanSessionToolbarURL = doc.getElementById("sanSessionToolbarURL").innerHTML;

    var sanSessionToolbar = {
        init: function () {
            sanSessionToolbar.eventHandler('.removeSessionByKey', "click", sanSessionToolbar.removeSessionByKey);
            sanSessionToolbar.eventHandler('.reloadSession', "click", sanSessionToolbar.reloadSession);
            sanSessionToolbar.eventHandler('.clearAllSession', "click", sanSessionToolbar.clearAllSession);
            sanSessionToolbar.eventHandler('.clearSessionOfContainer', "click", sanSessionToolbar.clearSessionOfContainer);
            sanSessionToolbar.eventHandler('.editSessionByKey', "click", sanSessionToolbar.editSessionByKey);
            sanSessionToolbar.eventHandler('.cancelSaveSessionByKey', "click", sanSessionToolbar.cancelSaveSessionByKey);
            sanSessionToolbar.eventHandler('.saveSessionByKey', "click", sanSessionToolbar.saveSessionByKey);
            sanSessionToolbar.eventHandler('.cancelNewSessionData', "click", sanSessionToolbar.cancelNewSessionData);
            sanSessionToolbar.eventHandler('.addNewSessionData', "click", sanSessionToolbar.addNewSessionData);
            sanSessionToolbar.eventHandler('.saveNewSessionData', "click", sanSessionToolbar.saveNewSessionData);
        },

        removeSessionByKey: function (e) {
            // IE hack
            e = e || window.event;
            e.preventDefault();

            // cross-browser event target
            var trg = e.target ? e.target : e.srcElement;

            var containerName = trg.parentNode.getAttribute("data-container");
            var keysession = trg.parentNode.getAttribute("data-keysession");
            var params = "containerName="+containerName+"&keysession="+keysession;
            sanSessionToolbar.postDataWithAjax(sanSessionToolbarURL+'/removesession', function (html) {
                if (html.success) {
                    // top parent level for this session key - span tag
                    var elements = doc.querySelector(".san-session-toolbar-info-containerName-"+containerName+"-keysession-"+keysession);
                    if (elements !== undefined) {
                        elements.parentNode.removeChild(elements);
                    }
                } else {
                    alert('No session registered with container named "'+containerName+'" and key session "'+keysession+'" or session already removed');
                }
            }, params);
        },

        reloadSession: function (e) {
            // IE hack
            e = e || window.event;
            e.preventDefault();
            sanSessionToolbar.postDataWithAjax(sanSessionToolbarURL+'/reloadsession', function (html) {
                doc.querySelector('#san-session-toolbar-detail').innerHTML = html.san_sessiontoolbar_data_renderedContent;
            }, null);
        },

        clearAllSession: function (e) {
            // IE hack
            e = e || window.event;
            e.preventDefault();
            sanSessionToolbar.postDataWithAjax(sanSessionToolbarURL+'/clearsession', function (html) {
                doc.querySelector('#san-session-toolbar-detail').innerHTML = html.san_sessiontoolbar_data_renderedContent;
            }, null);
        },

        clearSessionOfContainer: function (e) {
            // IE hack
            e = e || window.event;
            e.preventDefault();
            // cross-browser event target
            var trg = e.target ? e.target : e.srcElement;
            var params = "byContainer="+trg.getAttribute("data-container");

            sanSessionToolbar.postDataWithAjax(sanSessionToolbarURL+'/clearsession', function (html) {
                doc.querySelector('#san-session-toolbar-detail').innerHTML = html.san_sessiontoolbar_data_renderedContent;
            }, params);
        },

        editSessionByKey: function (e) {
            // IE hack
            e = e || window.event;
            e.preventDefault();
            // cross-browser event target
            var trg = e.target ? e.target : e.srcElement;
            var containerName = trg.parentNode.getAttribute("data-container");
            var keysession = trg.parentNode.getAttribute("data-keysession");

            doc.querySelector("#san-session-toolbar-info-containerName-"+containerName+"-keysession-"+keysession).style.display = 'none';
            doc.querySelector("#san-edit-mode-session-toolbar-info-containerName-"+containerName+"-keysession-"+keysession).style.display = 'block';
        },

        cancelSaveSessionByKey: function (e) {
            // IE hack
            e = e || window.event;
            e.preventDefault();
            // cross-browser event target
            var trg = e.target ? e.target : e.srcElement;
            var containerName = trg.parentNode.getAttribute("data-container");
            var keysession = trg.parentNode.getAttribute("data-keysession");

            doc.querySelector("#san-session-toolbar-info-containerName-"+containerName+"-keysession-"+keysession).style.display = 'block';
            doc.querySelector("#san-edit-mode-session-toolbar-info-containerName-"+containerName+"-keysession-"+keysession).style.display = 'none';

            // empty error
            doc.querySelector('#errorMessage-containerName-'+containerName+'-keysession-'+keysession).innerHTML = '';
            // re-fill input with current content
            doc.querySelector('#san-detail-value-containerName-'+containerName+'-keysession-'+keysession).value = doc.querySelector('#san-session-toolbar-detail-value-'+containerName+'-'+keysession).innerHTML.trim();
        },

        saveSessionByKey: function (e) {
            // IE hack
            e = e || window.event;
            e.preventDefault();
            // cross-browser event target
            var trg = e.target ? e.target : e.srcElement;

            var containerName = trg.parentNode.getAttribute("data-container");
            var keysession = trg.parentNode.getAttribute("data-keysession");
            var params = "containerName="+containerName+"&keysession="+keysession+"&sessionvalue="+doc.querySelector('#san-detail-value-containerName-'+containerName+'-keysession-'+keysession).value+"&new=0";
            sanSessionToolbar.postDataWithAjax(sanSessionToolbarURL+'/savesession', function (html) {
                if (html.success) {
                    doc.querySelector('#san-session-toolbar-detail').innerHTML = html.san_sessiontoolbar_data_renderedContent;
                } else {
                    if (html.errorMessage === '') {
                        alert('Save session failed, check if no session registered with container named "'+containerName+'" and key session "'+keysession+'" or session already removed');
                    } else {
                        doc.querySelector('#errorMessage-containerName-'+containerName+'-keysession-'+keysession).innerHTML = html.errorMessage;
                    }
                }
            }, params);
        },

        cancelNewSessionData: function (e) {
            // IE hack
            e = e || window.event;
            e.preventDefault();
            // cross-browser event target
            var trg = e.target ? e.target : e.srcElement;
            var containerName = trg.parentNode.getAttribute("data-container");

            doc.querySelector("#san-session-toolbar-info-add-new-data-containerName-"+containerName).style.display = 'none';
            // empty error
            doc.querySelector('#errorMessage-add-new-data-containerName-'+containerName).innerHTML = '';
        },

        addNewSessionData: function (e) {
            // IE hack
            e = e || window.event;
            e.preventDefault();
            // cross-browser event target
            var trg = e.target ? e.target : e.srcElement;
            var containerName = trg.getAttribute("data-container");
            doc.querySelector("#san-session-toolbar-info-add-new-data-containerName-"+containerName).style.display = 'block';
        },

        saveNewSessionData: function (e) {
            // IE hack
            e = e || window.event;
            e.preventDefault();
            // cross-browser event target
            var trg = e.target ? e.target : e.srcElement;
            var containerName = trg.parentNode.getAttribute("data-container");
            var newSessionKey  = doc.querySelector('#san-add-value-sessionkey-containerName-'+containerName).value;
            var newSessionData = doc.querySelector('#san-add-value-sessiondata-containerName-'+containerName).value;
            var params = "containerName="+containerName+"&keysession="+newSessionKey+"&sessionvalue="+newSessionData+"&new=1";

            sanSessionToolbar.postDataWithAjax(sanSessionToolbarURL+'/savesession', function (html) {
                if (html.success) {
                    doc.querySelector('#san-session-toolbar-detail').innerHTML = html.san_sessiontoolbar_data_renderedContent;
                } else {
                    if (html.errorMessage === '') {
                        alert('Save new session failed, check if session with container named "'+containerName+'" and key session "'+newSessionKey+'" already registered');
                    } else {
                        doc.querySelector('#errorMessage-add-new-data-containerName-'+containerName).innerHTML = html.errorMessage;
                    }
                }
            }, params);
        },

        /**
         * @param {string} element The element that's going to be selected
         * @param {string} event type (click, change, hover etc)
         * @callback setViewCallBack The callback that handles the request.
         */
        eventHandler: function (element, eventType, fn) {
            if (doc.addEventListener) {
                for (var i = fakejQuery(element).length - 1; i >= 0; i--) {
                    fakejQuery(element)[i].addEventListener(eventType, fn, false)
                }
            } else if (doc.attachEvent) {
                for (var i = fakejQuery(element).length - 1; i >= 0; i--) {
                    fakejQuery(element)[i].attachEvent("on" + eventType, fn)
                }
            } else {
                alert("Ooops, no event listener methods found!");
            }
        },

        /**
         * @param {string} url where the POST will be send
         * @callback setViewCallBack The callback that handles the response.
         * @param {string} params holds the container name and the keysession
         */
        postDataWithAjax: function (url, setViewCallBack, params) {
            var xhr = new(window.XMLHttpRequest || ActiveXObject)('MSXML2.XMLHTTP.3.0');

            xhr.open("POST", url, true);

            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded; charset=UTF-8");
            xhr.setRequestHeader("Accept", "application/json");
            xhr.timeout = 30000;
            xhr.onreadystatechange = function () {
                if (this.readyState === 4) {
                    if (this.status >= 200 && this.status < 400) {
                        setViewCallBack(JSON.parse(this.responseText));
                        sanSessionToolbar.init();
                    } else {
                        console.log(this.statusText);
                        console.log(this.status);
                        console.log(this.responseText);
                    }
                }
            }
            xhr.send(params);
            xhr = null;
        },
    };

    /**
     * Init everything => $(document).ready(function(){});
     */
    if (doc.readyState === 'complete') {
        setTimeout(sanSessionToolbar.init);
    } else if (doc.addEventListener) {
        doc.addEventListener("DOMContentLoaded", sanSessionToolbar.init, false);
        doc.addEventListener("load", sanSessionToolbar.init, false);
    } else {
        doc.attachEvent('onreadystatechange', sanSessionToolbar.init);
        win.attachEvent("onload", sanSessionToolbar.init);
    }
})(this, document);
