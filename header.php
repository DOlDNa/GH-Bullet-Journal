<?php
#error_reporting(0);

date_default_timezone_set('Asia/Tokyo');
setlocale(LC_ALL, 'ja_JP.UTF-8');

$limits = 36500;

$complete = 'incomplete';
$color = 'none';
$error_message = $schedule = '';
$y = date('Y');
$m = date('m');
$d = date('d');
$today = "$y-$m-$d";
$maxy = $y+1000;
$get_date = !filter_has_var(INPUT_GET, 'date') ? $today : filter_input(INPUT_GET, 'date', FILTER_CALLBACK, ['options' => 'basename', 'flags' => FILTER_SANITIZE_NUMBER_INT]);

if (substr_count($get_date, '-') === 0)
	$get_date .= '-'. (substr($get_date, 0, 4) === $y ? $m : '01');

$thisday = substr_count($get_date, '-') === 1? $get_date. '-01' : $get_date;
$target = !filter_has_var(INPUT_GET, 'target') ? 'daily' : filter_input(INPUT_GET, 'target', FILTER_CALLBACK, ['options' => 'strip_tags_basename']);
$lineno = !filter_has_var(INPUT_GET, 'lineno') ? '' : filter_input(INPUT_GET, 'lineno', FILTER_CALLBACK, ['options' => 'basename', 'flags' => FILTER_SANITIZE_NUMBER_INT]);
$mode = !filter_has_var(INPUT_GET, 'mode') ? '' : filter_input(INPUT_GET, 'mode', FILTER_CALLBACK, ['options' => 'strip_tags_basename']);
$timestamp = !filter_has_var(INPUT_GET, 'date') ? time() : strtotime($get_date);

$year = date('Y', $timestamp);
$month = date('m', $timestamp);
$day = date('d', $timestamp);

$first_date = new DateTime("first day of $year-$month");
$last_date = new DateTime("last day of $year-$month");

$next_month = new DateTime("first day of next month $year-$month");
$last_month = new DateTime("first day of last month $year-$month");

$next_year = new DateTime("first day of next year $year-01");
$last_year = new DateTime("first day of last year $year-12");

$first_day = $first_date->format('j');
$last_day = $last_date->format('j');

$week = ['日', '月', '火', '水', '木', '金', '土'];

if (!is_dir($dir = './schedules/')) mkdir($dir, 0757);

if ($timestamp === time())
{
	$placeholder = '今日';
	$type = 'type="date" value="'. $get_date. '" min="'. $today. '" max="'. $maxy. '-12-31"';
}
elseif ($target === 'yearly')
{
	$placeholder = date('Y', $timestamp). '年';
	$type = 'type="number" value="'. $year. '" min="'. $y. '" max="'. $maxy. '"';
}
elseif ($target === 'monthly')
{
	$placeholder = (int)date('m', $timestamp). '月';
	$type = 'type="month" value="'. $year. '-'. $month. '" min="'. $y. '-'. $m. '" max="'. $maxy. '-12"';
}
elseif ($target === 'daily')
{
	$placeholder = (int)date('d', $timestamp). '日';
	$type = 'type="date" value="'. $thisday. '" min="'. $today. '" max="'. $maxy. '-12-31"';
}

if (is_file($yearly_filename = $dir. 'yearly.txt'))
{
	$yearly_data = [];
	$yearly_schedule_list = array_values(array_unique(file($yearly_filename)));
	foreach ($yearly_schedule_list as $yearly_line)
		if (strpos($yearly_line, $year) !== false) $yearly_data[] = $yearly_line;
	$yearly_count = count($yearly_data);
	$yearly_complete_count = substr_count(implode($yearly_data), ',complete,');
	$yearly_complete = !$yearly_count ? 0 : number_format($yearly_complete_count/$yearly_count*100);
}
else
{
	file_put_contents($yearly_filename, '');
	$yearly_complete = 0;
}

if (is_file($monthly_filename = $dir. 'monthly.txt'))
{
	$monthly_data = [];
	$monthly_schedule_list = array_values(array_unique(file($monthly_filename)));
	foreach ($monthly_schedule_list as $monthly_line)
		if (strpos($monthly_line, "$year-$month") !== false) $monthly_data[] = $monthly_line;
	$monthly_count = count($monthly_data);
	$monthly_complete_count = substr_count(implode($monthly_data), ',complete,');
	$monthly_complete = !$monthly_count ? 0 : number_format($monthly_complete_count/$monthly_count*100);
}
else
{
	file_put_contents($monthly_filename, '');
	$monthly_complete = 0;
}

