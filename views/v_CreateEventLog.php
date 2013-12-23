
<div style="width: 100%; position: absolute; z-index: 100; margin: 5px 0px 0px 0px;" id="notificationDiv">
    <div class="success-note-bar">
        <p>New event entry has been created..Click Return!.</p>
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

                foreach ($posts as $rowDepartmentListResults):
//                     while ( $rowDepartmentListResults = $db->fetch($sqlDepartmentListResults) )
                {
                    if (empty($DepartmentGroup)) {
                        echo '<optgroup label="' . $rowDepartmentListResults["isProduction"] . '">';
                        echo '<option value="' . $rowDepartmentListResults["DepartmentID"] . '-' . str_replace(" ", "", $rowDepartmentListResults["isProduction"]) . '">' . $rowDepartmentListResults["DepartmentName"] . '</option>';
                        $DepartmentGroup = $rowDepartmentListResults["isProduction"];
                    } else {
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

                endforeach; ?>
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
                url: "/posts/p_addevent_to_db",
                data: 'd=' + $('#createdBy').val() + '&dept=' + $('#departmentID').val() + '&g=' + $('#departmentGroup').val() + '&sid=' + Math.random() + '&def=0',
                success: function (html) {
                    var returnPage = '/posts/addEvent';

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
    });
</script>
</body>
