<?php
class posts_controller extends base_controller
{
    public function __construct()
    {
        parent::__construct();

        # Make sure user is logged in if they want to use anything in this controller
        if (!$this->user) {
            die("Members only. <a href='/users/login'>Login</a>");
        }

    }


    public function overview()
    {

        #public function index() {

        # Set up the View
        $this->template->content = View::instance('v_deficiency_overview');
        $this->template->title = "All Posts";

//        # Query
//        $q = '(SELECT "Non Production" AS isProduction
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
//
//        # Run the query, store the results in the variable $posts
//        $sqlDepartmentList = DB::instance(DB_NAME)->select_rows($q);
//
//        # Pass data to the View
//        $this->template->content->$$sqlDepartmentList = $sqlDepartmentList;

        # Render the View
        echo $this->template;

    }


    public function add()
    {

        # Setup view
        $this->template->content = View::instance('v_CreateEventlog');
        $this->template->title = "Enter Events After Inspection";

        $q = '(SELECT "Non Production" AS isProduction
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

        # Run the query, store the results in the variable $posts
        $posts = DB::instance(DB_NAME)->select_rows($q);
        # Pass data to the View
        $this->template->content->posts = $posts;
        # Render template
        echo $this->template;

    }


    public function p_add()
    {

        # Associate this post with this user
        $_POST['user_id'] = $this->user->user_id;

        # Unix timestamp of when this post was created / modified
        $_POST['created'] = Time::now();
        $_POST['modified'] = Time::now();

        # Insert
        # Note we didn't have to sanitize any of the $_POST data because we're using the insert method which does it for us
        DB::instance(DB_NAME)->insert('posts', $_POST);

        # Quick and dirty feedback
        //echo "Your post has been added. <a href='/posts/add'>Add another</a>";
        # Send them back
        Router::redirect("/posts/index");
    }


