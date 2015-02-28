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
function sanSessionToolbar_removeSessionByKey(key, keysession)
{
    var xmlhttp; // @see http://www.w3schools.com/ajax/ajax_xmlhttprequest_create.asp
    if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    } else { // code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }

    var params = "key="+key+"&keysession="+keysession;
    xmlhttp.open("POST",san_session_toolbar_base_url+'/san-session-toolbar/removesession', true);

    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.setRequestHeader("Accept", "application/json");
    xmlhttp.setRequestHeader("Content-length", params.length);
    xmlhttp.setRequestHeader("Connection", "close");

    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            var html = JSON.parse(xmlhttp.responseText);
            if (html.success) {
                var elements = document.getElementsByClassName("san-session-toolbar-info-key-"+key+"-keysession-"+keysession);
                while(elements.length > 0){
                    elements[0].parentNode.removeChild(elements[0]);
                }
            } else {
                alert('No session registered with container named "'+key+'" and key session "'+keysession+'" or session already removed');
            }
        }
    }

    xmlhttp.send(params);
}
