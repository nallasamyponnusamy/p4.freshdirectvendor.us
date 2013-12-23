<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Food Safety - Search Log</title>

    <link rel="stylesheet" href="/scripts/jquery/ui/themes/redmond/jquery.ui.all.css">
    <link href="/scripts/jquery-tableSorter/themes/blue/style.css" type="text/css" rel="stylesheet"/>
    <link type="text/css" rel="stylesheet" href="css/main.css"/>

    <style type="text/css">
        .tableClass {
            font-size: 10px;
            border: 1px solid #000;
            overflow: auto;
            background-color: #66CCFF;
            width: 995px;
        }

        #tableHeader {
            float: left;
            margin: 0px 1px 0px 2px;
        }

        #callListTable {
            border: 1px solid #000000;
            font-size: 10px;
            color: #000;
        }

        .normTD {
            background-color: #FFF !important;
        }

        .altTD {
            background-color: #EAEAEA !important;
        }

        /*table.tablesorter tbody tr:nth-child(even)
        {
            background-color: #6E6E6E !important;
        }*/

        .returnLinkDiv {
            display: none;
            border: 1px #000000 solid;
            background-color: #FFF;
            margin: 10px 0px 10px 0px;
            padding: 10px 0px 10px 0px;
            overflow: auto;
        }

        a.returnLink:link, a.returnLink:active, a.returnLink:visited {
            text-decoration: none;
            color: #F00;
            font-weight: bold;
            font-size: 12px;
        }

        a.returnLink:hover {
            text-decoration: underline;
            color: #F00;
            font-weight: bold;
            font-size: 12px;
        }
    </style>
