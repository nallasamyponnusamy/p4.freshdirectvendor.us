<!--<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">-->
<!--<html xmlns="http://www.w3.org/1999/xhtml">-->
<!--<head>-->
<!--    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />-->
<!--    <title>Food Safety Log - Create Event</title>-->
<!---->
<!--    <link rel="stylesheet" href="/scripts/jquery/ui/themes/redmond/jquery.ui.all.css">-->
<!--    <link type="text/css" rel="stylesheet" href="css/main.css" />-->
<!--    <link href="/scripts/jquery-tableSorter/themes/blue/style.css" type="text/css" rel="stylesheet" />-->
<!---->
<!--    <style type="text/css">-->
<!--        table.tablesorter tbody td-->
<!--        {-->
<!--            background-color: #FFF !important;-->
<!--        }-->
<!--    </style>-->
<!--</head>-->
<!--<body>-->
<?php
// specify DB name
//$dbName= "freshdir_p4_freshdirectvendor_us" ;

// include DB connection settings
//require_once "includes/config.php";
//require_once "includes/class.mysql.php";
//$db = new mysql();

// include user authentication code
//include_once( 'includes/authenticateuser.php' );

//$AuthUserID = strip_tags($_GET['d']);

//$AuthUserID = '2';
/*if (empty($AuthUserID))
{
	die ("<center><h3>You do not have access to this page.</h3></center>");
} else
{
	// checks that user is authorized
	$sqlAuthentication = 'SELECT EmployeeName AS AuthUserName
						FROM users
						WHERE MD5(AuthUserID) = "'.$AuthUserID.'"
						AND isActive = 1';

	$sqlAuthenticationResults = $db->query($sqlAuthentication);

	// check if row is returned, if yes error, if no get values
	if ($db->numRows($sqlAuthenticationResults) == 0)
	{
		die ('<center><h3>You do not have access to this page. Please contact the Food Safety Department</h3></center>');
	} else
	{
		$rowAuthenticationResults = $db->fetch($sqlAuthenticationResults);

		$AuthUserName = $rowAuthenticationResults['AuthUserName'];
	}
}*/

//$dateValue = date('Y-m-d g:i a');
?>
<div style="width: 100%; position: absolute; z-index: 100; margin: 5px 0px 0px 0px;" id="notificationDiv">
    <div class="error-note-bar">
        <p>An error has occurred and it has been reported. We apologize...</p>
    </div>
    <div class="success-note-bar">
        <p>New event entry has been created...</p>
    </div>
</div>
<!--<input type="hidden" name="createdBy" id="createdBy" value="--><?php //echo $AuthUserID ?><!--" />-->
<input type="hidden" name="createdBy" id="createdBy" value="1"/>
<div id="mainContent" style="width: 980px; margin: 10px 0px 0px 20px;">
    <div style="margin: 0px 0px 5px 0px; padding: 8px 0px 8px 5px; font-size: 16px; background-color: #CCC;">
        Create Event
    </div>
    <div style="text-align: left; padding: 0px 0px 10px 5px; overflow: auto;">
        <div style="float: left; width: 250px;"><span style="color: #FF0000;">* indicates required fields</span></div>
        <div style="float: left; width: 300px; font-weight: bold;">Select Department: <select style="width: 181px;"
                                                                                              name="departmentList"
                                                                                              id="departmentList">
                <option value="">--- Select ---</option>
                <?php
                //                $sqlDepartmentList = '(SELECT "Non Production" AS isProduction
                //							, DepartmentID AS DepartmentID
                //							, DepartmentName AS DepartmentName
                //						FROM NonProductionDepartmentList
                //						WHERE isActive = 1
                //						ORDER BY DepartmentName)
                //						UNION
                //						(SELECT "Production" AS isProduction
                //							, DepartmentID AS DepartmentID
                //							 , DepartmentName AS DepartmentName
                //						FROM ProductionDepartmentList
                //						WHERE isActive = 1
                //						ORDER BY DepartmentName);';

                // separates production from non production departments
                //                $DepartmentGroup = '';
                //                $i = 0;

                // retrieve event types from db, else error
                //                if (!($sqlDepartmentListResults = $db->query($sqlDepartmentList)))
                //                {
                //                    die('<option value="">Error Department</option>');
                //                } else
                //                {
                //                    if ($db->numRows($sqlDepartmentListResults) == 0)
                //                    {
                //                        echo '<option value="">No Departments Exist</option>';
                //                    } else
                //                    {

                foreach ($posts as $rowDepartmentListResults):
