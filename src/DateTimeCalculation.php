<?php

namespace ApliTax;

/**
 * DateTimeCalculation
 *
 * @author Karel Uhlík, ApliTax s.r.o.
 * @license MIT
 */
class DateTimeCalculation 
{
	/** @var \Datetime */
	private $date;
	
	public function __construct(\DateTime $date = NULL) {
		if (!$date) {
			$date = new \DateTime();
		}
		$this->date = $date;
	}

	/**
	* Calculates first day of quarter
	* 
	* @param DateTime $date
	* @return DateTime
	*/
	public function firstDayOfQuarter() {
		$m = $this->firstMonthOfQuarter();
		return new \DateTime($this->date->format("Y") . "-" . $m . "-01");
	}

	/**
	* Calculates last day of quarter
	* 
	* @param DateTime $date
	* @return DateTime
	*/
	public function lastDayOfQuarter() {
		$m = $this->lastMonthOfQuarter();
		$return = new \DateTime($this->date->format("Y") . "-" . $m . "-01 23:59:59");
		return $return->modify('last day of');
	}
	
	/**
	* Calculates first month of quarter
	* 
	* @param DateTime $date
	* @return int
	*/
	public function firstMonthOfQuarter() {
		$q = $this->quarter($this->date);
		return 1 + ($q - 1) * 3;
	}

	/**
	* Calculates last month of quarter
	* 
	* @param DateTime $date
	* @return int
	*/
	public function lastMonthOfQuarter() {
		$q = $this->quarter($this->date);
		return $q * 3;
	}
	
	/**
	* Calculates quarter from date
	* 
	* @param DateTime $date
	* @return int
	*/
	public function quarter() {
		return floor(($this->date->format("n") - 1) / 3) + 1;
	}
	
	/**
	* Calculates total days in quarter
	* 
	* @param DateTime $date
	* @return int
	*/
	public function daysInQuarter() {
		$d1 = $this->firstDayOfQuarter();
		$d2 = $this->lastDayOfQuarter();
		$period = $d1->diff($d2);
		return $period->format("%a") + 1;
	}

	/**
	* Calculates days passed in quarter
	* 
	* @param DateTime $date
	* @return int
	*/
	public function daysPassedInQuarter() {
		$d1 = $this->firstDayOfQuarter();
		$period = $d1->diff($this->date);
		return $period->format("%a");
	}
	
	public function info() {
		setlocale(LC_ALL, "");
		echo "<pre>";
		echo "Date                   : " . $this->date->format("d.m.Y H:i:s") . "\n";
		echo "Qarter                 : " . $this->quarter() . ".\n";
		echo "First day of quarter   : " . $this->firstDayOfQuarter()->format("d.m.Y") . "\n";
		echo "Last  day of quarter   : " . $this->lastDayOfQuarter()->format("d.m.Y") . "\n";
		echo "First month of quarter : " . $this->firstDayOfQuarter()->format("F") . "\n";
		echo "First month of quarter : " . $this->firstMonthOfQuarter() . "\n";
		echo "Last  month of quarter : " . $this->lastDayOfQuarter()->format("F") . "\n";
		echo "Last  month of quarter : " . $this->lastMonthOfQuarter() . "\n";
		echo "Days in quarter        : " . $this->daysInQuarter() . "\n";
		echo "Days passed in quarter : " . $this->daysPassedInQuarter() . "\n";
		echo "</pre>";
	}
	
}