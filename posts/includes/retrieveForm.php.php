<?php
echo $departmentID = strip_tags($_GET["d"]);

/*
// check if the subtype request came from the search screen or the create event screen
// then: create event screen
// else: search screen
$selectBoxParams = (empty($searchParam)) ? 'style="width: 181px;"' : '"multiple" size="5" style="width: 225px;"';
$requiredIndicator = (empty($searchParam)) ? '<span id="warningSymbol">&nbsp;&nbsp;&nbsp;*</span>' : '';
$showSelectOption = (empty($searchParam)) ? '<option value="" selected="selected">Select...</option>' : '';

if (empty($eventTypeID))
{
	echo '<select '.$selectBoxParams.' name="eventSubType" id="eventSubType">';
	echo '<option value="" selected="selected">Select...</option>';
	echo '</select><span id="warningSymbol">&nbsp;&nbsp;&nbsp;*</span>';
} else
{
	// specify DB name
	$dbName= "PlantEventLog" ;
	
	// include DB connection settings
	require_once "config.php";
	require_once "class.mysql.php";
	$db = new mysql();

	$sqlEventSubType = 'SELECT EventSubTypeID AS EventSubTypeID
							, EventSubTypeName AS EventSubTypeName
					FROM EventSubType
					WHERE EventTypeID = "'.$eventTypeID.'"
					AND isActive = 1
					ORDER BY EventSubTypeName';
	
	if (!($sqlEventTypeResults = $db->query($sqlEventSubType)))
	{
		echo '<select '.$selectBoxParams.' name="eventSubType" id="eventSubType">';
		echo '<option value="" selected="selected">*** ERROR (DB) ***</option>';
		echo '</select>'.$requiredIndicator;
	} else
	{
		// check if row is returned, if yes error, if no get values
		if ($db->numRows($sqlEventTypeResults) == 0) 
		{
			echo '<select '.$selectBoxParams.' name="eventSubType" id="eventSubType">';
			echo '<option value="" selected="selected">No Subtypes Exist</option>';
			echo '</select>'.$requiredIndicator;
		} else 
		{
			echo '<select '.$selectBoxParams.' name="eventSubType" id="eventSubType">';
			echo $showSelectOption;

			while( $rowEventType = mysql_fetch_array($sqlEventTypeResults) )
			{
				echo '<option value="'.$rowEventType["EventSubTypeID"].'">'.$rowEventType["EventSubTypeName"].'</option>';						
			}
	
			echo '</select>'.$requiredIndicator;
		}
	}

	mysql_close($db);
}*/
?>