<?php

namespace Calendar\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Calendar\Model\LeapYear;


class LeapYearController
{
	public function indexAction(Request $request, $year)
	{
		$leapyear = new LeapYear();
		if($leapyear->isLeapYear($year)){
			return 'Si, este es año bisiesto!';
		}
		return 'No, este no es un año bisiesto';
	}
}