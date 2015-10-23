<?php
include("classes/calendar.php");
?>
<div class="tool">
        <input type="hidden" id="date" name="date" value="<?=$date?>">
        <div class="tool_content" id="calendar" style="display: inline">
                <?php
                $cal = new calendar ($year, $month);
                $previous_month_date = $previous_year."-".sprintf("%02d", $previous_month)."-".date("t", mktime(0,0,0,$previous_month,1,$previous_year));
                $next_month_date = $next_year."-".sprintf("%02d", $next_month)."-01";
                ?>
                <div class="calendar_title">
                <a href="javascript:modif_date('<?=$previous_month_date?>', 'calendar', 'date')">&lt;&lt;</a>&nbsp;&nbsp; 
                <!-- a href="javascript:setDate('<?=$yersteday?>',1)">&lt;</a>&nbsp;&nbsp; -->
                <?=$cal->getFullMonthName()." ".$cal->getYear()?>&nbsp;&nbsp; 
                <!-- a href="javascript:setDate('<?=$tomorrow?>',1)">&gt;</a>&nbsp;&nbsp; -->
                <a href="javascript:modif_date('<?=$next_month_date?>', 'calendar', 'date')">&gt;&gt;</a>
                </div>
                <?=$cal->display(); ?>
        </div>
</div>
