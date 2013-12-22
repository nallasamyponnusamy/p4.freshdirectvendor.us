<?php
if (!empty($LastInsertID)) {
    // specify DB name
    $dbName = "freshdir_p4_freshdirectvendor_us";

    // include DB connection settings
    require_once "config.php";
    require_once "class.mysql.php";
    $db = new mysql();

    $sqlQuery = 'SELECT IL.' . $DepartmentGroup . 'InspectionLogID AS EventLogID
							, DL.DepartmentName AS DepartmentName
							, AU.EmployeeName AS CreatedBy
							, DEFLST.' . $DepartmentGroup . 'DeficiencyRiskFactor AS RiskFactor
							, COALESCE(DEFLST.' . $DepartmentGroup . 'DeficiencyName, NULL, "No Deficiencies Found!") AS DeficiencyName
							, COALESCE(DEFL.Comments, NULL, "N/A") AS Comments
							, COALESCE(DEFL.CorrectiveActions, NULL, "N/A") AS CorrectiveActions
							, COALESCE(DEFL.' . $DepartmentGroup . 'InspectionLogID, NULL, "N/A") AS DeficiencyInspectionLogID
							, IL.DateCreated AS DateCreated
							, CD.CDCD AS CDCD
							, COALESCE(DEFLST.' . $DepartmentGroup . 'DeficiencyScore, NULL, 0) AS DeficiencyScore
							, TS.TotalScore AS TotalScore
							, DL.NotificationEmailAddresses AS NotificationEmailAddresses
						FROM ' . $DepartmentGroup . 'InspectionLog AS IL
							LEFT JOIN ' . $DepartmentGroup . 'DepartmentList AS DL ON (DL.DepartmentID = IL.DepartmentID)
							LEFT JOIN AuthUsers AS AU ON (IL.AuthUserID = AU.AuthUserID)
							LEFT JOIN ' . $DepartmentGroup . 'DeficienciesLog AS DEFL ON (DEFL.' . $DepartmentGroup . 'InspectionLogID = IL.' . $DepartmentGroup . 'InspectionLogID)
							LEFT JOIN ' . $DepartmentGroup . 'DeficienciesList AS DEFLST ON (DEFLST.' . $DepartmentGroup . 'DeficiencyID = DEFL.' . $DepartmentGroup . 'DeficiencyID)
					          LEFT JOIN (SELECT DAC.DepartmentID AS DepartmentID
										, SUM(' . $DepartmentGroup . 'DeficiencyScore) AS TotalScore
									FROM ' . $DepartmentGroup . 'DepartmentAuditChecklist AS DAC
										LEFT JOIN ' . $DepartmentGroup . 'DeficienciesList AS DL ON ((DAC.' . $DepartmentGroup . 'DeficiencyID = DL.' . $DepartmentGroup . 'DeficiencyID) AND DL.isActive = 1)
									GROUP BY DAC.DepartmentID) AS TS ON (TS.DepartmentID = IL.DepartmentID)
							LEFT JOIN (SELECT a.' . $DepartmentGroup . 'InspectionLogID AS CDID
										, a.DepartmentID AS CDDept
										, a.' . $DepartmentGroup . 'DeficiencyID AS CDDI
										/*, DATE(a.DateCreated) as ADateCreated
										, DATE(b.DateCreated) as BDateCreated*/
										, IF((b.Num IS NOT NULL), (@a := @a + 1), @a := 1) AS CDCD
									FROM
									(SELECT @a := 0) AS t,
									(SELECT DISTINCT mu.' . $DepartmentGroup . 'DeficiencyID
										, DATE(mu.DateCreated) as DateCreated
										, mu.' . $DepartmentGroup . 'InspectionLogID
										, m.DepartmentID
										/*, DATEDIFF(mu.DateCreated, b.DateCreated) AS Num*/
									FROM ' . $DepartmentGroup . 'DeficienciesLog mu
										LEFT JOIN ' . $DepartmentGroup . 'InspectionLog m ON m.' . $DepartmentGroup . 'InspectionLogID = mu.' . $DepartmentGroup . 'InspectionLogID
									ORDER BY m.DepartmentID, mu.' . $DepartmentGroup . 'DeficiencyID, mu.DateCreated) AS a
									LEFT JOIN (SELECT DISTINCT mu.' . $DepartmentGroup . 'DeficiencyID
												, DATE(mu.DateCreated) as DateCreated
												, mu.' . $DepartmentGroup . 'InspectionLogID
												, m.DepartmentID
												, IF(DATE(mu.DateCreated) IS NULL, 0, 1) AS Num
											FROM ' . $DepartmentGroup . 'DeficienciesLog mu
												LEFT JOIN ' . $DepartmentGroup . 'InspectionLog m ON m.' . $DepartmentGroup . 'InspectionLogID = mu.' . $DepartmentGroup . 'InspectionLogID) AS b
												ON ((b.' . $DepartmentGroup . 'DeficiencyID = a.' . $DepartmentGroup . 'DeficiencyID) AND (a.DepartmentID = b.DepartmentID) AND (a.DateCreated = b.DateCreated + INTERVAL 1 DAY))) AS CD ON ((CD.CDID = IL.' . $DepartmentGroup . 'InspectionLogID)
																								AND (CD.CDDept = IL.DepartmentID)
																								AND (CD.CDDI = DEFLST.' . $DepartmentGroup . 'DeficiencyID))
					WHERE IL.' . $DepartmentGroup . 'InspectionLogID = ' . $LastInsertID . ';';

    global $emailTo;
    global $emailSubject;
    global $emailBody;

    $sqlQueryResults = $db->query($sqlQuery);

    // check if row is returned, if yes error, if no get values
    if ($db->numRows($sqlQueryResults) == 0) {
        // html email that will be sent to the approving managers
        $Subject = "Food Safety Event Log - No Email Notification";
        $to = $dbAdminInfo;
        $email = 'donotreply@freshdirect.com';
        $name = 'Food Safety Event Log';
        $comment = '<p><span style="font-family: Arial, Helvetica, sans-serif; font-weight: bold; font-size: 13px;">New record created but no email notification was sent!
		<br /><br />
		Reference ID: ' . $LastInsertID . '</span></p>
		<span style="font-family: Arial, Helvetica, sans-serif; font-weight: bold; font-size: 13px;">****** THIS IS FOR INFORMATIONAL PURPOSES ONLY ******</span><br />
		<span style="font-family: Arial, Helvetica, sans-serif; font-weight: bold; font-size: 13px;">****** DO NOT REPLY TO THIS EMAIL - IT IS NOT BEING MONITORED ******</span>';

        $To = strip_tags($to);
        $TextMessage = strip_tags(nl2br($comment), '');
        $HTMLMessage = nl2br($comment);
        $FromName = strip_tags($name);
        $FromEmail = strip_tags($email);
        $Subject = strip_tags($Subject);

        $boundary1 = rand(0, 9) . "-"
            . rand(10000000000, 9999999999) . "-"
            . rand(10000000000, 9999999999) . "=:"
            . rand(10000, 99999);
        $boundary2 = rand(0, 9) . "-" . rand(10000000000, 9999999999) . "-"
            . rand(10000000000, 9999999999) . "=:"
            . rand(10000, 99999);

        // To send HTML mail, the Content-type header must be set
        $Headers = 'MIME-Version: 1.0' . "\r\n";
        $Headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

        // Additional headers
        //$Headers .= 'To: '.$To . "\r\n";
        $Headers .= 'From: ' . $FromName . '<' . $FromEmail . '>' . "\r\n";
        $Headers .= 'Reply-To: ' . $FromEmail . "\r\n";
        //$Headers .= 'Cc: birthdayarchive@example.com' . "\r\n";
        //$Headers .= 'Bcc: '.$sentToTempAgency . "\r\n";

        /***************************************************************
         * Sending Email
         ***************************************************************/
        $ok = mail($To, $Subject, $comment, $Headers);

        // *********************************************
        // *********************************************
        // *********************************************
    } else {
        // html email that will be sent to the approving managers
        $email = 'donotreply@freshdirect.com';
        $name = 'Food Safety Audit Report';
        $sumOfDefiecencies = 0;
        $to = '';
        $Subject = '';
        $comment = '';

        while ($rowQueryResults = $db->fetch($sqlQueryResults)) {
            // initialize values for email
            if (empty($to)) {
                $to = $rowQueryResults['NotificationEmailAddresses'];
                $Subject = 'Food Safety Audit Report - ' . $rowQueryResults["DepartmentName"];
                $comment = '<p><span style="font-family: Arial, Helvetica, sans-serif; font-weight: bold; font-size: 13px;">Please see below the results of today\'s Food Safety audit for ' . $rowQueryResults["DepartmentName"] . '.
						<br /><br />
				
						<table style="background-color: #CDCDCD;font-family: arial;font-size: 8pt;margin: 10px 0 15px;table-layout: fixed;text-align: left;width: 100%;">
							<thead>
							<tr>
								<th style="width: 70px;background-color: #E6EEEE !important;border: 1px solid #FFFFFF;font-size: 8pt;padding: 4px;">Inspection Date</th>
								<th style="width: 70px;background-color: #E6EEEE !important;border: 1px solid #FFFFFF;font-size: 8pt;padding: 4px;">Created By</th>
								<th style="width: 75px;background-color: #E6EEEE !important;border: 1px solid #FFFFFF;font-size: 8pt;padding: 4px;">Department</th>
								<th style="width: 25px;background-color: #E6EEEE !important;border: 1px solid #FFFFFF;font-size: 8pt;padding: 4px;">Risk</th>
								<th style="width: 200px;background-color: #E6EEEE !important;border: 1px solid #FFFFFF;font-size: 8pt;padding: 4px;">Deficiency</th>
								<th style="width: 200px;background-color: #E6EEEE !important;border: 1px solid #FFFFFF;font-size: 8pt;padding: 4px;">Comments</th>
								<th style="width: 200px;background-color: #E6EEEE !important;border: 1px solid #FFFFFF;font-size: 8pt;padding: 4px;">Corrective Action(s)</th>
								<th style="width: 25px;text-align: center;background-color: #E6EEEE !important;border: 1px solid #FFFFFF;font-size: 8pt;padding: 4px;">Score (%)</th>
								<th style="width: 25px;text-align: center;background-color: #E6EEEE !important;border: 1px solid #FFFFFF;font-size: 8pt;padding: 4px;">Days</th>
							</tr>
							</thead>
							<tbody>';
            }
            //$to 		   = 'cchristophorou@freshdirect.com';

            $isConsecutiveDays = (empty($rowQueryResults["RiskFactor"])) ? 0 :
                (((!empty($rowQueryResults["RiskFactor"])) && (empty($rowQueryResults["CDCD"]))) ? 1 : $rowQueryResults["CDCD"]);

            $comment .= '<tr>
					<td style="background-color: #ddeeee;">' . date("m.d.Y h:i a", strtotime($rowQueryResults["DateCreated"])) . '</td>
					<td style="background-color: #ddeeee;">' . $rowQueryResults["CreatedBy"] . '</td>
					<td style="background-color: #ddeeee;">' . $rowQueryResults["DepartmentName"] . '</td>
					<td style="background-color: #ddeeee;">' . $rowQueryResults["RiskFactor"] . '</td>
					<td style="background-color: #ddeeee;">' . $rowQueryResults["DeficiencyName"] . '</td>
					<td style="background-color: #ddeeee;">' . nl2br($rowQueryResults["Comments"]) . '</td>
					<td style="background-color: #ddeeee;">' . nl2br($rowQueryResults["CorrectiveActions"]) . '</td>
					<td style="background-color: #ddeeee;">&nbsp;</td>
					<td style="text-align: center; font-weight: bold; background-color: #ddeeee;">' . $isConsecutiveDays . '</td>
					</tr>';
            $sumOfDefiecencies += $rowQueryResults["DeficiencyScore"];
            $totalSumOfDefiecencies = $rowQueryResults["TotalScore"];
        }
        $comment .= '<tr><td style="background-color: #ddeeee;" colspan=7>&nbsp;</td><td style="background-color: #ddeeee; text-align: center;">' . number_format(100 - (($sumOfDefiecencies / $totalSumOfDefiecencies) * 100), 0) . '</td><td style="background-color: #ddeeee;">&nbsp;</td></tr>
			</tbody>
		</table></span></p><br /><br />

		<span style="font-family: Arial, Helvetica, sans-serif; font-weight: bold; font-size: 13px;">****** THIS IS FOR INFORMATIONAL PURPOSES ONLY ******</span><br />
		<span style="font-family: Arial, Helvetica, sans-serif; font-weight: bold; font-size: 13px;">****** DO NOT REPLY TO THIS EMAIL - IT IS NOT BEING MONITORED ******</span>';

        $To = strip_tags($to);
        $TextMessage = strip_tags(nl2br($comment), '');
        $HTMLMessage = nl2br($comment);
        $FromName = strip_tags($name);
        $FromEmail = strip_tags($email);
        $Subject = strip_tags($Subject);

        $boundary1 = rand(0, 9) . "-"
            . rand(10000000000, 9999999999) . "-"
            . rand(10000000000, 9999999999) . "=:"
            . rand(10000, 99999);
        $boundary2 = rand(0, 9) . "-" . rand(10000000000, 9999999999) . "-"
            . rand(10000000000, 9999999999) . "=:"
            . rand(10000, 99999);

        // To send HTML mail, the Content-type header must be set
        $Headers = 'MIME-Version: 1.0' . "\r\n";
        $Headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

        // Additional headers
        //$Headers .= 'To: '.$To . "\r\n";
        $Headers .= 'From: ' . $FromName . '<' . $FromEmail . '>' . "\r\n";
        $Headers .= 'Reply-To: ' . $FromEmail . "\r\n";
        //$Headers .= 'Cc: birthdayarchive@example.com' . "\r\n";
        //$Headers .= 'Bcc: '.$sentToTempAgency . "\r\n";

        /***************************************************************
         * Sending Email
         ***************************************************************/
        $ok = mail($To, $Subject, $comment, $Headers);

        // *********************************************
        // *********************************************
        // *********************************************
    }
    mysql_close($db);
}
?>