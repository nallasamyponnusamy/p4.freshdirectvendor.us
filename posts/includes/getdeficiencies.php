<?php
$DepartmentString = strip_tags($_GET["q"]);

// split string to the department ID and group (production/non production)
$DepartmentStringArray = explode("-", $DepartmentString);
$DepartmentID = $DepartmentStringArray[0];
$DepartmentGroup = $DepartmentStringArray[1];
// *********************************************

if (empty($DepartmentString)) {
    echo '<select name="deficiencyList" id="deficiencyList" multiple="multiple" size="11" style="width: 500px;">';
    echo '<option value="" selected="selected">*** ERROR (MP) ***</option>';
    echo '</select>';
} else {
    // specify DB name
    $dbName = "freshdir_p4_freshdirectvendor_us";

    // include DB connection settings
    require_once "config.php";
    require_once "class.mysql.php";
    $db = new mysql();

    $sqlDeficiencyList = 'SELECT DL.' . $DepartmentGroup . 'DeficiencyID AS DeficiencyID
											, DL.' . $DepartmentGroup . 'DeficiencyName AS DeficiencyName
						FROM ' . $DepartmentGroup . 'DepartmentAuditChecklist AS DAC
							LEFT JOIN ' . $DepartmentGroup . 'DeficienciesList AS DL ON ((DAC.DepartmentID = ' . $DepartmentID . ')
																		AND (DAC.' . $DepartmentGroup . 'DeficiencyID = DL.' . $DepartmentGroup . 'DeficiencyID)
																		AND DL.isActive = 1)
						WHERE DAC.DepartmentID = ' . $DepartmentID . '
							AND DAC.isActive = 1
						ORDER BY DL.' . $DepartmentGroup . 'DeficiencyName;';

    if (!($sqlDeficiencyListResults = $db->query($sqlDeficiencyList))) {
        echo '<select name="deficiencyList" id="deficiencyList" multiple="multiple" size="11" style="width: 500px;">';
        echo '<option value="" selected="selected">*** ERROR (DB) ***</option>';
        echo '</select>';
    } else {
        // check if row is returned, if yes error, if no get values
        if ($db->numRows($sqlDeficiencyListResults) == 0) {
            echo '<select name="deficiencyList" id="deficiencyList" multiple="multiple" size="11" style="width: 500px;">';
            echo '<option value="" selected="selected">No Deficiencies Exist</option>';
            echo '</select>';
        } else {
            echo '<select name="deficiencyList" id="deficiencyList" multiple="multiple" size="11" style="width: 500px;">';
            while ($rowDeficiencyList = mysql_fetch_array($sqlDeficiencyListResults)) {
                echo '<option value="' . $rowDeficiencyList["DeficiencyID"] . '-' . $DepartmentGroup . '">' . $rowDeficiencyList["DeficiencyName"] . '</option>';
            }

            echo '</select>';
        }
    }

//	mysql_close($db);
}
?>