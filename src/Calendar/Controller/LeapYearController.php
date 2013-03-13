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
			$response = new Response('Si, este es año bisiesto!');
		}else {
			$response = new Response('No, este no es un año bisiesto');
		}
		
		$response->setTtl(10);

		return $response;
	}
}