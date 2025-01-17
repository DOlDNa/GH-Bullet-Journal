<?php include 'header.php'?>
<!doctype html>
<html lang=ja>
	<head>
		<meta charset=utf-8>
		<title>GH Bullet Journal</title>
		<meta name=viewport content="width=device-width,initial-scale=1">
		<link href="css/" rel=stylesheet>
		<link rel=icon href=icon.svg type="image/svg+xml" sizes=any>
	</head>
	<body>
		<main>
			<table id=table class=asphalt>
				<caption class=double-gap-bottom>
					<a href="./" tabindex=-1>
						<svg xmlns="http://www.w3.org/2000/svg" class="pulse animated" viewBox="0 0 14.55 14.55" version="1.1" fill="#ffffff" height="100" width="100"><path d="m5.8129 1.1605c-0.21453 0.00212-0.42838 0.015253-0.64258 0.041016-0.57119 0.0687-1.1366 0.22157-1.6797 0.46289-2.1747 0.9663-3.5557 3.1564-3.4883 5.5352 0.064341 2.3762 1.5599 4.4858 3.7812 5.332 1.3137 0.50024 2.7292 0.49475 4.0059 0.05469l0.7989 0.799 5.9567-5.9569-1.763-1.7637-4.2015 4.1992c-0.00201 0.0019-0.00385 0.0039-0.00586 0.0059l-2.8652-2.8652-1.7481 1.748 2.1856 2.1877c-0.554 0.038-1.1204-0.04-1.6621-0.246h-0.00195c-1.482-0.56528-2.4727-1.9612-2.5156-3.5469v-0.00195c-0.045-1.5883 0.8686-3.0388 2.3203-3.6839 1.4501-0.6444 3.1386-0.3528 4.2871 0.7422l1.3555-1.4219c-1.129-1.0764-2.6155-1.6359-4.1172-1.6211z"/></svg>
						<h1 class="quicksand white">GH Bullet Journal</h1>
					</a>
				</caption>
				<thead>
					<tr>
						<td colspan=2 class=triple-padded-desktop><?php
							if ($error_message) echo '
							<div class="error message triple-gap-bottom">', $error_message, '</div>';
							?>

							<form method=post>
								<fieldset class="double-padded-desktop square" id=fieldset>
									<legend class=center>
										<input type=radio class=hidden id=r0 name=color value=none<?=$color === 'none' || !$color ? ' checked' : ''?> onchange="c('#dbdbdc','#3b3b3b')">
										<label for=r0 class="box">無</label>
										<input type=radio class=hidden id=r1 name=color value=white<?=$color === 'white' ? ' checked' : ''?> onchange="c('black','white')">
										<label for=r1 class="white box">白</label>
										<input type=radio class=hidden id=r2 name=color value=blue<?=$color === 'blue' ? ' checked' : ''?> onchange="c('#337ab7','#d9edf7')">
										<label for=r2 class="info box">青</label>
										<input type=radio class=hidden id=r3 name=color value=green<?=$color === 'green' ? ' checked' : ''?> onchange="c('#3c763d','#dff0d8')">
										<label for=r3 class="success box">緑</label>
										<input type=radio class=hidden id=r4 name=color value=yellow<?=$color === 'yellow' ? ' checked' : ''?> onchange="c('#8a6d3b','#fcf8e3')">
										<label for=r4 class="alert box">黄</label>
										<input type=radio class=hidden id=r5 name=color value=pink<?=$color === 'pink' ? ' checked' : ''?> onchange="c('#a94442','#f2dede')">
										<label for=r5 class="error box">桃</label>
									</legend>
									<div class=flex-wrapper>
										<input type=radio class=hidden id=r6 value=y name=ymd<?=$target === 'yearly' ? ' checked' : ''?> onchange="b('<?=$maxy?>','<?=$y?>','number','<?=$year?>','<?=$year?>年','yearly')">
										<label for=r6 class="question small box">年</label>
										<input type=radio class=hidden id=r7 value=m name=ymd<?=$target === 'monthly' ? ' checked' : ''?> onchange="b('<?=$maxy?>-12','<?=$y, '-', $m?>','month','<?=$year, '-', $month?>','<?=$year, '年', $month?>月','monthly')">
										<label for=r7 class="question small box">月</label>
										<input type=radio class=hidden id=r8 value=d name=ymd<?=$target === 'daily' || !$target ? ' checked' : ''?> onchange="b('<?=$maxy?>-12-31','<?=$today?>','date','<?=$thisday?>','<?=$thisday?>','daily')">
										<label for=r8 class="question small box">日</label>
										<input name=date id=date tabindex=-1 class="source-sans-pro square" <?=$type?> accesskey=d>
									</div>
									<textarea class="dark square" name=schedule id=schedule accesskey=s tabindex=1 required<?=
									match ($color)
									{
										'none' => ' style="color:#dbdbdc;background-color:#3b3b3b"',
										'white' => ' style="color:black;background-color:white"',
										'blue' => ' style="color:#337ab7;background-color:#d9edf7"',
										'green' => ' style="color:#3c763d;background-color:#dff0d8"',
										'yellow' => ' style="color:#8a6d3b;background-color:#fcf8e3"',
										'pink' => ' style="color:#a94442;background-color:#f2dede"',
									}, $schedule ? '>'. trim($schedule) : ' placeholder="'. $placeholder. 'の予定">'
									?></textarea>
									<input type=hidden name=target id=target value=<?=$target?>>
									<input type=submit accesskey=r <?=$mode === 'edit' ? 'value="更新" class="button info block square"' : 'value="登録" class="button question block square"'?>>
								</fieldset>
							</form>
						</td>
					</tr>
					<tr>
						<th colspan=2 class=align-center id=nav>
							<span class=gapped><a accesskey=z tabindex=-1 href="./?date=<?=$last_year->format('Y-m')?>#nav"><i class=icon-double-angle-left></i></a></span>
							<span class=gapped><a accesskey=p tabindex=-1 href="./?date=<?=$last_month->format('Y-m')?>#nav"><i class=icon-angle-left></i></a></span>
							<span class=gapped><a accesskey=h tabindex=-1 href="./" rel=home></a></span>
							<span class=gapped><a accesskey=n tabindex=-1 href="./?date=<?=$next_month->format('Y-m')?>#nav"><i class=icon-angle-right></i></a></span>
							<span class=gapped><a accesskey=a tabindex=-1 href="./?date=<?=$next_year->format('Y')?>#nav"><i class=icon-double-angle-right></i></a></span>
						</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th colspan=2 class="align-right white quicksand"><a class=small href="./" tabindex=-1>© <?=$y?> GH Bullet Journal.</a></th>
					</tr>
				</tfoot>
				<tbody>
					<tr>
						<th class=th id=yearly<?=$year?>>
							<a tabindex=-1 href="./?target=yearly&#38;date=<?=$year?>#fieldset"><?=$year?><small>年</small></a>
						</th>
						<td class=td><?php
							if (isset($yearly_schedule_list)) foreach ($yearly_schedule_list as $lineno => $line)
							{
								list($schedule_date, $schedule, $complete, $color) = explode(',', $line);
								if ($year === $schedule_date)
								{
									echo '
							<table class=separate>
								<tbody>
									<tr>
										<td',
									match ($color)
									{
										'none' => ' class="dark box schedule square"',
										'white' => ' class="white box schedule square"',
										'blue' => ' class="info box schedule square"',
										'green' => ' class="success box schedule square"',
										'yellow' => ' class="alert box schedule square"',
										'pink' => ' class="error box schedule square"',
									}, '>', (trim($complete) === 'complete' ? '<del>'. $schedule. '</del>' : $schedule), '</td>';

									if (trim($complete) === 'complete')
										echo '
										<td class="button green square" onclick="l(this.firstElementChild)">
											<a tabindex=1 href="./?target=yearly&#38;lineno=', $lineno, '&#38;date=', $get_date, '&#38;mode=complete"><i class=icon-check></i>完了</a>
										</td>';
									else
										echo '
										<td class="button orange square" onclick="l(this.firstElementChild)">
											<a tabindex=1 href="./?target=yearly&#38;lineno=', $lineno, '&#38;date=', $get_date, '&#38;mode=incomplete"><i class=icon-check-empty></i>未完</a>
										</td>';
									echo '
										<td class="button blue square" onclick="l(this.firstElementChild)">
											<a tabindex=1 href="./?target=yearly&#38;lineno=', $lineno, '&#38;date=', $get_date, '&#38;mode=edit#fieldset"><i class=icon-edit></i>編集</a>
										</td>
										<td class="button red square" onclick="if(!confirm(\'削除しますか?\'))return false;l(this.firstElementChild)">
											<a tabindex=1 href="./?target=yearly&#38;lineno=', $lineno, '&#38;date=', $get_date, '&#38;mode=delete"><i class=icon-trash></i>削除</a>
										</td>
									</tr>
								</tbody>
							</table>';
								}
							}
							?>

						</td>
					</tr>
					<tr>
						<th class=th id=monthly<?=$year, '-', $month?>>
							<a tabindex=-1 href="./?target=monthly&#38;date=<?=$year, '-', $month?>#fieldset"><?=(int)$month?><small>月</small></a>
						</th>
						<td class=td><?php
							if (isset($monthly_schedule_list)) foreach ($monthly_schedule_list as $lineno => $line)
							{
								list($schedule_date, $schedule, $complete, $color) = explode(',', $line);
								if ($year. '-'. $month === $schedule_date)
								{
									echo '
							<table class=separate>
								<tbody>
									<tr>
										<td',
									match ($color)
									{
										'none' => ' class="dark box schedule square"',
										'white' => ' class="white box schedule square"',
										'blue' => ' class="info box schedule square"',
										'green' => ' class="success box schedule square"',
										'yellow' => ' class="alert box schedule square"',
										'pink' => ' class="error box schedule square"',
									}, '>', (trim($complete) === 'complete' ? '<del>'. $schedule. '</del>' : $schedule), '</td>';

									if (trim($complete) === 'complete')
										echo '
										<td class="button green square" onclick="l(this.firstElementChild)">
											<a tabindex=1 href="./?target=monthly&#38;lineno=', $lineno, '&#38;date=', $get_date, '&#38;mode=complete"><i class=icon-check></i>完了</a>
										</td>';
									else
										echo '
										<td class="button orange square" onclick="l(this.firstElementChild)">
											<a tabindex=1 href="./?target=monthly&#38;lineno=', $lineno, '&#38;date=', $get_date, '&#38;mode=incomplete"><i class=icon-check-empty></i>未完</a>
										</td>';
									echo '
										<td class="button blue square" onclick="l(this.firstElementChild)">
											<a tabindex=1 href="./?target=monthly&#38;lineno=', $lineno, '&#38;date=', $get_date, '&#38;mode=edit#fieldset"><i class=icon-edit></i>編集</a>
										</td>
										<td class="button red square" onclick="if(!confirm(\'削除しますか?\'))return false;l(this.firstElementChild)">
											<a tabindex=1 href="./?target=monthly&#38;lineno='.$lineno.'&#38;date=', $get_date, '&#38;mode=delete"><i class=icon-trash></i>削除</a>
										</td>
									</tr>
								</tbody>
							</table>';
								}
							}
							?>

						</td>
					</tr><?php
					for ($d = $first_day; $d <= $last_day; ++$d)
					{
						$days = sprintf('%02d', $d);
						$day_timestamp = "$year-$month-$days";
						$datetime = new DateTime($day_timestamp);
						echo '
					<tr id="daily', $day_timestamp, '"', ($today === $day_timestamp ? ' class=asphalt-bg' : ''), '>
						<th class=th>', ($today <= $day_timestamp ? '
							<a tabindex=-1 href="./?target=daily&#38;date='. $day_timestamp. '#fieldset">'. $d. '<small>日（'. $week[$datetime->format('w')]. '）</small></a>' : '
							<span>'. $d. '<small>日（'. $week[$datetime->format('w')]. '）</small></span>'), '
						</th>
						<td class=td>';

						if (isset($daily_schedule_list)) foreach ($daily_schedule_list as $lineno => $line)
						{
							list($schedule_date, $schedule, $complete, $color) = explode(',', $line);
							if ($schedule_date === $day_timestamp)
							{
								echo '
							<table class=separate>
								<tbody>
									<tr>
										<td',
								match ($color)
								{
									'none' => ' class="dark box schedule square"',
									'white' => ' class="white box schedule square"',
									'blue' => ' class="info box schedule square"',
									'green' => ' class="success box schedule square"',
									'yellow' => ' class="alert box schedule square"',
									'pink' => ' class="error box schedule square"',
								}, '>', (trim($complete) === 'complete' ? '<del>'. $schedule. '</del>' : $schedule), '</td>';

								if (trim($complete) === 'complete')
									echo '
										<td class="button green square" onclick="l(this.firstElementChild)">
											<a tabindex=1 href="./?target=daily&#38;lineno=', $lineno, '&#38;date=', $day_timestamp, '&#38;mode=complete"><i class=icon-check></i>完了</a>
										</td>';
								else
									echo '
										<td class="button orange square" onclick="l(this.firstElementChild)">
											<a tabindex=1 href="./?target=daily&#38;lineno=', $lineno, '&#38;date=', $day_timestamp, '&#38;mode=incomplete"><i class=icon-check-empty></i>未完</a>
										</td>';echo '
										<td class="button blue square" onclick="l(this.firstElementChild)">
											<a tabindex=1 href="./?target=daily&#38;lineno=', $lineno, '&#38;date=', $day_timestamp, '&#38;mode=edit#fieldset"><i class=icon-edit></i>編集</a>
										</td>
										<td class="button red square" onclick="if(!confirm(\'削除しますか?\'))return false;l(this.firstElementChild)">
											<a tabindex=1 href="./?target=daily&#38;lineno=', $lineno, '&#38;date=', $day_timestamp, '&#38;mode=delete"><i class=icon-trash></i>削除</a>
										</td>
									</tr>
								</tbody>
							</table>';
							}
						}
						echo '
						</td>
					</tr>';
					}
					?>

					<tr>
						<td colspan=2 class=white>
							<h1 class="align-center gap-top medium">達成率</h1>
							<table id=rate>
								<tbody>
									<tr>
										<th id=gauge><span style="top:-5px">100%</span><span style="top:41%">50%</span><span style="bottom:-5px">0%</span></th>
										<td><span class="museo-slab graph" data-tooltip="<?=$yearly_complete?>%"><span class=bar style="height:<?=$yearly_complete?>%"></span></span></td>
										<td><span class="museo-slab graph" data-tooltip="<?=$monthly_complete?>%"><span class=bar style="height:<?=$monthly_complete?>%"></span></span></td>
										<td><span class="museo-slab graph" data-tooltip="<?=$daily_complete?>%"><span class=bar style="height:<?=$daily_complete?>%"></span></span></td>
									</tr>
									<tr id=th>
										<th></th>
										<th class=align-center>年</th>
										<th class=align-center>月</th>
										<th class=align-center>日</th>
									</tr>
								</tbody>
							</table>
						</td>
					</tr>
				</tbody>
			</table>
		</main>
		<a tabindex=-1 href=#TOP id=top class=hidden onclick="w.scrollTo(0,0);return false"><i class=icon-double-angle-up></i></a>
		<script>var d=document,w=window;if(w.scrollY>250){d.getElementById('top').setAttribute('class','animated bounceInUp noicon page-top')}w.onscroll=function(){y=w.scrollY;if(y>250){d.getElementById('top').setAttribute('class','animated bounceInUp noicon page-top')}else if(y===0){d.getElementById('top').setAttribute('class','animated bounceOutDown noicon page-top')}};function l(x){w.location=x.getAttribute('href')}function c(c,b){d.getElementById('schedule').style.cssText='color:'+c+';background-color:'+b}function b(mx,mn,tp,vl,ph,tg){d.getElementById('date').setAttribute('max',mx);d.getElementById('date').setAttribute('min',mn);d.getElementById('date').setAttribute('type',tp);d.getElementById('date').setAttribute('value',vl);d.getElementById('schedule').setAttribute('placeholder',ph+'の予定');d.getElementById('target').setAttribute('value',tg)}</script>
	</body>
</html>