if (is_file($daily_filename = $dir. 'daily.txt'))
{
	$daily_data = [];
	$daily_schedule_list = array_values(array_unique(file($daily_filename)));
	foreach ($daily_schedule_list as $daily_line)
		if (strpos($daily_line, "$year-$month") !== false) $daily_data[] = $daily_line;
	$daily_count = count($daily_data);
	$daily_complete_count = substr_count(implode($daily_data), ',complete,');
	$daily_complete = !$daily_count ? 0 : number_format($daily_complete_count/$daily_count*100);
}
else
{
	file_put_contents($daily_filename, '');
	$daily_complete = 0;
}

if (!is_file($htaccess = $dir. '.htaccess'))
{
	file_put_contents($htaccess, 'Order allow,deny'. PHP_EOL. 'Deny from all');
	header('Location: ./');
}

$date = !filter_has_var(INPUT_POST, 'date') ? date('Y-m-d', $timestamp) : filter_input(INPUT_POST, 'date', FILTER_SANITIZE_NUMBER_INT);

if (filter_has_var(INPUT_POST, 'schedule'))
{
	$sanitized = filter_input_array(INPUT_POST, ['color' => ['filter' => FILTER_CALLBACK, 'options' => 'strip_tags_basename'], 'schedule' => FILTER_SANITIZE_SPECIAL_CHARS, 'target' => ['filter' => FILTER_CALLBACK, 'options' => 'strip_tags_basename']]);

	$color = trim($sanitized['color']);

	if ($schedule = trim($sanitized['schedule']))
	{
		$schedule = str_replace(',', '，', $schedule);
		$schedule = str_replace(["\r\n", "\r", "\n"], '&#10;', $schedule);
		$schedule = str_replace(' ', '&nbsp;', $schedule);
		$schedule = str_replace('　', '&emsp;', $schedule);
		$new_line = $date. ','. $schedule. ','. $complete. ','. $color. ','. PHP_EOL;
		$filename = $dir. ($sanitized['target'] === 'daily' ? 'daily' : ''). ($sanitized['target'] === 'monthly' ? 'monthly' : ''). ($sanitized['target'] === 'yearly' ? 'yearly' : ''). '.txt';
		$list = array_values(array_unique(file($filename)));

		if ($mode === 'edit')
		{
			$line = $list[$lineno];
			$dropline = str_replace($line, '', $list);
			file_put_contents($filename, $dropline, LOCK_EX);
		}
		if (count($list) >= $limits)
		{
			$dropfirstline = str_replace($list[0], '', $list);
			file_put_contents($filename, $dropfirstline, LOCK_EX);
		}
		error_log($new_line, 3, $filename);
		header('Location: ./?target='. $sanitized['target']. '&date='. $date. '#'. $sanitized['target']. $date);
	}
}

if ($mode === 'edit')
{
	$list = array_values(array_unique(file($dir. $target. '.txt')));
	if (isset($list[$lineno]))
	{
		list($date, $schedule, $complete, $color) = explode(',', $list[$lineno]);
		$date = intval($date);
	}
	else
		$error_message = 'スケジュールが見つかりませんでした';
}

if ($mode === 'complete')
{
	$file = $dir. $target. '.txt';
	$list = array_values(array_unique(file($file)));
	if (isset($list[$lineno]))
	{
		list($date, $schedule, $complete, $color) = explode(',', $list[$lineno]);
		$incompleteline = str_replace(trim($complete), 'incomplete', $complete);
		$incompletedline = str_replace($list[$lineno], $date. ','. $schedule. ','. $incompleteline. ','. $color. ','. PHP_EOL, $list);
		file_put_contents($file, $incompletedline, LOCK_EX);
		header('Location: ./?target='. $target. '&date='. $get_date. '#'. $target. $date);
	}
	else
		$error_message = 'スケジュールが見つかりませんでした';
}

if ($mode === 'incomplete')
{
	$file = $dir. $target. '.txt';
	$list = array_values(array_unique(file($file)));
	if (isset($list[$lineno]))
	{
		list($date, $schedule, $complete, $color) = explode(',', $list[$lineno]);
		$completeline = str_replace(trim($complete), 'complete', $complete);
		$completedline = str_replace($list[$lineno], $date. ','. $schedule. ','. $completeline. ','. $color. ','. PHP_EOL, $list);
		file_put_contents($file, $completedline, LOCK_EX);
		header('Location: ./?target='. $target. '&date='. $get_date. '#'. $target. $date);
	}
	else
		$error_message = 'スケジュールが見つかりませんでした';
}

if ($mode === 'delete')
{
	$file = $dir. $target. '.txt';
	$list = array_values(array_unique(file($file)));
	if (isset($list[$lineno]))
	{
		$dropline = str_replace($list[$lineno], '', $list);
		file_put_contents($file, $dropline, LOCK_EX);
		header('Location: ./?target='. $target. '&date='. $get_date. '#'. $target. $get_date);
	}
	else
		$error_message = 'スケジュールが見つかりませんでした';
}

function strip_tags_basename($str)
{
	return strip_tags(basename($str));
}
