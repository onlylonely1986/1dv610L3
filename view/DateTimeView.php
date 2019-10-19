<?php

namespace view;

class DateTimeView {

	private $day;
	private $date;
	private $monthName;
	private $year;
	private $time;
	private $timeStr = "";

	public function __construct() {
		date_default_timezone_set("Europe/Stockholm");
		$this->day = Date("l");
		$this->date = Date("dS");
		$this->monthName = Date("F");
		$this->year = Date("20y");
		$this->time = Date("H:i:s");
	}

	public function echoHTML() {
		$this->timeStr = $this->day . ", the " . $this->date . " of " . $this->monthName . " " 
			. $this->year . ", The time is " . $this->time;
		return '<p>' . $this->timeStr . '</p>';
	}
}