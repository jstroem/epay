<?php
/**
* @author: Jesper Lindstrøm Nielsen <me@jstroem.com>
**/
namespace Epay;

use \SoapClient;
use \SoapParam;
use \SoapVar;
use \Exception;

/**
* Description can be found here: http://tech.epay.dk/da/subscription-web-service
**/
class Subscription {

	private $merchantnumber;
	private $client;
	private $url = "https://ssl.ditonlinebetalingssystem.dk/remote/subscription.asmx";

	public function __construct($merchantnumber, $trace = 0){
		$this->merchantnumber = $merchantnumber;

		$this->client = new SoapClient(null, array(
			'soap_version' => SOAP_1_2,
			'location' => $this->url,
			'uri' => 'https://ssl.ditonlinebetalingssystem.dk/remote/subscription',
			'trace' => $trace,
		));
	}

	public function call($method, $args){
		return $this->client->__soapCall($method, $args);
	}

	public function authorize($subscriptionid, $orderid, $amount, $currency, $instantcapture = 0, $group = null, $description = null, $email = null, $sms = null, $ipaddress = null, $pwd = null) {
		$args = array(
			new SoapParam(new SoapVar($this->merchantnumber, XSD_INT), 'ns1:merchantnumber'),
			new SoapParam(new SoapVar($subscriptionid, XSD_LONG), 'ns1:subscriptionid'),
			new SoapParam(new SoapVar($orderid, XSD_STRING), 'ns1:orderid'),
			new SoapParam(new SoapVar($amount, XSD_INT), 'ns1:amount'),
			new SoapParam(new SoapVar($currency, XSD_STRING), 'ns1:currency'),
			new SoapParam(new SoapVar($instantcapture, XSD_INT), 'ns1:instantcapture')
		);
		if ($group != null)
			$args[] = new SoapParam(new SoapVar($group, XSD_STRING), 'ns1:group');
		if ($description != null)
			$args[] = new SoapParam(new SoapVar($description, XSD_STRING), 'ns1:description');
		if ($email != null)
			$args[] = new SoapParam(new SoapVar($email, XSD_STRING), 'ns1:email');
		if ($sms != null)
			$args[] = new SoapParam(new SoapVar($sms, XSD_STRING), 'ns1:sms');
		if ($ipaddress != null)
			$args[] = new SoapParam(new SoapVar($ipaddress, XSD_STRING), 'ns1:ipaddress');
		if ($pwd != null)
			$args[] = new SoapParam(new SoapVar($pwd, XSD_STRING), 'ns1:pwd');

		try {
			return  $this->call("authorize",$args);
		} catch(Exception $e){
			return null;
		}
	}

	public function deletesubscription($subscriptionid, $pwd = null) {
		$args = array(
			new SoapParam(new SoapVar($this->merchantnumber, XSD_INT), 'ns1:merchantnumber'),
			new SoapParam(new SoapVar($subscriptionid, XSD_LONG), 'ns1:subscriptionid')
		);
		if ($pwd != null)
			$args[] = new SoapParam(new SoapVar($pwd, XSD_STRING), 'ns1:pwd');
		try {
			return $this->call("deletesubscription",$args);
		} catch(Exception $e){
			return null;
		}
	}

	public function getEpayError($language, $epayresponsecode = null, $pwd = null) {
		$args = array(
			new SoapParam(new SoapVar($this->merchantnumber, XSD_INT), 'ns1:merchantnumber'),
			new SoapParam(new SoapVar($language, XSD_INT), 'ns1:language')
		);
		if ($pwd != null)
			$args[] = new SoapParam(new SoapVar($pwd, XSD_STRING), 'ns1:pwd');
		if ($epayresponsecode != null)
			$args[] = new SoapParam(new SoapVar($epayresponsecode, XSD_STRING), 'ns1:epayresponsecode');

		try {
			return $this->call("getEpayError",$args);
		} catch(Exception $e){
			return null;
		}
	}

	public function getPbsError($language, $pbsresponsecode = null, $pwd = null) {
		$args = array(
			new SoapParam(new SoapVar($this->merchantnumber, XSD_INT), 'ns1:merchantnumber'),
			new SoapParam(new SoapVar($language, XSD_INT), 'ns1:language')
		);
		if ($pwd != null)
			$args[] = new SoapParam(new SoapVar($pwd, XSD_STRING), 'ns1:pwd');
		if ($pbsresponsecode != null)
			$args[] = new SoapParam(new SoapVar($pbsresponsecode, XSD_INT), 'ns1:pbsresponsecode');

		try {
			return $this->call("getPbsError",$args);
		} catch(Exception $e){
			return null;
		}
	}


	public function getsubscriptions($subscriptionid = 0, $pwd = null) {
		$args = array(
			new SoapParam(new SoapVar($this->merchantnumber, XSD_INT), 'ns1:merchantnumber'),
			new SoapParam(new SoapVar($subscriptionid, XSD_INT), 'ns1:subscriptionid')
		);
		if ($pwd != null)
			$args[] = new SoapParam(new SoapVar($pwd, XSD_STRING), 'ns1:pwd');


		try {
			$res = $this->call("getsubscriptions",$args);
			return $res;
		} catch(Exception $e){
			return null;
		}
	}
}
?>