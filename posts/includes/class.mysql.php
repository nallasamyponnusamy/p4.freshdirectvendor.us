<?php

class mysql
{

    var $queryCounter = 0;
    var $totalTime = 0;

    function mysql()
    {
        global $config;
        $host = $config['db_host'];
        $db_user = $config['db_user'];
        $db_pass = $config['db_password'];
        $db = $config['db_database'];

        $startTime = $this->getMicroTime();

        mysql_connect($host, $db_user, $db_pass) or die("Could not connect to database");
        mysql_select_db($db) or die("Could not select database " . $db);

        $this->totalTime += $this->getMicroTime() - $startTime;
    }

    //Executes and returns a query
    function query($sql)
    {
        $startTime = $this->getMicroTime();

        ++$this->queryCounter;

        $result = mysql_query($sql);

        if (mysql_error()) {
            $this->mailError($sql, mysql_error(), mysql_errno());
            return $this->error("<div id='error'>There was a SQL error and it has been reported. Sorry for the inconvience.</div>");
        }

        $this->totalTime += $this->getMicroTime() - $startTime;

        return $result;
    }

    //Fetch array Query MySQL Database
    function fetch($result)
    {
        $rows = mysql_fetch_array($result);
        return $rows;
    }

    //Fetch array Query MySQL Database
    function fetch2($result)
    {
        $rows = mysql_fetch_array($result, MYSQL_ASSOC);
        return $rows;
    }

    function fetchO($result)
    {
        $row = mysql_fetch_object($result);
        return $row;
    }

    function fetchRow($result)
    {
        $rows = mysql_fetch_row($result);
        return $rows;
    }

    //Count the number of rows in query
    function numRows($result)
    {
        $count = mysql_num_rows($result);
        return $count;
    }

    //Run query and count the number of rows in query
    function numRowsQ($sql)
    {
        $result = $this->query($sql);
        $count = mysql_num_rows($result);
        return $count;
    }

    // Returns only one column
    function fetchOneCol($sql, $arr = 0)
    {
        $result = $this->query($sql);
        $return = $this->fetch($result);
        $return = $return[$arr];
        return $return;
    }

    // Find number of fields names in a query
    function numFields($result)
    {
        $fields = mysql_num_fields($result);
        return $fields;
    }

    // find single field name
    function fieldName($result, $fNum)
    {
        $name = mysql_field_name($result, $fNum);
        return $name;
    }

    //Get affected rows
    function getAffectedRows()
    {
        return mysql_affected_rows();
    }

    //Get last insert id
    function getInsertId()
    {
        return mysql_insert_id();
    }

####################################################
#              Time/Count Functions
####################################################

    function getDBTime($dec = 6)
    {
        $time = number_format(round($this->totalTime, $dec), $dec);
        return $time;
    }

    function getSqlCount()
    {
        return $this->queryCounter;
    }

    function getMicroTime()
    {
        list($usec, $sec) = explode(" ", microtime());
        return ((float)$usec + (float)$sec);
    }

    function showSQLStats($dec = 6)
    {
        $stats = $this->getSqlCount();
        $stats != 1 ? $stats .= " queries took " : $stats .= " query took ";
        $stats .= $this->getDBTime($dec) . " seconds to execute";
        return $stats;
    }

####################################################
#              Error Handling
####################################################
    // Sends an email to the admin on an error
    function mailError($sql, $error, $errorNo)
    {
        global $config;
        if ($config['dev']) {
            print $sql . "<div id='error'>" . $error . "<br /><br />" . $errorNo . "</div>";
        } else {
            mail($config['admin_email'], "SQL Error on " . $config['site_name'], $sql . "\n\n Error Msg: " . $error . "\n\n Error Number: " . $errorNo . "\n\n Page: " . $_SERVER['REQUEST_URI'], "From: " . $config['admin_email']);
        }
    }

    // error function
    function error($msg)
    {
        //print $msg;
        //die();
    }


}

?>