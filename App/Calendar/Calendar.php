<?php


use Carbon\Carbon;
// use Yasumi\Yasumi; //  composer require azuyalabs/yasumi

$dayofweek_array = [
	'sun' => '日',
	'mon' => '月',
	'tue' => '火',
	'wed' => '水',
	'thu' => '木',
	'fri' => '金',
	'sat' => '土',
];

// ---------- 現在の日を取得 ----------
$today = new Carbon('today');
$start_of_month = $today->startOfMonth();
$target_date_GET = new Carbon(s_GET('target_date'));
$target_date = ($target_date_GET) ? $target_date_GET : $start_of_month;

// // ---------- 休みを取得 ----------
// $holidays = Yasumi::create('Japan', $target_date->year, 'ja_JP');

// ---------- 前の月を取得 ----------
$target_date_prev = new Carbon($target_date);
$target_date_prev = $target_date_prev->subMonth();

// ---------- 次の月を取得 ----------
$target_date_next = new Carbon($target_date);
$target_date_next = $target_date_next->addMonth();


// ---------- 月の最初を取得 ----------
$startOfCalendar = Carbon::createFromDate($target_date->year, $target_date->month, 1);
$startOfCalendar_dayOfWeek = $startOfCalendar->dayOfWeek;

for ($i = 0; $i < $startOfCalendar_dayOfWeek; $i++) {
	$startOfCalendar->subDay();
}
?>

<div class="calendarComponent">

	<form class="calendarTitle" action="<?php echo get_permalink(); ?>#eventPostSection" method="GET">
		<button class="calendarTitle__arrow -prev" name="target_date" type="submit" value="<?php echo esc_attr($target_date_prev) ?>">
			←
		</button>

		<?php echo $target_date->format('Y/m'); ?>

		<button class="calendarTitle__arrow -next" name="target_date" type="submit" value="<?php echo esc_attr($target_date_next) ?>">
			→
		</button>
	</form>

	<div class="calendarForm">
		<table class="calendarTable">
			<thead class="calendarTable__thead">
				<tr class="calendarTable__tr">
					<?php
					$week_i = 0;
					foreach ($dayofweek_array as $dayofweekEn => $dayofweekJa) { ?>
						<th class="calendarTable__th <?php echo esc_attr('-dayofweek-' . $week_i) ?>">
							<?php echo esc_html($dayofweekEn) ?>
						</th>
					<?php
						++$week_i;
					} ?>
				</tr>
			</thead>

			<tbody class="calendarTable__tbody">

				<?php
				$d = 0;
				do {
					++$d;
				?>
					<tr class="calendarTable__tr">
						<?php
						$i = 0;
						while ($i < 7) {
							++$i;
							// ---------- 変数 ----------
							$startOfCalendar_month = $startOfCalendar->month;
							$other_month = ($startOfCalendar_month !== $target_date->month) ? '-other-month' : '';
							$today = new Carbon('today');

							// ---------- 特別な日を定義 ----------
							$day_of_week = '-dayofweek-' . $startOfCalendar->dayOfWeek;
							$is_today = ($startOfCalendar == $today) ? '-is-today' : '';
							// $is_holiday = ($holidays->isHoliday($startOfCalendar)) ? '-is-holiday' : '';
						?>
							<td class="calendarTable__td
							<?php echo esc_attr($day_of_week) ?>
							<?php echo esc_attr($is_today) ?>
							<?php echo esc_attr($is_holiday) ?>
							<?php echo esc_attr($other_month) ?>
							">
								<span class="calendarTable__day">
									<?php echo esc_html($startOfCalendar->day) ?>
								</span>
								<br>
							</td>
						<?php
							$startOfCalendar->addDay();
						}
						?>
					</tr>
				<?php
				} while ($startOfCalendar->month == $target_date->month);
				?>
				</tobody>
		</table>
	</div>
</div>
