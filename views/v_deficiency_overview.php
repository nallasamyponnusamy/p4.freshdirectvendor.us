<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Food Safety Event Log - Display Log</title>

<body>
<center>
    <div id="mainContent">
        <?php
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

</body>
<!--</html>-->