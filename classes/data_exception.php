<?php
class data_exception extends Exception {

    public $sql_error_code;
    public $sql_error_message;
    public $sql_error_query;

    /**
     *
     * Enter description here ...
     * @param unknown_type $errno
     * @param unknown_type $error
     * @param unknown_type $query
     */
    public function __construct ($errno, $error, $query, Exception $previous = null) {
        $this->sql_error_code    = $errno;
        $this->sql_error_message = $error;
        $this->sql_error_query   = $query;
        if ( $previous instanceof Exception) {
            parent::__construct($error, $errno, $previous);
        } else {
            parent::__construct($error, $errno);
        }
    }

    // custom string representation of object
    public function __toString() {
    	try
    	{
	    	if (is_array($this->sql_error_message) && array_key_exists($this->sql_error_code, $this->sql_error_message))
	        	return __CLASS__ . ": [{$this->code}]: {$this->sql_error_message  [$this->sql_error_code]}\n";
	    	else
	    		return __CLASS__ . ": [{$this->code}]: Error {$this->sql_error_code}\n";
    	} catch (Exception $e)
    	{
    		return __CLASS__ . ": [{$this->code}]: {$this->sql_error_message}\n";
    	}
    }

    public function to_json() {
        return '{"code":"'.$this->sql_error_code.'",
                "message":"DB exception : '.$this->sql_error_message.'",
                "query":"'.$this->sql_error_query.'"}';
    }
}
