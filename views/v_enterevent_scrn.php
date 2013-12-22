<?php
$DepartmentString = strip_tags($_GET["d"]);

// split string to the department ID and group (production/non production)
$DepartmentStringArray = explode("-", $DepartmentString);
$DepartmentID = $DepartmentStringArray[0];
$DepartmentGroup = $DepartmentStringArray[1];
// *********************************************

if ((empty($DepartmentID)) || (empty($DepartmentGroup))) {
    echo '<div class="notice"><h3>*** ERROR (EP) ***<br /><br />Please contact your <a href="mailto:' . $dbAdminInfo . '" class="errorEmailLink">database administrator</a> if you believe this is an error.</h3></div>';
} else {

    if (!($sqlDisplayDepartmentDeficienciesResults = $db->query($sqlDisplayDepartmentDeficiencies))) {
        echo '<div class="notice"><h3>*** ERROR (EP) ***<br /><br />Error reported, we apologize for any inconvinience.</h3></div>';
    } else {
// check if row is returned, if yes error, if no get values
        if ($db->numRows($sqlDisplayDepartmentDeficienciesResults) == 0) {
            echo '<div class="notice"><h3>No deficiencies assigned to this department yet.<br /><br />Please contact your <a href="mailto:' . $dbAdminInfo . '" class="errorEmailLink">database administrator</a> if you believe this is an error.</h3></div>';
        } else {
            echo '<input type="hidden" name="departmentID" id="departmentID" value="' . $DepartmentID . '" />';
            echo '<input type="hidden" name="departmentGroup" id="departmentGroup" value="' . $DepartmentGroup . '" />';

            echo '<table class="tablesorter">';
            echo '<thead>';
            echo '<tr>';
            echo '<th style="width: 70px;">Risk Factor</th>';
            echo '<th style="width: 350px;">Deficiency</th>';
            echo '<th style="width: 40px;">Found?</th>';
            echo '<th style="width: 210px;">Comments</th>';
            echo '<th style="width: 210px;">Corrective Actions</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';

            // holds the value of the GMP category for the line items
            $GMPCategoryName = '';

            while ($rowDisplayDepartmentDeficiencies = mysql_fetch_array($sqlDisplayDepartmentDeficienciesResults)) {
                if ((empty($GMPCategoryName)) || ($rowDisplayDepartmentDeficiencies['GMPCategoryName'] <> $GMPCategoryName)) {
                    $GMPCategoryName = $rowDisplayDepartmentDeficiencies['GMPCategoryName'];

                    echo '<tr><td style="background-color: #4e7373 !important; color: #fff !important; font-weight: bold;" colspan=5>' . $GMPCategoryName . '</td></tr>';

                    echo '<tr>
        <td>' . $rowDisplayDepartmentDeficiencies['DeficiencyRiskFactor'] . '</td>
        <td>' . $rowDisplayDepartmentDeficiencies['DeficiencyName'] . '</td>
        <td><input type="checkbox" name="isDeficiencyFound-' . $rowDisplayDepartmentDeficiencies['DeficiencyID'] . '" class="isDeficiencyFound" value="DeficiencyFound-' . $rowDisplayDepartmentDeficiencies['DeficiencyID'] . '" /></td>
        <td><textarea name="deficiencyComments-' . $rowDisplayDepartmentDeficiencies['DeficiencyID'] . '" id="deficiencyComments-' . $rowDisplayDepartmentDeficiencies['DeficiencyID'] . '" disabled></textarea></td>
        <td><textarea name="correctiveActions-' . $rowDisplayDepartmentDeficiencies['DeficiencyID'] . '" id="correctiveActions-' . $rowDisplayDepartmentDeficiencies['DeficiencyID'] . '" disabled></textarea></td>
    </tr>';
                } else {
                    echo '<tr>
        <td>' . $rowDisplayDepartmentDeficiencies['DeficiencyRiskFactor'] . '</td>
        <td>' . $rowDisplayDepartmentDeficiencies['DeficiencyName'] . '</td>
        <td><input type="checkbox" name="isDeficiencyFound-' . $rowDisplayDepartmentDeficiencies['DeficiencyID'] . '" class="isDeficiencyFound" value="DeficiencyFound-' . $rowDisplayDepartmentDeficiencies['DeficiencyID'] . '" /></td>
        <td><textarea name="deficiencyComments-' . $rowDisplayDepartmentDeficiencies['DeficiencyID'] . '" id="deficiencyComments-' . $rowDisplayDepartmentDeficiencies['DeficiencyID'] . '" disabled></textarea></td>
        <td><textarea name="correctiveActions-' . $rowDisplayDepartmentDeficiencies['DeficiencyID'] . '" id="correctiveActions-' . $rowDisplayDepartmentDeficiencies['DeficiencyID'] . '" disabled></textarea></td>
    </tr>';
                }
            }
            echo '</tbody>';
            echo '</table>';
        }
    }

//	mysql_close($db);
}
?>