</head>
<body>
<center>
<!--    --><?php
//    $AuthUserID = strip_tags($_GET['d']);
//
//    // specify DB name
//    $dbName = "freshdir_p4_freshdirectvendor_us";
//
//    // include DB connection settings
//    require_once "includes/config.php";
//    require_once "includes/class.mysql.php";
//    $db = new mysql();
//    ?>
    <form id="searchEventLog" name="searchEventLog">
        <input type="hidden" name="createdBy" id="createdBy" value="<?php echo $AuthUserID ?>"/>

        <div class="returnLinkDiv"><a class="returnLink" href="SearchEventLog.php?d=<?php echo $AuthUserID; ?>">Return
                to Search Screen...</a></div>
        <div id="mainContent" style="width: 810px; height: 450px;">
            <div>
                <h3>Search Event Log</h3>
            </div>
            <div style="text-align: left; padding: 0px 0px 10px 5px; color: #FF0000;">
                * indicates required fields
            </div>
            <div class="fieldsDiv">
                <div style="clear: both; margin: 0px 0px 0px 200px;">
                    <div class="fieldName" style="width: 100px;">
                        Start Date:
                    </div>
                    <div class="fieldInput">
                        <input type="text" name="startDate" id="startDate" value=""/>
                    </div>
                </div>
                <div style="clear: both; margin: 0px 0px 0px 200px;">
                    <div class="fieldName" style="width: 100px;">
                        End Date:
                    </div>
                    <div class="fieldInput">
                        <input type="text" name="endDate" id="endDate" value=""/>
                    </div>
                </div>
                <div style="clear: both; border-top: 1px #999999 solid; padding: 0px 0px 2px 0px;">
                    <span
                        style="font-weight: bold; font-family: Tahoma,Verdana,Segoe,sans-serif; font-size: 14px; display: block; padding: 5px 0px 5px 0px;">Filter by Department and Deficiency</span>

                    <div style="width: 760px; padding: 10px 0px 10px 2px; border: 1px solid #000000; overflow: auto;">
                        <div style="float: left; width: 225px; padding: 0px 5px 0px 0px;">
                            <div style="padding: 3px 0px 3px 0px; text-align: center; font-weight: bold;">
                                Department
                            </div>
                            <div>
                                <select name="departmentList" id="departmentList" size="11" style="width: 225px;">
                                    <?php
                                    $sqlDepartmentList = '(SELECT "Non Production" AS isProduction
										, DepartmentID AS DepartmentID
										, DepartmentName AS DepartmentName
									FROM NonProductionDepartmentList
									WHERE isActive = 1
									ORDER BY DepartmentName)
									UNION
									(SELECT "Production" AS isProduction
										, DepartmentID AS DepartmentID
										 , DepartmentName AS DepartmentName
									FROM ProductionDepartmentList
									WHERE isActive = 1
									ORDER BY DepartmentName);';

                                    // separates production from non production departments
                                    $DepartmentGroup = '';
                                    $i = 0;

                                    // retrieve event types from db, else error
                                    if (!($sqlDepartmentListResults = $db->query($sqlDepartmentList))) {
                                        die('<option value="">Error Department</option>');
                                    } else {
                                        if ($db->numRows($sqlDepartmentListResults) == 0) {
                                            echo '<option value="">No Departments Exist</option>';
                                        } else {
                                            while ($rowDepartmentListResults = $db->fetch($sqlDepartmentListResults)) {
                                                if (empty($DepartmentGroup)) {
                                                    echo '<optgroup label="' . $rowDepartmentListResults["isProduction"] . '">';
                                                    echo '<option value="' . $rowDepartmentListResults["DepartmentID"] . '-' . str_replace(" ", "", $rowDepartmentListResults["isProduction"]) . '">' . $rowDepartmentListResults["DepartmentName"] . '</option>';
                                                    $DepartmentGroup = $rowDepartmentListResults["isProduction"];
                                                } else {
                                                    if ($i == $db->numRows($sqlDepartmentListResults)) {
                                                        echo '<option value="' . $rowDepartmentListResults["DepartmentID"] . '-' . str_replace(" ", "", $rowDepartmentListResults["isProduction"]) . '">' . $rowDepartmentListResults["DepartmentName"] . '</option>';
                                                        echo '</optgroup>';
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
                                                $i++;
                                            }
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div style="float: left; width: 500px; padding: 0px 0px 0px 5px;">
                            <div style="padding: 3px 0px 3px 0px; text-align: center; font-weight: bold;">
                                Deficiencies
                            </div>
                            <div id="selectBoxDeficienciesDiv">
                                <select name="deficiencyList" id="deficiencyList" multiple="multiple" size="11"
                                        style="width: 500px;"></select>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="submitButtonDiv" class="submitButtonDiv">
                    <div style="text-align: center;"><input type="button" name="submitButton" id="submitButton"
                                                            value="Submit"/></div>
                </div>
            </div>
        </div>
    </form>
    <?php
    //mysql_close($db);
    ?>
</center>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>
<script type="text/javascript" src="scripts/helperScripts.js"></script>
<script type="text/javascript" src="/scripts/jquery-tableSorter/jquery.tablesorter.min.js"></script>
<script type="text/javascript">

    $(document).ready(function () {
        $("#startDate").datepicker({
            onClose: function (selectedDate) {
                $("#endDate").datepicker("option", "minDate", selectedDate);
            }
        });

        $("#endDate").datepicker({
            onClose: function (selectedDate) {
                $("#startDate").datepicker("option", "maxDate", selectedDate);
            }
        });

        // on change display the deficiency list for selected department
        $("#departmentList").bind("change", function () {
            if ($(this).val() !== null) {
                $.ajax({
                    type: "GET",
                    url: "includes/getdeficiencies.php",
                    data: "q=" + $("#departmentList").val(),
                    success: function (html) {
                        if (html.indexOf("ERROR") < 0) {
                            $("#selectBoxDeficienciesDiv").html(html);
                        } else {
                            alert('An error has occurred and it has been reported. We apologize...');
                            $('#mainContent input, select').each(function () {
                                $(this).prop('disabled', true);
                            })
                        }
                    }
                });
            }
        });

        // bind event type to event subtype selection
        $("#submitButton").bind("click", function () {
            if (($("#startDate").val() == '') && ($("#endDate").val() == '') && (($("#departmentList").val() || []) == '')) {
                alert('Please select at least ONE filter to search by...');
            } else {
                $.ajax({
                    type: "GET",
                    url: "includes/SearchEventLog.php",
                    data: "d=" + encodeURIComponent($("#createdBy").val()) + "&sd=" + encodeURIComponent($("#startDate").val()) + "&ed=" + encodeURIComponent($("#endDate").val()) + "&deptl=" + (encodeURIComponent($("#departmentList").val()) || []) + "&defl=" + (encodeURIComponent($("#deficiencyList").val()) || []),
                    success: function (html) {
                        $("#mainContent").css('width', 'auto');
                        $("#mainContent").css('height', 'auto');
                        $("#mainContent").html(html);
                        $('.returnLinkDiv').show();
                    }
                });
            }
        });
    });
</script>
</body>
</html>