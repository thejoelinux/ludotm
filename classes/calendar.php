<?php
// $Id$
/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
*/
/**
* Basic Calendar data and display
*
* @author Oscar Merida <oscar@oscarm.org>
* @created Jan 18 2004
* @updated Feb 2 2004
*/
class calendar {

public $year;
public $month;    
public $monthNameFull;
public $monthNameBrief;
public $startDay;
public $endDay;  
public $display_links_on_week;
/**
* Constructor
*
* @param integer, year
* @param integer, month
* @param boolean, whether the links on week should be displayed
* @return object
* @public
*/
function Calendar ( $yr, $mo, $dlow = FALSE )
{

    $this->display_links_on_week = $dlow;

    setlocale(LC_TIME,'fr_FR');

    $this->year    = $yr;
    $this->month   = (int) $mo;
    
    $this->startTime = strtotime( "$yr-$mo-01 00:00" );
    
    $this->endDay = date( 't', $this->startTime );
    
    $this->endTime   = strtotime( "$yr-$mo-".$this->endDay." 23:59" );
     
    $this->startDay    = date( 'D', $this->startTime );
    $this->startOffset = date( 'w', $this->startTime ) - 1;
    
    if ( $this->startOffset < 0 )
    {        
        $this->startOffset = 6;
    }
    
    $this->monthNameFull = strftime( '%B', $this->startTime );
    $this->monthNameBrief= strftime( '%b', $this->startTime );
    
    $this->dayNameFmt = '%a';
    $this->tblWidth="*";
}
// ==== end Calendar ================================================

function getStartTime()
{
    return $this->startTime;   
}

function getEndTime()
{    
    return $this->endTime;    
}

function getYear()
{
    return $this->year;   
}

function getFullMonthName()
{
    return $this->monthNameFull;   
}

function getBriefMonthName()
{
    return $this->monthNameBrief;   
}

function setTableWidth( $w )
{
    $this->tblWidth = $w;   
}

function setYear( $year )
{    
    $this->year = $year;   
}

function setMonth( $month )
{
    $this->month = $month;   
}
/**
* Any valid strftime format for display weekday names
*
* %a - abbreviated, %A - full, %u as number with 1==Monday
*/
function setDayNameFormat( $f )
{
    $this->dayNameFmt = $f;   
}
/**
* Returns markup for displaying the calendar.
*
* @return
* @public
*/
function display ( )
{
    ob_start();
?>
    <table border="1" cellspacing="0" cellpadding="0" width="<?=$this->tblWidth?>">
        <?=$this->dspDayNames()?>
        <?=$this->dspDayCells()?>
    </table>
<?php    
    $c = ob_get_contents();
    ob_end_clean();
    return $c;
}
// ==== end display ================================================

function dc_display() {
         ob_start();
?>
    <table border="1" cellspacing="0" cellpadding="0" width="<?=$this->tblWidth?>">
        <?=$this->dc_dspDayNames()?>
        <?=$this->dc_dspDayCells()?>
    </table>
<?php    
    $c = ob_get_contents();
    ob_end_clean();
    return $c;

}


/**
* Displays the row of day names.
*
* @return string
* @private
*/
function dspDayNames ( )
{
    ob_start();?>
        <tr>
<?php    
    for( $i=-3; $i<4; $i++ ) {
        echo '<th width="12%">'.substr(date("l",($i*86400)),0,2)."</th>";
    }        
?>
        <th width="12%">Week</th>
        </tr>
<?php    
    $c = ob_get_contents();
    ob_end_clean();
    return $c;
}

function dc_dspDayNames ( )
{
    ob_start();?>
        <tr>
<?php    
    for( $i=-2; $i<3; $i++ ) {
        echo '<th width="12%">'.substr(date("l",($i*86400)),0,2)."</th>";
    }        
?>
        <th width="12%">Sem</th>
        </tr>
<?php    
    $c = ob_get_contents();
    ob_end_clean();
    return $c;
}
// ==== end dspDayNames ================================================

/**
* Displays all day cells for the month
*
* @return string
* @private
*/
function dspDayCells ( )
{
    $i = 0; // cell counter
    ob_start();
?>
        <tr>
<?php    

    // first display empty cells based on what weekday the month starts in]
    for( $c=0; $c<$this->startOffset; $c++ )
    {
        $i++;
?>        
        <td class="notInMonth">&nbsp;</td>
<?php
    } // end offset cells

    // write out the rest of the days, at each sunday, start a new row.
    for( $d=1; $d<=$this->endDay; $d++ )
    {
        $i++;
?>        
        <?=$this->dspDayCell( $d );?>        
<?php
        if ( $i%7 == 0 )
        { 
        
                echo $this->dspWeekCell( $d );        
        ?>
        </tr>        
<?php   }
        
        if ( $d<$this->endDay && $i%7 == 0 )
        {
?>      <tr>       
<?php   }
    }
    
    // fill in the final row
    $left = 7 - ( $i%7 );
    
    if ( $left < 7)  
    {
        for ( $c=0; $c<$left; $c++ )
        {
          echo '<td class="notInMonth">&nbsp;</td>';
        }
        echo '<td class="notInMonth">&nbsp;</td>';
        echo "\n\t</tr>";        
    }    

    $c = ob_get_contents();
    ob_end_clean();
    return $c;        
}

// ==== end dspDayCells ================================================

    
/**
* outputs the contents for a given day
*
* @param integer, day
* @abstract
*/
function dspDayCell ( $day )
{
    $open_link = $close_link = "";      
    $mydate = mktime(0,0,0,$this->month,$day,$this->year);
    if($mydate < mktime())
    {
        $close_link = "</a>";
                $open_link = "<a href=\"javascript:apply_value('date', '".
                        $this->year."-".sprintf("%02d", $this->month)."-".sprintf("%02d", $day)."')\">";
    }
    $class = "calendar";
    if(array_key_exists("date", $_SESSION)) {
            $day_req = $_SESSION["date"]{8}.$_SESSION["date"]{9};
    } else {
            $day_req = date("d");
    }
    if($day == $day_req) {
            $class = "current";
    }
        
    return "<td class=\"$class\">".$open_link.$day.$close_link."</td>";
}

/**
* outputs the contents for a given day
*
* @param integer, day
* @abstract
*/
function dspWeekCell ( $day )
{
    $open_link = $close_link = "";      
    $mydate = mktime(0,0,0,$this->month,$day,$this->year);
        if($this->display_links_on_week) {
        $close_link = "</a>";
                $open_link = "<a href=\"javascript:apply_value('date', '".
                $this->year."-".sprintf("%02d", $this->month)."-".sprintf("%02d", $day)."')\">";
    }
    $class = "calendar";
    if(array_key_exists("date", $_SESSION)) {
            $day_req = $_SESSION["date"]{8}.$_SESSION["date"]{9};
    } else {
            $day_req = date("d");
    }

    $weeknr = date("W", $mydate);
    return "<td class=\"$class\">".$open_link.$weeknr.$close_link."</td>";
}

// ==== end WeekCell ================================================    
    
} // end class
