var xmlHttpCreateEventLog;

// checks if all values have been filled and submits them for creation by server side script
// ===================================================
function CreateEventLog(targetDiv) {
    xmlHttpCreateEventLog = GetXmlHttpObject();

    if (xmlHttpCreateEventLog == null) {
        alert("Browser does not support HTTP Request");
        return;
    }

    var str = ''; //holds the name and values of the input fields
    var emptyFlag = 0; //indicates if any required fields are empty
    var createdBy = document.getElementById('createdBy').value;
    var departmentID = document.getElementById('departmentID').value;
    var departmentGroup = document.getElementById('departmentGroup').value;
    var dc = '';
    var ca = '';

    $("input:checkbox").each(function () {
        if ($(this).is(':checked')) {
            var fieldName = $(this).val();
            var splitFieldName = fieldName.split("-");

            dc = ($.trim($('textarea[name="deficiencyComments-' + splitFieldName[1] + '"]').val()) == '') ? emptyFlag = 1 : $.trim($('textarea[name="deficiencyComments-' + splitFieldName[1] + '"]').val());
            ca = ($.trim($('textarea[name="correctiveActions-' + splitFieldName[1] + '"]').val()) == '') ? 'N/A' : $.trim($('textarea[name="correctiveActions-' + splitFieldName[1] + '"]').val());

            str += 'deficiencyComments-' + splitFieldName[1] + "=" + encodeURIComponent(dc) + "&";
            str += 'correctiveActions-' + splitFieldName[1] + "=" + encodeURIComponent(ca) + "&";
        }
    });

    // if all required fields were completed...
    if ((emptyFlag == 0) && (createdBy != "") && (departmentGroup != "") && (departmentID != "")) {
//		var url="includes/EventLogCreation.php";
        var url = "/posts/p_addevent_to_db";
        url = url + "?" + str;
        url = url + "d=" + createdBy;
        url = url + "&dept=" + departmentID;
        url = url + "&g=" + departmentGroup;
        url = url + "&def=1";
        url = url + "&sid=" + Math.random();
        xmlHttpCreateEventLog.onreadystatechange = function () {
            stateChangedCreateEventLog(targetDiv, createdBy);
        };
        xmlHttpCreateEventLog.open("GET", url, true);
        xmlHttpCreateEventLog.send(null);
    } else {
        if (createdBy != "") {
            alert('Please complete all required fields...');
            return;
        } else {
            $('body input, select, textarea').each(function () {
                $(this).attr("disabled", true);
            });

            document.getElementById('submitButton').disabled = true;
            alert('*** ERROR ***\n\nPlease contact your administrator');
            return;
        }
    }
}

function stateChangedCreateEventLog(targetDiv, createdBy) {
    onRequestStart(); // show fetching message

    if (xmlHttpCreateEventLog.readyState == 4 || xmlHttpCreateEventLog.readyState == "complete") {
        var returnPage = '/posts/addEvent';

        if (xmlHttpCreateEventLog.responseText == 1) {
            onResponseEnd();
            $('#mainContent input, select, textarea, button').each(function () {
                $(this).attr("disabled", true);
            });
            /*document.getElementById('submitButton').disabled = true;
             document.getElementById(targetDiv).style.textAlign = 'left';*/
            document.getElementById(targetDiv).innerHTML = '&nbsp;&nbsp;<a href="' + returnPage + '?d=' + createdBy + '" class="returnLinks">Return...</a>';
            $(".success-note-bar").slideDown(100);
        } else {
            onResponseEnd();
            $('#mainContent input, select, textarea, button').each(function () {
                $(this).attr("disabled", true);
            });
            /*document.getElementById('submitButton').disabled = true;
             document.getElementById(targetDiv).style.textAlign = 'left';*/
            document.getElementById(targetDiv).innerHTML = '&nbsp;&nbsp;<a href="' + returnPage + '?d=' + createdBy + '" class="returnLinks">Return...</a>';
            $(".error-note-bar").slideDown(100);
        }
    }
}
// ================================================================
// ================================================================