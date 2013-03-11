<?php

namespace Calendar\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Calendar\Model\LeapYear;


class LeapYearController
{
	public function indexAction($year)
	{
		$leapyear = new LeapYear();
		if($leapyear->isLeapYear($year)){
			return new Response('Si, este es año bisiesto!');
		}
		return new Response('No, este no es un año bisiesto');
	}
}