    public function p_addevent()
    {

        $DepartmentString = strip_tags($_GET["d"]);

// split string to the department ID and group (production/non production)
        $DepartmentStringArray = explode("-", $DepartmentString);
        $DepartmentID = $DepartmentStringArray[0];
        $DepartmentGroup = $DepartmentStringArray[1];
// *********************************************

//if ((empty($DepartmentID)) || (empty($DepartmentGroup)))
//{
//    echo '<div class="notice"><h3>*** ERROR (EP) ***<br /><br />Please contact your <a href="mailto:'.$dbAdminInfo.'" class="errorEmailLink">database administrator</a> if you believe this is an error.</h3></div>';
//} else
//{
// specify DB name
//    $dbName= "freshdir_p4_freshdirectvendor_us" ;
//
//    // include DB connection settings
//    require_once "config.php";
//    require_once "class.mysql.php";
//    $db = new mysql();

# Setup view


//        $this->template->content = View::instance('v_enterevent_scrn');
//        $this->template->title = "New Post";

        $q = 'SELECT DL.' . $DepartmentGroup . 'DeficiencyID AS DeficiencyID
											, DL.' . $DepartmentGroup . 'DeficiencyName AS DeficiencyName
											, DL.' . $DepartmentGroup . 'DeficiencyRiskFactor AS DeficiencyRiskFactor
											, DL.' . $DepartmentGroup . 'DeficiencyScore AS DeficiencyScore
											, DPTN.DepartmentID AS DepartmentID
											, DPTN.DepartmentName AS DepartmentName
											, GMPC.GMPCategoryName AS GMPCategoryName
								FROM ' . $DepartmentGroup . 'DepartmentAuditChecklist AS DAC
									LEFT JOIN ' . $DepartmentGroup . 'DeficienciesList AS DL ON ((DAC.DepartmentID = ' . $DepartmentID . ')
																					AND (DAC.' . $DepartmentGroup . 'DeficiencyID = DL.' . $DepartmentGroup . 'DeficiencyID)
																					AND DL.isActive = 1)
									LEFT JOIN ' . $DepartmentGroup . 'DepartmentList AS DPTN ON (DPTN.DepartmentID = DAC.DepartmentID)
									LEFT JOIN GMPCategories AS GMPC ON (GMPC.GMPCategoryID = DL.GMPCategoryID)
								WHERE DAC.DepartmentID = ' . $DepartmentID . '
									AND DAC.isActive = 1
								ORDER BY DL.GMPCategoryID, ' . $DepartmentGroup . 'DeficiencyRiskFactor';


# Run the query, store the results in the variable $posts
        $posts = DB::instance(DB_NAME)->select_rows($q);
# Pass data to the View
//        if (!($sqlDisplayDepartmentDeficienciesResults = $db->query($sqlDisplayDepartmentDeficiencies)))
//        {
//            echo '<div class="notice"><h3>*** ERROR (EP) ***<br /><br />Error reported, we apologize for any inconvinience.</h3></div>';
//        } else
//        {
//            // check if row is returned, if yes error, if no get values
//            if ($db->numRows($sqlDisplayDepartmentDeficienciesResults) == 0)
//            {
//                echo '<div class="notice"><h3>No deficiencies assigned to this department yet.<br /><br />Please contact your <a href="mailto:'.$dbAdminInfo.'" class="errorEmailLink">database administrator</a> if you believe this is an error.</h3></div>';
//            } else
//            {

        echo '<input type="hidden" name="departmentID" id="departmentID" value="' . $DepartmentID . '" />';
        echo '<input type="hidden" name="departmentGroup" id="departmentGroup" value="' . $DepartmentGroup . '" />';

        echo '<table class="tablesorter">';
        echo '<thead>';
        echo '<tr>';
        echo '<th style="width: 70px;">Risk Factor</th>';
        echo '<th style="width: 350px;">Deficiency</th>';
        echo '<th style="width: 40px;">Found?</th>';
        echo '<th style="width: 220px;">Comments</th>';
        echo '<th style="width: 220px;">Corrective Actions</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

// holds the value of the GMP category for the line items
        $GMPCategoryName = '';
        foreach ($posts as $rowDisplayDepartmentDeficiencies):
//                while( $rowDisplayDepartmentDeficiencies = mysql_fetch_array($sqlDisplayDepartmentDeficienciesResults) )

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
        endforeach;
        echo '</tbody>';
        echo '</table>';

    }


