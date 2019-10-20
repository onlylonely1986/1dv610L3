<?php

namespace view;

class DateTimeView {

	private static $day;
	private static $date;
	private static $monthName;
	private static $year;
	private static $time;
	private static $timeStr;

	public function __construct() {
		date_default_timezone_set("Europe/Stockholm");
		self::$day = Date("l");
		self::$date = Date("dS");
		self::$monthName = Date("F");
		self::$year = Date("20y");
		self::$time = Date("H:i:s");
	}

	public function echoHTML() {
		self::$timeStr = self::$day . ", the "
							 . self::$date . " of " . self::$monthName . " " 
								. self::$year . ", The time is " . self::$time;
		return '<p>' . self::$timeStr . '</p>';
	}
}