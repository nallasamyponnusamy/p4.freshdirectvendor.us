<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Food Safety Event Log - Display Log</title>

    <!--<link rel="stylesheet" href="/scripts/jquery/ui/themes/redmond/jquery.ui.all.css">-->
    <!--<link href="/scripts/jquery-tableSorter/themes/blue/style.css" type="text/css" rel="stylesheet" />-->
    <!--<link type="text/css" rel="stylesheet" href="css/main.css" />-->
    <!---->
    <!--<style type="text/css">-->
    <!--.tableClass-->
    <!--{-->
    <!--	font-size: 10px;-->
    <!--	border: 1px solid #000;-->
    <!--	overflow: auto;-->
    <!--	background-color: #66CCFF;-->
    <!--	width: 995px;-->
    <!--}-->
    <!---->
    <!--#tableHeader-->
    <!--{-->
    <!--	float: left;-->
    <!--	margin: 0px 1px 0px 2px;-->
    <!--}-->
    <!---->
    <!--#callListTable-->
    <!--{-->
    <!--	border: 1px solid #000000;-->
    <!--	font-size: 10px;-->
    <!--	color: #000;-->
    <!--}-->
    <!---->
    <!--.normTD-->
    <!--{-->
    <!--	background-color: #FFF !important;-->
    <!--}-->
    <!---->
    <!--.altTD-->
    <!--{-->
    <!--	background-color: #ddeeee !important;-->
    <!--}-->
    <!---->
    <!--/*table.tablesorter tbody tr:nth-child(even)-->
    <!--{-->
    <!--	background-color: #6E6E6E !important;-->
    <!--}*/-->
    <!---->
    <!--</style>-->
    <!---->
    <!--</head>-->
<body>
<center>
    <div id="mainContent">
        <?php
        // specify DB name
        //$dbName= "freshdir_p4_freshdirectvendor_us" ;
        //
        //// include DB connection settings
        //require_once "includes/config.php";
        //require_once "includes/class.mysql.php";
        //$db = new mysql();
        //
        //$AuthUserID = strip_tags($_GET['d']);
        //
        //if (empty($AuthUserID))
        //{
        //	die ("<center><h3>You do not have access to this page.</h3></center>");
        //} else
        //{
        //	// checks that user is authorized
        //	$sqlAuthentication = 'SELECT EmployeeName AS AuthUserName
        //						FROM users
        //						WHERE MD5(AuthUserID) = "'.$AuthUserID.'"
        //						AND isActive = 1';
        //
        //	$sqlAuthenticationResults = $db->query($sqlAuthentication);
        //
        //	// check if row is returned, if yes error, if no get values
        //	if ($db->numRows($sqlAuthenticationResults) == 0)
        //	{
        //		$AuthUserName = 'XXXXXXXXX';
        //		//die ('<center><h3>You do not have access to this page. Please contact the Food Safety Department</h3></center>');
        //	} else
        //	{
        //		$rowAuthenticationResults = $db->fetch($sqlAuthenticationResults);
        //
        //		$AuthUserName = $rowAuthenticationResults['AuthUserName'];
        //	}
        //}
        ?>
        <div style="overflow: auto; background-color: #E9E9E9;">
            <div style="float: left; padding: 8px 0px 2px 10px;">
                <span style="font-weight: bold;">Filter by:</span>
                <select style="width: 181px;" id="filterDropdown" name="filterDropdown">
                    <option value="Non Production">Non Production</option>
                    <option value="Production">Production</option>
                </select>
            </div>
            <div id="refreshLink" style="font-size: 11px; padding: 2px 400px 2px 0px; float: right;">
                <input type="button" value="Refresh Listing..."/>
            </div>
        </div>
        <div id="callList"></div>
    </div>
</center>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>
<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>
<script type="text/javascript" src="/scripts/jquery-tableSorter/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="scripts/helperScripts.js"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $("#refreshLink input")
            .button()
            .click(function () {
                location.reload();
                $("#filterDropdown").val('Non Production');
            });

        // bind event type to event subtype selection
        $("#filterDropdown").bind("change", function () {
            $.ajax({
                type: "GET",
//			url: "includes/ReturnFilteredResults.php",
                url: "/posts/deficiency_view",
                data: "str=" + encodeURIComponent($("#filterDropdown").val()) + "&d=1",
                success: function (html) {
                    $("#callList").html(html);
                }
            });
        });

        $("#filterDropdown").change();
    });
</script>

<?php //include_once("../analyticstracking.php") ?>
</body>
<!--</html>-->