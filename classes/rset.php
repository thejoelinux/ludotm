<?php
/**
 * Data result set used by data object
 */
class rset {

    public $table;     ///< array, names of the fields
    public $content;    ///< array, result rows
    public $numrows;    ///< integer, number of rows
    public $numfields;    ///< integer, number of fields
    public $_cursor;     ///< integer, private internal cursor
    public $diff;         // time elapsed in the select

    /*! Constructor of the class Rset
     * @param $fields integer number of fields
     * @param $rows integer number of rows
     */
    public function rset($fields, $rows) {
        $this->numfields = $fields;
        $this->numrows   = $rows;
        $this->_cursor   = 0;
        $this->table     = array();
        $this->content   = array();
    }
    
    /*! Get the value for the field and the current row
     * @param $name name of the field
     * @returns string value
     */
    public function value ($name) {
        if (isset($this->content[$this->_cursor][$name])) {
            return $this->content[$this->_cursor][$name];
        } elseif (in_array($name, $this->table)) {
            return "";
        } else {
            throw new Exception(
                dbg_trace("It seems that someone wants to have $name but there's no field with this name 
                    (oh and by the way, cursor is ".$this->_cursor." on a total of ".$this->numrows." in ", false)
            );
            return "NO_SUCH_COLLUMN";
        }
    }

    /*! Go to result set next row
     * @return false if end of result set is reached
     */
    public function nextrow () {    	
        $result = FALSE;
        if ($this->_cursor < $this->numrows - 1) {
        	if (array_key_exists($this->_cursor, $this->content))
        	{
        		unset($this->content[$this->_cursor]);
        	}
            $this->_cursor++;            
            $this->content[$this->_cursor] = mysqli_fetch_array($this->raw_content);            
            $result = TRUE;
        }
        // funny side effect of this public function : closing the result_set when done
        if ( method_exists('mysqli_result','close') && !$result ) {
            if ( $this->raw_content instanceof mysqli_result ) {
                $this->raw_content->close();
            } else {
                trigger_error('raw_content not defined as mysqli_result', E_USER_WARNING);
                unset($this->raw_content);
            }
        }
        return $result;
    }

    /* return TRUE if the cursor is on the last row
     */
    public function last() {
        if($this->numrows <= 1) {
            return TRUE;
        }
        return !($this->_cursor < $this->numrows - 1);

    }

    /* Returns a json output
     */
    public function display_json() {
        return "please write me";
    }


    /* Returns true if the query has failed
     *
     */
    public function error() {
        return ($this->table[0] == "Error");
    }
}
