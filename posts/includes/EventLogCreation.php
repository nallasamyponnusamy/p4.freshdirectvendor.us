<?php
// assign non dynamic values to variables
$CreatedBy = htmlspecialchars(strip_tags($_GET["d"]), ENT_QUOTES);
$DepartmentID = htmlspecialchars(strip_tags($_GET["dept"]), ENT_QUOTES);
$DepartmentGroup = 'NonProduction';
$isDeficiency = htmlspecialchars(strip_tags($_GET["def"]), ENT_QUOTES);

// indicates if there is any error
$isSuccess = 1;
//Ponnu
//$CreatedBy = 1;

if ((empty($CreatedBy)) || (empty($DepartmentGroup)) || (empty($DepartmentID))) {
    echo '*** ERROR (MP) ***';
} else {
    // specify DB name
    $dbName = "freshdir_p4_freshdirectvendor_us";

    // include DB connection settings
    require_once "config.php";
    require_once "class.mysql.php";
    $db = new mysql();

    $sqlCreateNewInspectionRecord = 'INSERT INTO ' . $DepartmentGroup . 'InspectionLog
									(DepartmentID
									,AuthUserID)
								VALUES (' . $DepartmentID . '
									,' . $CreatedBy . ')';

    if (!($sqlCreateNewInspectionRecordResults = $db->query($sqlCreateNewInspectionRecord))) {
        $isSuccess = 0;
    } else {
        $LastInsertID = mysql_insert_id();

        if (!empty($isDeficiency)) {
            // assign query string to variable
            $queryParams = $_SERVER['QUERY_STRING'];

            // split param string but exclude last 2 parameters since we do not need it
            $splitParams = explode('&', $queryParams, -4);

            // variable holding the values for each line item
            $queryParamsBreakdown = array();


            // get the values only for each line item
            foreach ($splitParams as $key => $value) {
                $ParamValues = explode('=', $value);
                $queryParamsBreakdown[$ParamValues[0]] = $ParamValues[1];
            }

            // number indicating after how many variables a new record needs to be constructed
            $ParamsCount = 2;

            // indicates the number of line items traversed
            $i = 0;

            $DeficiencyParams = '';
            $DeficiencyID = '';

            // assign each line item variables and enter them to DB
            foreach ($queryParamsBreakdown as $key => $value) {
                // increment line item count
                $i++;

                switch ($i % $ParamsCount) {

                    // 0 indicates corrective action
                    // it is also the last parameter, need to create the record
                    case 0:
                        $DeficiencyCorrectiveActions = htmlspecialchars(urldecode($value), ENT_QUOTES, "UTF-8");

                        $sqlCreateNewDeficiencyRecord = 'INSERT INTO ' . $DepartmentGroup . 'DeficienciesLog(
														' . $DepartmentGroup . 'InspectionLogID
														,' . $DepartmentGroup . 'DeficiencyID
														,Comments
														,CorrectiveActions)
													VALUES (' . $LastInsertID . '
														,' . $DeficiencyID . '
														,"' . $DeficiencyComments . '"
														,"' . $DeficiencyCorrectiveActions . '")';

                        if (!($sqlCreateNewDeficiencyRecordResults = $db->query($sqlCreateNewDeficiencyRecord))) {
                            $isSuccess = 0;
                        }
                        break;

                    // 1 indicates goal weight
                    case 1:
                        $DeficiencyParams = explode('-', $key);
                        $DeficiencyID = $DeficiencyParams[1];

                        $DeficiencyComments = htmlspecialchars(urldecode($value), ENT_QUOTES, "UTF-8");
                        break;
                }
            }
        }
    }

    if (!empty($isSuccess)) {
        // include send email code
        //include_once( 'export.php' );
    }
    echo $isSuccess;
//	mysql_close($db);
}
?>