//                     while ( $rowDepartmentListResults = $db->fetch($sqlDepartmentListResults) )
                {
                    if (empty($DepartmentGroup)) {
                        echo '<optgroup label="' . $rowDepartmentListResults["isProduction"] . '">';
                        echo '<option value="' . $rowDepartmentListResults["DepartmentID"] . '-' . str_replace(" ", "", $rowDepartmentListResults["isProduction"]) . '">' . $rowDepartmentListResults["DepartmentName"] . '</option>';
                        $DepartmentGroup = $rowDepartmentListResults["isProduction"];
                    } else {
//                                if ($i == $db->numRows($sqlDepartmentListResults))
//                                {
//                                    echo '<option value="'.$rowDepartmentListResults["DepartmentID"].'-'.str_replace(" ", "", $rowDepartmentListResults["isProduction"]).'">'.$rowDepartmentListResults["DepartmentName"].'</option>';
//                                    echo '</optgroup>';
//                                } else
//                                {
                        if ($rowDepartmentListResults["isProduction"] <> $DepartmentGroup) {
                            echo '</optgroup>';
                            echo '<optgroup label="' . $rowDepartmentListResults["isProduction"] . '">';
                            echo '<option value="' . $rowDepartmentListResults["DepartmentID"] . '-' . str_replace(" ", "", $rowDepartmentListResults["isProduction"]) . '">' . $rowDepartmentListResults["DepartmentName"] . '</option>';
                            $DepartmentGroup = $rowDepartmentListResults["isProduction"];
                        } else {
                            echo '<option value="' . $rowDepartmentListResults["DepartmentID"] . '-' . str_replace(" ", "", $rowDepartmentListResults["isProduction"]) . '">' . $rowDepartmentListResults["DepartmentName"] . '</option>';
                        }
                    }
                }
//                            $i++;

                endforeach; ?>
                <!--                    }-->
                <!--                }-->
                ?>
            </select></div>
    </div>
    <div class="fieldsDiv" style="height: 335px;"></div>
    <div id="submitButtonDiv" class="submitButtonDiv">
        <!--        <div id="messageDiv" style="width: 400px;"><input type="button" name="noDeficienciesButton" id="noDeficienciesButton" value="No Deficiencies Found" disabled="disabled" /></div><div style="float: left;"><input type="button" name="submitButton" id="submitButton" value="Submit" onclick="CreateEventLog('messageDiv')" disabled="disabled" /></div>-->
        <div id="messageDiv" style="width: 400px;"><input type="button" name="noDeficienciesButton"
                                                          id="noDeficienciesButton" value="No Deficiencies Found"
                                                          disabled="disabled"/></div>
        <div style="float: left;"><input type="button" name="submitButton" id="submitButton" value="Submit"
                                         onclick="CreateEventLog('messageDiv')" disabled="disabled"/></div>
    </div>
