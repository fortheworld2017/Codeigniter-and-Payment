<?php
/**
 * This file has function to perform database related operations
 *
 * @package  mvc tactify
 * @category mvc
 */
 
/**
 * Class for MySql table interface.
 */
class Database
{
	/**
     * link identifier of DB connection
	 *
     * @var string
     */
	var $dbConnect;
	var $calcExecutionFlag = 0;
	
	/**
     * Establish a connection to the database
     *
     * Function: connect <br>
	 * Purpose : Used by function in models to create a connection to the database and log error if any error occurs while establishing connection. 
	 *
	 * @param string $hostName server to connect
	 * @param string $userName user name to login with
	 * @param string $passWord password to login with
	 * @param string $dataBase select the DB to work with
     * @return boolean Returns TRUE on success or display error message on failure.
     */
	function connect($hostName, $userName, $passWord, $dataBase) {
		$this->dbConnect = @mysqli_connect($hostName, $userName, $passWord,$dataBase)
						or $this->fatal_error('Database Connection', 
											  mysqli_connect_errno(), 
											  mysqli_connect_error());
		return $this->dbConnect;
	}
	
	/**
     * Returns an data array containing all the result set rows
     *
     * Function: sqlQueryArray <br>
	 * Purpose : Used by function in models to fetch the result set records and store data in a array, calculate query execution time and track error if any
	 *
	 * @param string $query
     * @return mixed Collection of rows on success or display error message on failure.
     */
	function sqlQueryArray($query, $bindParams = null) {
		$startTime = $this->CalculExecution();
		$result = $this->_sqlQueryArrayExec($query, $bindParams); 
		
		$tab = array();
		$icnt = 0;
		while($data = mysqli_fetch_object($result))
		{
		  	$tab[$icnt] = $data;
			$icnt++;
		}
		$endTime = $this->CalculExecution();
		
		return $tab;
	}
	
	/**
     * Add new records to a database table.
     *
     * Function: insertInto <br>
	 * Purpose : used by function in models to insert new records to a table, calculate query execution time and track error if any
	 *
	 * @param string $query
     * @return boolean Returns TRUE on success or display error message on failure
     */
	function insertInto($query, $bindParams = null) {
		//echo "<br>".$query;
		$startTime = $this->CalculExecution();
		$result = $this->sqlQuery($query, $bindParams);
		$endTime = $this->CalculExecution();
		return true;
	}
	
	/**
     * Update existing records in a table
     *
     * Function: updateInto <br>
	 * Purpose : Used by function in models to edit existing records in a table, calculate query execution time and track error if any
	 *
	 * @param string $query
     * @return boolean Returns TRUE on success or display error message on failure
     */
	function updateInto($query, $bindParams = null) {
	//echo $query;
		$startTime = $this->CalculExecution();
		$result = $this->sqlQuery($query, $bindParams);
		$endTime = $this->CalculExecution();
		return true;
	}
	
	/**
     * Frees memory used by a result handle
     *
     * Function: free<br>
	 * Purpose : Used by function in models to free the allocated memory
	 *
	 * @param string $result The result resource that is being evaluated
     * @return boolean Returns TRUE on success or FALSE on failure.
     */
	function free($result) {
		return @mysqli_free_result($result);
	}
	
	/**
     * Execute query
     *
     * Function: sqlQuery <br>
	 * Purpose : Used by function in models to execute the framed query
	 * @param string $query
     * @return boolean Return TRUE(DML statement), resultset(DDL statement) on success or FALSE on error. 
     */
	function sqlQuery($query, $bindParams = null) {
		$stmt  = mysqli_prepare($this->dbConnect, $query);
		
		if (is_array($bindParams) === true) {
            $params = array(''); // Create the empty 0 index
            foreach ($bindParams as $prop => $val) {
                $params[0] .= $this->_determineType($val);
                array_push($params, $bindParams[$prop]);
            }

            call_user_func_array(array($stmt, 'bind_param'), $this->refValues($params));

        }
		
		mysqli_stmt_execute($stmt) 
			   or $this->fatal_error("Query - ".$query, 
									 mysqli_errno($this->dbConnect), 
									 mysqli_error($this->dbConnect));
		$result = $stmt->get_result();
		
		return $result;
	}
	
