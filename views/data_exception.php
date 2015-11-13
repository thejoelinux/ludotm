<div>
	<p style="font-size:120%; text-align: center">Serious Database Error</p>
	<p>Some SQL query has failed.</p>
	<?php
		if($debug) {
			?>
			<p style="background-color: white;">
				<table style="border: 1px solid black;">
				<tr style="background-color: gray">
					<th>The Famous Error Code</th>
					<td><?=$e->sql_error_code?></td>
				</tr>
				<tr>
					<th>The Problematic Query</th>
					<td><pre style="width: 650px; border: 1px solid black; overflow: auto;"><?=$e->sql_error_query?></pre></td>
				</tr>
				<tr style="background-color: gray">
					<th>The Enigmatic Error Message</th>
					<td><?=$e->sql_error_message?></td>
				</tr>
				<tr>
					<th>The Complete Trace</th>
					<td><pre style="width: 650px; border: 1px solid black; overflow: auto;"><?=$e->getTraceAsString()?></pre></td>
				</tr>	
			</table>
			</p>
			<?php
		} else {
			echo "If you want (and can) you could enable the 'debug' parameter in the config file to know what failed.";
		}
	?>
</div>