</div>
<?php
//mysql_close($db);
?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>
<script type="text/javascript" src="/scripts/jquery-tableSorter/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="/scripts/jquery.textarea-expander.js"></script>
<script type="text/javascript" src="scripts/helperScripts.js"></script>
<script type="text/javascript" src="scripts/createEventLog.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        // initialize date selection box
        //$("#eventDate").datepicker({ /*minDate: 0*/ });

        // bind event type to event subtype selection
        $("#departmentList").bind("change", function () {
            if ($("#departmentList").val() != '') {
                // loading image
                $('.fieldsDiv').html('<p style="text-align: center; padding: 100px 0px 0px 0px;"><img src="/images/ajax-loader.gif" width="220" height="29" /></p>');
                // retrieve subtypes for selected category type
                $.ajax({
                    type: "GET",
//                    url: "includes/retrieveForm.php",
                    url: "/posts/p_addevent",
                    data: "d=" + $("#departmentList").val(),
                    success: function (html) {
                        // enable No Deficiencies button and disable the Submit button
                        $('#noDeficienciesButton').prop('disabled', false);
                        $('#submitButton').prop('disabled', true);

                        // reset any notification when new department is selected
                        $('#notificationDiv div').each(function () {
                            $(this).css('display', 'none');
                        });

                        // display subtype dropdown HTML for
                        $(".fieldsDiv").html(html);

                        // initialize newtextarea autosize
                        $('textarea').autogrow();
                        $('table').css('table-layout', 'fixed');
                        $('textarea').css('resize', 'none');
                        $('.isDeficiencyFound').css('width', '30px');

                        // enable textareas on change
                        $("input:checkbox").on('change', function () {
                            var str = $(this).val();
                            var splitStr = str.split("-");

                            // enable textareas for selected deficiency
                            // if corresponding checkbox is check
                            if ($(this).is(':checked')) {
                                $('textarea[name="deficiencyComments-' + splitStr[1] + '"]').prop('disabled', false).css('border', '1px solid #f00').focus();
                                $('textarea[name="correctiveActions-' + splitStr[1] + '"]').prop('disabled', false);
                            } else {
                                // else disable
                                $('textarea[name="deficiencyComments-' + splitStr[1] + '"]').prop('disabled', true).css('border', '1px solid #999');
                                $('textarea[name="correctiveActions-' + splitStr[1] + '"]').prop('disabled', true);
                            }

                            // if there's at least one checkbox checked,
                            // enable submit button
                            if ($('input[type=checkbox]:checked').size() > 0) {
                                $('#submitButton').prop('disabled', false);
                                $('#noDeficienciesButton').prop('disabled', true);
                            } else {
                                $('#submitButton').prop('disabled', true);
                                $('#noDeficienciesButton').prop('disabled', false);
                            }
                        });

                    }
                })
            }
        });

        // bind event type to event subtype selection
        $("#noDeficienciesButton").bind("click", function () {
            var createdBy = <?php echo  $user->AuthUserID ?>;
//            var createdBy =  document.getElementById('createdBy').value;
            var departmentID = document.getElementById('departmentID').value;
            var departmentGroup = document.getElementById('departmentGroup').value;

            $.ajax({
                type: 'GET',
//                url: 'includes/EventLogCreation.php',
                url: '/posts/p_addevent_to_db',
                data: 'd=' + $('#createdBy').val() + '&dept=' + $('#departmentID').val() + '&g=' + $('#departmentGroup').val() + '&sid=' + Math.random() + '&def=0',
                success: function (html) {
                    var returnPage = '/posts/add';

                    if (html == 1) {
                        onResponseEnd();
                        $('#mainContent input, select, textarea, button').each(function () {
                            $(this).attr("disabled", true);
                        });

                        $('#messageDiv').html('&nbsp;&nbsp;<a href="' + returnPage + '?d=' + createdBy + '" class="returnLinks">Return...</a>');
                        $(".success-note-bar").slideDown(100);
                    } else {
                        onResponseEnd();
                        $('#mainContent input, select, textarea, button').each(function () {
                            $(this).attr("disabled", true);
                        });

                        $('#messageDiv').html('&nbsp;&nbsp;<a href="' + returnPage + '?d=' + createdBy + '" class="returnLinks">Return...</a>');
                        $(".error-note-bar").slideDown(100);
                    }
                }
            });
        });

        // limit number of characters for textbox
        /*	$("#eventComments").limita({
         limit: eventCommentsCounterLimit,
         id_result: "eventCommentsCounter",
         alertClass: "characterLimitAlert"
         });*/
    });
</script>
<?php //include_once("../analyticstracking.php") ?>
</body>
<!--</html>-->