	/**
     * Delete records
     *
     * Function: deleteInto <br>
	 * Purpose : Used by function in models to delete records from a database table
	 * @param string $query
	 * @param array $bindParams 
	 * 
     * @return boolean Return TRUE on success or FALSE on error. 
     */
	function deleteInto($query, $bindParams = null) {
		$result = $this->sqlQuery($query, $bindParams);
		return $result;
	}
	
	/**
     * Fetch result as an associative array
     *
     * Function: sqlFetchArray <br>
	 * Purpose : Used by function in models to fetch a result row as an associative array
	 *
	 * @param string $query
     * @return mixed Returns an array of strings that corresponds to the fetched row, or FALSE  if there are no more rows
     */
	function sqlFetchArray($result) {
		return @mysqli_fetch_array($result, MYSQLI_ASSOC);
	}
	
	/**
     * Fetch the content of one cell
     *
     * Function: sqlResult <br>
	 * Purpose : used by function in models to retrieves the contents of particular column from a result set.
	 *
	 * @param string $result The result resource that is being evaluated
	 * @param string $row The row number from the result that is being retrieved
	 * @param string field The name or offset of the field being retrieved.
     * @return mixed The contents of specified cell from a MySQL result set on success, or FALSE on failure
     */
	function sqlResult($result,$row,$field=0) {
		//return @mysql_result($result,$pos);
		$result->data_seek($row); 
		$datarow = mysqli_fetch_array($result); 
		return $datarow[$field]; 
	}
	
	/**
     * Fetch a result row as an object
     *
     * Function: sqlFetchObject <br>
	 * Purpose : used by function in models to fetch a result row as an object.
	 *
	 * @param string $result The result resource that is being evaluated
     * @return mixed Returns an object that corresponds to the fetched row, or FALSE  if there are no more rows
     */
	function sqlFetchObject($result) {
		return @mysqli_fetch_object($result);
	}
	
	/**
     * Get the number of rows in the result
     *
     * Function: sqlNumRows <br>
	 * Purpose : Used by function in models to get the count of rows in a result.
	 *
	 * @param string $result The result resource that is being evaluated
     * @return mixed The number of rows in a result set on success, or FALSE on failure.
     */
	function sqlNumRows($result) {
		return @mysqli_num_rows($result);
	}
	
	/**
     * Fetch a result row as an indexed array
     *
     * Function: sqlFetchRow <br>
	 * Purpose : Used by function in models to fetch a result row as an indexed array.
	 *
	 * @param string $result The result resource that is being evaluated
     * @return mixed Returns a numerically indexed array that corresponds to the fetched row, or FALSE  if there are no more rows
     */
	function sqlFetchRow($result) {
    	return @mysqli_fetch_row($result);
  	}
	
	/**
     * Gets the last generated ID
     *
     * Function: sqlInsertId <br>
	 * Purpose : Used by function in models to retrieves the ID generated for an AUTO_INCREMENT column by the previous INSERT query.
	 *
	 * @param string $result The result resource that is being evaluated
     * @return mixed Return ID generated for an AUTO_INCREMENT column by the previous INSERT query on success, 
	 *               0 if the previous query does not generate an AUTO_INCREMENT value,
	 *               or FALSE if no MySQL connection was established.
     */
	function sqlInsertId($link = "")
	{
		if($link == "") $link = $this->dbConnect;
		return mysqli_insert_id($link);
	}
	
	/**
     * Calculate query execution time
     *
     * Function: CalculExecution <br>
	 * Purpose : Used by function in models to calculate the query execution time.
	 *
     * @return float execution time.
     */
	function CalculExecution() 
	{
		if ($calcExecutionFlag == 1)
		{
			list($mSec, $sec) = explode(' ', microtime());
			$r= ((float) $sec + (float) $mSec);
			return $r;
		}
		else
			return NULL;
	}
	
	/**
     * Throws error if error occurs while executing query
     *
     * Function: fatal_error <br>
	 * Purpose : To keep track of error message.
	 *
	 * @param string $message Error messages
     * @return float execution time.
     */
	function fatal_error($query, $errorNumber, $errormessage)
	{
		echo '<br>ERROR -- '       . $errormessage 
		   . ' , Error number  = ' . $errorNumber 
		   . ' , Error message = ' . $errormessage 
		   . ' , Query = '         . $query;
	}
	
	/**
     * Get the number of rows in the table
     *
     * Function: sqlCalcFoundRows <br>
	 * Purpose : Used to get the total number of rows in the table.
	 *
     * @return integer return total row count.
     */
	function sqlCalcFoundRows() {
		$query = 'SELECT FOUND_ROWS() as totalCount';
		$resource = $this->sqlQuery($query);
		$result = mysqli_fetch_array($resource);
		return $result['totalCount'];
	}
	