    #Functoin to Add entered data to database
    public function p_addevent_to_db()
    {

// assign non dynamic values to variables
//        $CreatedBy = htmlspecialchars(strip_tags($_GET["d"]), ENT_QUOTES);
//        $CreatedBy = $this->user->user_id;
        $CreatedBy = $this->user->AuthUserID;
        $DepartmentID = htmlspecialchars(strip_tags($_GET["dept"]), ENT_QUOTES);
        $DepartmentGroup = 'NonProduction';
        $isDeficiency = htmlspecialchars(strip_tags($_GET["def"]), ENT_QUOTES);

// indicates if there is any error
        $isSuccess = 1;
//Ponnu
//        $CreatedBy = 1;

        if ((empty($CreatedBy)) || (empty($DepartmentGroup)) || (empty($DepartmentID))) {
            echo '*** ERROR (MP) ***';
        } else {


            $data = Array(
                "DepartmentID" => $DepartmentID,
                "AuthUserID" => $this->user->AuthUserID,
            );

//
//    $data =  'INSERT INTO '.$DepartmentGroup.'InspectionLog
//									(DepartmentID
//									,AuthUserID)
//								VALUES ('.$DepartmentID.'
//									,3)';
            # Do the insert
            DB::instance(DB_NAME)->insert($DepartmentGroup . 'InspectionLog', $data);
            $LastInsertID = DB::instance(DB_NAME)->select_field("SELECT max(NonProductionInspectionLogID) FROM nonproductioninspectionlog");
//    if (!($sqlCreateNewInspectionRecordResults = $db->query($sqlCreateNewInspectionRecord)))
            if (!$data) {
                $isSuccess = 0;
            } else {
//                $LastInsertID = mysql_insert_id();

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


                    $DeficiencyID = '';
                    $DeficiencyParams = '';
                    // assign each line item variables and enter them to DB
                    foreach ($queryParamsBreakdown as $key => $value) {
                        // increment line item count
                        $i++;

                        switch ($i % $ParamsCount) {

                            // 0 indicates corrective action
                            // it is also the last parameter, need to create the record
                            case 0:
                                $DeficiencyCorrectiveActions = htmlspecialchars(urldecode($value), ENT_QUOTES, "UTF-8");

                                $data = Array(
                                    "NonProductionInspectionLogID" => $LastInsertID,
                                    "NonProductionDeficiencyID" => $DeficiencyID,
                                    "Comments" => $DeficiencyComments,
                                    "CorrectiveActions" => $DeficiencyCorrectiveActions,
                                );

                                # Do the insert
                                DB::instance(DB_NAME)->insert($DepartmentGroup . 'deficiencieslog', $data);

//                        if (!($sqlCreateNewDeficiencyRecordResults = $db->query($sqlCreateNewDeficiencyRecord)))
//                        {
                                $isSuccess = 0;
//                        }
//                        break;

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

            }
            echo $isSuccess;


        }


    }


    # Deficiency Overview List
    public function index()
    {

        # Set up the View
        $this->template->content = View::instance('v_deficiency_overview');
        $this->template->title = "Deficiency Overview List";



    }





    #Public function with deficiency_view
    public function deficiency_view()
    {


        $SelectionValue = strip_tags($_GET["str"]);
        $AuthUserID = strip_tags($_GET["d"]);

        if ((empty($AuthUserID)) || (empty($SelectionValue))) {
            echo '<div class="notice"><h3>*** ERROR (MP) ***</h3></div>';
        } else {
            #Non Production Department
            switch ($SelectionValue) {
                case 'Non Production':
                    $q = 'SELECT NPIL.NonProductionInspectionLogID AS EventLogID
                    , NPDL.DepartmentName AS DepartmentName
                    , AU.first_name AS CreatedBy
                    , NPDEFLST.NonProductionDeficiencyRiskFactor AS RiskFactor
                    , COALESCE(NPDEFLST.NonProductionDeficiencyName, NULL, "No Deficiencies Found!") AS DeficiencyName
                    , COALESCE(NPDEFL.Comments, NULL, "N/A") AS Comments
                    , COALESCE(NPDEFL.CorrectiveActions, NULL, "N/A") AS CorrectiveActions
                    , COALESCE(NPDEFL.NonProductionInspectionLogID, NULL, "N/A") AS DeficiencyInspectionLogID
                    , NPIL.DateCreated AS DateCreated
                    , CD.CDCD AS CDCD
                    , COALESCE(NPDEFLST.NonProductionDeficiencyScore, NULL, 0) AS DeficiencyScore
                    , TS.TotalScore AS TotalScore
                    FROM NonProductionInspectionLog AS NPIL
                    LEFT JOIN NonProductionDepartmentList AS NPDL ON (NPDL.DepartmentID = NPIL.DepartmentID)
                    LEFT JOIN users AS AU ON (NPIL.AuthUserID = AU.AuthUserID)
                    LEFT JOIN NonProductionDeficienciesLog AS NPDEFL ON (NPDEFL.NonProductionInspectionLogID = NPIL.NonProductionInspectionLogID)
                    LEFT JOIN NonProductionDeficienciesList AS NPDEFLST ON (NPDEFLST.NonProductionDeficiencyID = NPDEFL.NonProductionDeficiencyID)
                    LEFT JOIN (SELECT DAC.DepartmentID AS DepartmentID
                    , SUM(NonProductionDeficiencyScore) AS TotalScore
                    FROM NonProductionDepartmentAuditChecklist AS DAC
                    LEFT JOIN NonProductionDeficienciesList AS DL ON ((DAC.NonProductionDeficiencyID = DL.NonProductionDeficiencyID) AND DL.isActive = 1)
                    GROUP BY DAC.DepartmentID) AS TS ON (TS.DepartmentID = NPIL.DepartmentID)
                    LEFT JOIN (SELECT a.NonProductionInspectionLogID AS CDID
                    , a.DepartmentID AS CDDept
                    , a.NonProductionDeficiencyID AS CDDI
                    /*, DATE(a.DateCreated) as ADateCreated
                    , DATE(b.DateCreated) as BDateCreated*/
                    , IF((b.Num IS NOT NULL), (@a := @a + 1), @a := 1) AS CDCD
                    FROM
                    (SELECT @a := 0) AS t,
                    (SELECT DISTINCT mu.NonProductionDeficiencyID
                    , DATE(mu.DateCreated) as DateCreated
                    , mu.NonProductionInspectionLogID
                    , m.DepartmentID
                    /*, DATEDIFF(mu.DateCreated, b.DateCreated) AS Num*/
                    FROM NonProductionDeficienciesLog mu
                    LEFT JOIN NonProductionInspectionLog m ON m.NonProductionInspectionLogID = mu.NonProductionInspectionLogID
                    ORDER BY m.DepartmentID, mu.NonProductionDeficiencyID, mu.DateCreated) AS a
                    LEFT JOIN (SELECT DISTINCT mu.NonProductionDeficiencyID
                    , DATE(mu.DateCreated) as DateCreated
                    , mu.NonProductionInspectionLogID
                    , m.DepartmentID
                    , IF(DATE(mu.DateCreated) IS NULL, 0, 1) AS Num
                    FROM NonProductionDeficienciesLog mu
                    LEFT JOIN NonProductionInspectionLog m ON m.NonProductionInspectionLogID = mu.NonProductionInspectionLogID) AS b
                    ON ((b.NonProductionDeficiencyID = a.NonProductionDeficiencyID) AND (a.DepartmentID = b.DepartmentID) AND (a.DateCreated = b.DateCreated + INTERVAL 1 DAY))) AS CD ON ((CD.CDID = NPIL.NonProductionInspectionLogID)
                    AND (CD.CDDept = NPIL.DepartmentID)
                    AND (CD.CDDI = NPDEFLST.NonProductionDeficiencyID))
                    WHERE (NPIL.DateCreated > DATE_SUB(curdate(), INTERVAL 30 DAY))
                    ORDER BY NPIL.NonProductionInspectionLogID DESC, NPDEFL.NonProductionInspectionLogID;';


                    # Run the query, store the results in the variable $posts
                    $sqlDisplayEventLogResults = DB::instance(DB_NAME)->select_rows($q);
//                    {
//                        die('<div class="notice"><h3>Error: '. mysql_error().'<br /><br /><br />Please contact your <a href="mailto:'.$dbAdminInfo.'" class="errorEmailLink">database administrator</a> indicating the above error.</h3></div>');
//                    }
//                    $sqlDisplayEventLogResults = $posts;

                    ?>
                    <table class="tablesorter">
                        <thead>
                        <tr>
                            <th style="width: 70px;">Inspection Date</th>
                            <th style="width: 70px;">Created By</th>
                            <th style="width: 75px;">Department</th>
                            <th style="width: 25px;">Risk</th>
                            <th style="width: 200px;">Deficiency</th>
                            <th style="width: 200px;">Comments</th>
                            <th style="width: 200px;">Corrective Action(s)</th>
                            <th style="width: 25px; text-align: center;">%</th>
                            <th style="width: 25px; text-align: center;">Days</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $i = 0;
                        $CurrentID = '';
                        foreach ($sqlDisplayEventLogResults as $rowDisplayEventLog):
//                        while ($rowDisplayEventLog = mysql_fetch_array($sqlDisplayEventLogResults) )
                        {
                            $i++;

                        if ($rowDisplayEventLog['DeficiencyInspectionLogID'] <> $CurrentID) {
                        if (!empty($CurrentID)) {
                            ?>
                            <script type="text/javascript">
                                var html = '<?php echo number_format(100-(($sumOfDefiecencies/$totalSumOfDefiecencies)*100),0); ?>';
                                $("#evtID<?php echo $CurrentID; ?>").html(html);
                                $("#evtID<?php echo $CurrentID; ?>").css('font-weight', 'bold').css('text-align', 'center');
                            </script>
                        <?php
                        }

                        $CurrentID = $rowDisplayEventLog['EventLogID'];
                        $sumOfDefiecencies = 0;
                        $isAltClass = 'class="altTD"';
                        $isEvtID = 'id="evtID' . $CurrentID . '"';
                        $sumOfDefiecencies = $rowDisplayEventLog["DeficiencyScore"];
                        $totalSumOfDefiecencies = $rowDisplayEventLog["TotalScore"];
                        } else {
                            $isAltClass = 'class="normTD"';
                            $isEvtID = '';
                            $sumOfDefiecencies += $rowDisplayEventLog["DeficiencyScore"];
                        }

                        echo "<tr>";

                        $isConsecutiveDays = (empty($rowDisplayEventLog["RiskFactor"])) ? 0 :
                            (((!empty($rowDisplayEventLog["RiskFactor"])) && (empty($rowDisplayEventLog["CDCD"]))) ? 1 : $rowDisplayEventLog["CDCD"]);

                        echo '<td ' . $isAltClass . '>' . date("m.d.Y", strtotime($rowDisplayEventLog["DateCreated"])) . '</td>';
                        echo '<td ' . $isAltClass . '>' . $rowDisplayEventLog["CreatedBy"] . '</td>';
                        echo '<td ' . $isAltClass . '>' . $rowDisplayEventLog["DepartmentName"] . '</td>';
                        echo '<td ' . $isAltClass . '>' . $rowDisplayEventLog["RiskFactor"] . '</td>';
                        echo '<td ' . $isAltClass . '>' . $rowDisplayEventLog["DeficiencyName"] . '</td>';
                        echo '<td ' . $isAltClass . '>' . nl2br($rowDisplayEventLog["Comments"]) . '</td>';
                        echo '<td ' . $isAltClass . '>' . nl2br($rowDisplayEventLog["CorrectiveActions"]) . '</td>';
                        echo '<td ' . $isAltClass . ' ' . $isEvtID . '></td>';
                        echo '<td ' . $isAltClass . ' style="text-align: center; font-weight: bold;">' . $isConsecutiveDays . '</td>';

                        echo '</tr>';

                        //                    if ($i == $db->numRows($sqlDisplayEventLogResults))
                        if ($i == count($sqlDisplayEventLogResults))
                        {
                        ?>
                            <script type="text/javascript">
                                var html = '<?php echo number_format(100-(($sumOfDefiecencies/$totalSumOfDefiecencies)*100),0); ?>';
                                $("#evtID<?php echo $CurrentID; ?>").html(html);
                                $("#evtID<?php echo $CurrentID; ?>").css('font-weight', 'bold').css('text-align', 'center');
                            </script>
                        <?php
                        }
                        }
                        endforeach;

                        ?>
                        </tbody>
                    </table>
                    <?php
                    break;

                default:
                    $sqlDisplayEventLog = 'SELECT PIL.ProductionInspectionLogID AS EventLogID
								, PDL.DepartmentName AS DepartmentName
								, AU.EmployeeName AS CreatedBy
								, PDEFLST.ProductionDeficiencyRiskFactor AS RiskFactor
								, COALESCE(PDEFLST.ProductionDeficiencyName, NULL, "No Deficiencies Found!") AS DeficiencyName
								, COALESCE(PDEFL.Comments, NULL, "N/A") AS Comments
								, COALESCE(PDEFL.CorrectiveActions, NULL, "N/A") AS CorrectiveActions
								, COALESCE(PDEFL.ProductionInspectionLogID, NULL, "N/A") AS DeficiencyInspectionLogID
								, PIL.DateCreated AS DateCreated
								, CD.CDCD AS CDCD
								, COALESCE(PDEFLST.ProductionDeficiencyScore, NULL, 0) AS DeficiencyScore
								, TS.TotalScore AS TotalScore
							FROM ProductionInspectionLog AS PIL
								LEFT JOIN ProductionDepartmentList AS PDL ON (PDL.DepartmentID = PIL.DepartmentID)
								LEFT JOIN AuthUsers AS AU ON (PIL.AuthUserID = AU.AuthUserID)
								LEFT JOIN ProductionDeficienciesLog AS PDEFL ON (PDEFL.ProductionInspectionLogID = PIL.ProductionInspectionLogID)
								LEFT JOIN ProductionDeficienciesList AS PDEFLST ON (PDEFLST.ProductionDeficiencyID = PDEFL.ProductionDeficiencyID)
						          LEFT JOIN (SELECT DAC.DepartmentID AS DepartmentID
											, SUM(ProductionDeficiencyScore) AS TotalScore
										FROM ProductionDepartmentAuditChecklist AS DAC
											LEFT JOIN ProductionDeficienciesList AS DL ON ((DAC.ProductionDeficiencyID = DL.ProductionDeficiencyID) AND DL.isActive = 1)
										GROUP BY DAC.DepartmentID) AS TS ON (TS.DepartmentID = PIL.DepartmentID)
								LEFT JOIN (SELECT a.ProductionInspectionLogID AS CDID
											, a.DepartmentID AS CDDept
											, a.ProductionDeficiencyID AS CDDI
											/*, DATE(a.DateCreated) as ADateCreated
											, DATE(b.DateCreated) as BDateCreated*/
											, IF((b.Num IS NOT NULL), (@a := @a + 1), @a := 1) AS CDCD
										FROM
										(SELECT @a := 0) AS t,
										(SELECT DISTINCT mu.ProductionDeficiencyID
											, DATE(mu.DateCreated) as DateCreated
											, mu.ProductionInspectionLogID
											, m.DepartmentID
											/*, DATEDIFF(mu.DateCreated, b.DateCreated) AS Num*/
										FROM ProductionDeficienciesLog mu
											LEFT JOIN ProductionInspectionLog m ON m.ProductionInspectionLogID = mu.ProductionInspectionLogID
										ORDER BY m.DepartmentID, mu.ProductionDeficiencyID, mu.DateCreated) AS a
										LEFT JOIN (SELECT DISTINCT mu.ProductionDeficiencyID
													, DATE(mu.DateCreated) as DateCreated
													, mu.ProductionInspectionLogID
													, m.DepartmentID
													, IF(DATE(mu.DateCreated) IS NULL, 0, 1) AS Num
												FROM ProductionDeficienciesLog mu
													LEFT JOIN ProductionInspectionLog m ON m.ProductionInspectionLogID = mu.ProductionInspectionLogID) AS b
													ON ((b.ProductionDeficiencyID = a.ProductionDeficiencyID) AND (a.DepartmentID = b.DepartmentID) AND (a.DateCreated = b.DateCreated + INTERVAL 1 DAY))) AS CD ON ((CD.CDID = PIL.ProductionInspectionLogID)
																									AND (CD.CDDept = PIL.DepartmentID)
																									AND (CD.CDDI = PDEFLST.ProductionDeficiencyID))
							WHERE (PIL.DateCreated > DATE_SUB(curdate(), INTERVAL 30 DAY))
							ORDER BY PIL.ProductionInspectionLogID DESC, PDEFL.ProductionInspectionLogID;';

                    if (!($sqlDisplayEventLogResults = $db->query($sqlDisplayEventLog))) {
//                            die('<div class="notice"><h3>Error: ' . mysql_error() . '<br /><br /><br />Please contact your <a href="mailto:' . $dbAdminInfo . '" class="errorEmailLink">database administrator</a> indicating the above error.</h3></div>');
                    } else {
                        // check if row is returned, if yes error, if no get values
                        if ($db->numRows($sqlDisplayEventLogResults) == 0) {
//                                echo '<div class="notice"><h3>No Data was returned....<br /><br /><br />Please contact your <a href="mailto:' . $dbAdminInfo . '" class="errorEmailLink">database administrator</a> if you believe this is an error.</h3></div>';
                        } else {
                            ?>
                            <table class="tablesorter">
                            <thead>
                            <tr>
                                <th style="width: 70px;">Inspection Date</th>
                                <th style="width: 70px;">Created By</th>
                                <th style="width: 75px;">Department</th>
                                <th style="width: 25px;">Risk</th>
                                <th style="width: 200px;">Deficiency</th>
                                <th style="width: 200px;">Comments</th>
                                <th style="width: 200px;">Corrective Action(s)</th>
                                <th style="width: 25px; text-align: center;">%</th>
                                <th style="width: 25px; text-align: center;">Days</th>
                            </tr>
                            </thead>
                            <tbody>
                        <?php
                        $i = 0;
                        while ($rowDisplayEventLog = mysql_fetch_array($sqlDisplayEventLogResults))
                        {
                        $i++;

                        if ($rowDisplayEventLog['DeficiencyInspectionLogID'] <> $CurrentID)
                        {
                        if (!empty($CurrentID))
                        {
                        ?>
                            <script type="text/javascript">
                                var html = '<?php echo number_format(100-(($sumOfDefiecencies/$totalSumOfDefiecencies)*100),0); ?>';
                                $("#evtID<?php echo $CurrentID; ?>").html(html);
                                $("#evtID<?php echo $CurrentID; ?>").css('font-weight', 'bold').css('text-align', 'center');
                            </script>
                        <?php
                        }

                        $CurrentID = $rowDisplayEventLog['EventLogID'];
                        $sumOfDefiecencies = 0;
                        $isAltClass = 'class="altTD"';
                        $isEvtID = 'id="evtID' . $CurrentID . '"';
                        $sumOfDefiecencies = $rowDisplayEventLog["DeficiencyScore"];
                        $totalSumOfDefiecencies = $rowDisplayEventLog["TotalScore"];
                        } else {
                            $isAltClass = 'class="normTD"';
                            $isEvtID = '';
                            $sumOfDefiecencies += $rowDisplayEventLog["DeficiencyScore"];
                        }

                        echo "<tr>";

                        $isConsecutiveDays = (empty($rowDisplayEventLog["RiskFactor"])) ? 0 :
                            (((empty($rowDisplayEventLog["CDCD"]))) ? 1 : $rowDisplayEventLog["CDCD"]);

                        echo '<td ' . $isAltClass . '>' . date("m.d.Y", strtotime($rowDisplayEventLog["DateCreated"])) . '</td>';
                        echo '<td ' . $isAltClass . '>' . $rowDisplayEventLog["CreatedBy"] . '</td>';
                        echo '<td ' . $isAltClass . '>' . $rowDisplayEventLog["DepartmentName"] . '</td>';
                        echo '<td ' . $isAltClass . '>' . $rowDisplayEventLog["RiskFactor"] . '</td>';
                        echo '<td ' . $isAltClass . '>' . $rowDisplayEventLog["DeficiencyName"] . '</td>';
                        echo '<td ' . $isAltClass . '>' . nl2br($rowDisplayEventLog["Comments"]) . '</td>';
                        echo '<td ' . $isAltClass . '>' . nl2br($rowDisplayEventLog["CorrectiveActions"]) . '</td>';
                        echo '<td ' . $isAltClass . ' ' . $isEvtID . '></td>';
                        echo '<td ' . $isAltClass . ' style="text-align: center; font-weight: bold;">' . $isConsecutiveDays . '</td>';

                        echo '</tr>';

                        if ($i == $db->numRows($sqlDisplayEventLogResults))
                        {
                        ?>
                            <script type="text/javascript">
                                var html = '<?php echo number_format(100-(($sumOfDefiecencies/$totalSumOfDefiecencies)*100),0); ?>';
                                $("#evtID<?php echo $CurrentID; ?>").html(html);
                                $("#evtID<?php echo $CurrentID; ?>").css('font-weight', 'bold').css('text-align', 'center');
                            </script>
                        <?php
                        }
                        }
                        }
                    }
                    ?>
                        </tbody>
                        </table>
                    <?php
                    break;
            }
        }
    }

}#End of Class posts_controller

