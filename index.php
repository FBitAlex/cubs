<?php

	$col_cnt = 5;
	$row_cnt = 4;
	$box_size = 100;
	$wrap_width = $col_cnt * $box_size;
	$base = [];

	// input params
	 $params = [1,2,6,7,14,15,19,20];
	//$params = [19,20];
	//$params = [2,3,4,5,7,8,9,10];

	// generate our wrap
	for ($i=1; $i <= $row_cnt; $i++) {
		for ($j=1; $j <= $col_cnt; $j++) {
			$base[$i][$j]['sel'] = 0;
			$base[$i][$j]['rowspan'] = 1;
			$base[$i][$j]['colspan'] = 1;
		}
	}

	// check fields from $params
	for ($i=0; $i < count($params); $i++) {
		$find_row = intdiv($params[$i]-1, $col_cnt) + 1;
		$find_col = (($params[$i]-1) % $col_cnt)+1;
		$base[$find_row][$find_col]['sel'] = 1;
	}

?> <pre> <?php // print_r($base); ?></pre> <?php

	// generate our wrap
	for ($i=1; $i <= $row_cnt; $i++) {
		for ($j=1; $j <= $col_cnt; $j++) {
			
			if ( $base[$i][$j]['sel'] < 1 ) continue;

			// rowspan
			$rnum = 1;
			while ( ($i+$rnum) <= $row_cnt && $base[$i+$rnum][$j]['sel'] == 1 ) {
				$base[$i+$rnum][$j]['sel'] = -1;
				$base[$i][$j]['rowspan']++;
				$rnum++;
			}

			// colspan
			$cnum = 1;
			while ( ($j+$cnum) <= $col_cnt && $base[$i][$j+$cnum]['sel'] == 1 ) {
				$base[$i][$j+$cnum]['sel'] = -1;
				$base[$i][$j]['colspan']++;

				for ($k=1; $k < $base[$i][$j]['rowspan']; $k++) {
					$base[$i+$k][$j+$cnum]['sel'] = -1;
				}

				$cnum++;
			}

		}
	}
?>



<!DOCTYPE html>
<html>
<head>
	<title>TEST</title>

<style>

	.wrapper {
		width: <?=$wrap_width?>px;
		height: auto;
		margin: 100px auto;
		border-collapse: collapse;
	}

	.wrapper td {
		width: <?=$box_size?>px;
		height: <?=$box_size?>px;
		vertical-align: middle;
		border: 1px solid #00F;
		text-align: center;
		font-size: 20px;
	}

</style>

</head>
<body>

	<table class="wrapper">

		<?php

			$html = '';
			for ($i=1; $i <= $row_cnt; $i++) {
				$html .= "<tr>";
				for ($j=1; $j <= $col_cnt; $j++) {
					if ( $base[$i][$j]['sel'] < 0 ) continue;

					$html .= "<td colspan='" . $base[$i][$j]['colspan'] . "' rowspan='" . $base[$i][$j]['rowspan'] . "' >" .  $j . "</td>";
				}
				$html .= "</tr>";
			}
			echo $html;
		?>
	</table>

<pre> <?php //print_r($base); ?></pre>


</body>
</html>