	function sqlQueryEventArray($query, $bindParams = null) {
		
		$startTime = $this->CalculExecution();
		$result = _sqlQueryArrayExec($query, $bindParams);
		
		$tab = array();
		while($data = mysqli_fetch_object($result))
		{
		  	$tab[$data->fkCategoryId][$data->fkSubCatId][] = $data; //fkSubCategoryId
		}
		$endTime = $this->CalculExecution();
		
		return $tab;
	}
	
	function sqlQueryEventAJAXArray($query) {//echo "<br>".$query;
		
		global $my_event_list;
		global $categories_array;
		
		$startTime = $this->CalculExecution();
		$result = _sqlQueryArrayExec($query);
		
		$tab = array();
		while($data = mysqli_fetch_object($result))
		{
			$data->date_display = date(DATE_EVENT_LIST,strtotime($data->date));
			 if(is_array($_SESSION['fb_array']) && count($_SESSION['fb_array'])>0 && in_array($data->userId,$_SESSION['fb_array'])) { 
				$data->name_display =  ucfirst($data->firstName).' '.$data->lastName;
			}
			else
			{
			 	$data->name_display = ucfirst($data->firstName).' '.ucfirst(substr($data->lastName,0,1)); 
			}
			if(isset($my_event_list[$data->id]))
				$data->rsvp_display		= 'none';
			else
				$data->rsvp_display		= 'block';
			$data->display_subcatshortname	=  trim(displayText(strtoupper($data->fkSubCategoryId),7));
			
			$data->display_catname		   	=   strtoupper($categories_array[$data->fkCategoryId]);
			$data->description_display = displayText(ucfirst(($data->description)),40,1);//escapeSpecialCharacters
		  	$tab[$data->fkCategoryId][$data->fkSubCatId][] = $data; //fkSubCategoryId
		}
		$endTime = $this->CalculExecution();
		
		return $tab;
	}
	
	function sqlQueryArrayMyEvents($query) {//echo "<br>".$query;
		
		$startTime = $this->CalculExecution();
		$result = _sqlQueryArrayExec($query);
		
		$tab = array();
		while($data = mysqli_fetch_object($result))
		{
		  	$tab[$data->fkEventId]= $data->fkEventId;
		}
   		$endTime = $this->CalculExecution();
		
		return $tab;
	}
	
	function sqlQueryArrayForSearch($query) {//echo "<br>".$query;
		
		$startTime = $this->CalculExecution();
		$result = _sqlQueryArrayExec($query);
		
		$tab = array();
		while($data = mysqli_fetch_object($result))
		{
		  	$tab[$data->id]= $data->subCategory;
		}
		$endTime = $this->CalculExecution();
		
		return $tab;
	}
	
	/**
	 * Array to hold all requested query. Used in sqlQueryArray*() functions below
	 *
	 *  @global string $GLOBAL_REQUESTS_QUERIES
	 **/ 
	function _sqlQueryArrayExec($query, $bindParams = null) {
		global $GLOBAL_REQUESTS_QUERIES;
		
		$result = $this->sqlQuery($query, $bindParams);
		$GLOBAL_REQUESTS_QUERIES[] = $query;
		
		return $result;
	}
	
	/**
     * This method is needed for prepared statements. They require
     * the data type of the field to be bound with "i" s", etc.
     * This function takes the input, determines what type it is,
     * and then updates the param_type.
     *
     * @param mixed $item Input to determine the type.
     *
     * @return string The joined parameter types.
     */
    protected function _determineType($item)
    {
        switch (gettype($item)) {
            case 'NULL':
            case 'string':
                return 's';
                break;

            case 'integer':
                return 'i';
                break;

            case 'blob':
                return 'b';
                break;

            case 'double':
                return 'd';
                break;
        }
        return '';
    }
	/**
	 * This method returns a reference array
	 * Used when binding params/results for prep stmts
	 *
     * @param array $arr
     *
     * @return array
     */
    protected function refValues($arr)
    {
        //Reference is required for PHP 5.3+
        if (strnatcmp(phpversion(), '5.3') >= 0) {
            $refs = array();
            foreach ($arr as $key => $value) {
                $refs[$key] = & $arr[$key];
            }
            return $refs;
        }
        return $arr;
    }
	
}?>