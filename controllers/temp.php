<?php
public function p_searchEventLog()
{


$StartDate = strip_tags($_GET['sd']);
$EndDate = strip_tags($_GET['ed']);
$DepartmentString = (strip_tags($_GET['deptl']) == 'null') ? '' : strip_tags($_GET['deptl']);
$DeficiencyString = (strip_tags($_GET['defl']) == 'null') ? '' : strip_tags($_GET['defl']);
$AuthUserID = strip_tags($_GET['d']);

if (empty($AuthUserID) || ((empty($StartDate)) && (empty($EndDate)) && (empty($DepartmentString)) && (empty($DeficiencyString)))) {
    echo '<span style="display: block; padding: 10px 0px 10px 0px; font-weight: bold;">*** ERROR (MP) ***</span>';
} else {

        // if there is no department selection, we need to take results for
        // both production and non production departments
        switch ($DepartmentString) {
            case '':
                $isFilterP .= (!(empty($StartDate))) ? 'AND PIL.DateCreated >= "' . date('Y-m-d', strtotime($StartDate)) . '" ' : '';
                $isFilterP .= (!(empty($EndDate))) ? 'AND PIL.DateCreated <= "' . date('Y-m-d', strtotime($EndDate)) . '" ' : '';
                $isFilterNP .= (!(empty($StartDate))) ? 'AND NPIL.DateCreated >= "' . date('Y-m-d', strtotime($StartDate)) . '" ' : '';
                $isFilterNP .= (!(empty($EndDate))) ? 'AND NPIL.DateCreated <= "' . date('Y-m-d', strtotime($EndDate)) . '" ' : '';


                $sq = 'SELECT *
                                FROM (SELECT PIL.ProductionInspectionLogID AS EventLogID
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
                                WHERE PIL.ProductionInspectionLogID IS NOT NULL /* USE A DUMMY WHERE CLAUSE SINCE WE ARE DYNAMICALLY CREATING THE AND FILTERS */
                                ' . $isFilterP . '
                                UNION
                                SELECT NPIL.NonProductionInspectionLogID AS EventLogID
                                    , NPDL.DepartmentName AS DepartmentName
                                    , AU.EmployeeName AS CreatedBy
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
                                    LEFT JOIN AuthUsers AS AU ON (NPIL.AuthUserID = AU.AuthUserID)
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
                                WHERE NPIL.NonProductionInspectionLogID IS NOT NULL /* USE A DUMMY WHERE CLAUSE SINCE WE ARE DYNAMICALLY CREATING THE AND FILTERS */
                                ' . $isFilterNP . ' ) AS xxx ORDER BY xxx.DateCreated DESC';
                break;
            }
        }
# Run the query, store the results in the variable $posts
        $sqlDisplayEventLog = DB::instance(DB_NAME)->select_rows($q);


        echo "<div>";
        echo "    <h3>Search Results</h3>";
        echo "</div>";
        echo '<div id="callList">';
        echo '    <table class="tablesorter">';
        echo "  <thead>";
        echo "<tr>";
        echo '"<th style="width: 70px;">Inspection Date</th>';
        echo '<th style="width: 70px;">Created By</th>';
        echo '<th style="width: 75px;">Department</th>';
        echo '<th style="width: 25px;">Risk</th>';
        echo '<th style="width: 200px;">Deficiency</th>';
        echo '<th style="width: 200px;">Comments</th>';
        echo '<th style="width: 200px;">Corrective Action(s)</th>';
        echo '<th style="width: 25px; text-align: center;">%</th>';
        echo '<th style="width: 25px; text-align: center;">Days</th>';
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
//        <?php
                    $i = 0;
                    foreach ($sqlDisplayEventLog as $rowDisplayEventLog):
                    //        while ($rowDisplayEventLog = mysql_fetch_array($sqlDisplayEventLogResults))
                    {
                         $i++;

                    if ($rowDisplayEventLog['DeficiencyInspectionLogID'] <> $CurrentID) {
                       if (!empty($CurrentID))
                              {
                                echo ' <script type="text/javascript">';
                                echo " var html = ";
                                <?
                                php echo number_format(100 - (($sumOfDefiecencies / $totalSumOfDefiecencies) * 100), 0); ?>;
                                echo "$("#evtID"; <?php echo $CurrentID; ?>  echo ").html(html)";
                                $("#evtID<?php echo $CurrentID; ?>").css('font-weight', 'bold').css('text-align', 'center');
                                </script>';
                                    $CurrentID = $rowDisplayEventLog['EventLogID'];
                                    $sumOfDefiecencies = 0;
                                    $isAltClass = 'class="altTD"';
                                    $isEvtID = 'id="evtID'.$CurrentID.
                                    '"';
                                    $sumOfDefiecencies = $rowDisplayEventLog["DeficiencyScore"];
                                    $totalSumOfDefiecencies = $rowDisplayEventLog["TotalScore"];
                                 } else
                        {
                        $isAltClass = 'class="normTD"';
                        $isEvtID = '';
                        $sumOfDefiecencies += $rowDisplayEventLog["DeficiencyScore"];
                        }

                    echo
                    "<tr>";

                    $isConsecutiveDays = (empty($rowDisplayEventLog["RiskFactor"])) ? 0 :
                        (((!empty($rowDisplayEventLog["RiskFactor"])) && (empty($rowDisplayEventLog["CDCD"]))) ? 1 : $rowDisplayEventLog["CDCD"]);

                    echo
                    '<td '.$isAltClass.
                    '>'.date("m.d.Y", strtotime($rowDisplayEventLog["DateCreated"])).
                    '</td>';
                    echo
                    '<td '.$isAltClass.
                    '>'.$rowDisplayEventLog["CreatedBy"].
                    '</td>';
                    echo
                    '<td '.$isAltClass.
                    '>'.$rowDisplayEventLog["DepartmentName"].
                    '</td>';
                    echo
                    '<td '.$isAltClass.
                    '>'.$rowDisplayEventLog["RiskFactor"].
                    '</td>';
                    echo
                    '<td '.$isAltClass.
                    '>'.$rowDisplayEventLog["DeficiencyName"].
                    '</td>';
                    echo
                    '<td '.$isAltClass.
                    '>'.nl2br($rowDisplayEventLog["Comments"]).
                    '</td>';
                    echo
                    '<td '.$isAltClass.
                    '>'.nl2br($rowDisplayEventLog["CorrectiveActions"]).
                    '</td>';
                    echo
                    '<td '.$isAltClass.
                    ' '.$isEvtID.
                    '></td>';
                    echo
                    '<td '.$isAltClass.
                    ' style="text-align: center; font-weight: bold;">'.$isConsecutiveDays.
                    '</td>';

                    echo
                    '</tr>';

                    //        if ($i == $db->numRows($sqlDisplayEventLogResults))
                    if ($i == count($sqlDisplayEventLogResults)) {


                        echo
                        ' <script type="text/javascript">';
                        echo
                        '    var html = '
                        <?php echo number_format(100-(($sumOfDefiecencies/$totalSumOfDefiecencies)*100),0); ?>';
                        $("#evtID<?php echo $CurrentID; ?>").html(html);
                        $("#evtID<?php echo $CurrentID; ?>").css('font-weight', 'bold').css('text-align', 'center');
                        echo
                        " </script> ";
                    }
                    endforeach;

                    echo "</tbody>";
                    echo "</table>";

                    echo "</div>";

                    ?>
                    }
                }
            }