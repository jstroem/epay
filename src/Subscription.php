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

	private $client;
	private $url = "https://ssl.ditonlinebetalingssystem.dk/remote/subscription/authorize.asmx";

	public function __construct($trace = 0){
		$this->client = new SoapClient(null, array(
			'soap_version' => SOAP_1_2,
			'location' => $this->url,
			'uri' => 'https://ssl.ditonlinebetalingssystem.dk/remote/subscription/authorize',
			'trace' => $trace,

		));
	}

	public function authorize($merchantnumber, $subscriptionid, $orderid, $amount, $currency, $instantcapture = 0, $group = null, $description = null, $email = null, $sms = null, $ipaddress = null, $pwd = null) {
		$args = array(
			new SoapParam(new SoapVar($merchantnumber, XSD_INT), 'ns1:merchantnumber'),
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
			return  $this->client->__soapCall("authorize",$args);
		} catch(Exception $e){
			return null;
		}
	}

	public function deletesubscription($merchantnumber, $subscriptionid, $pwd = null) {
		$args = array(
			new SoapParam(new SoapVar($merchantnumber, XSD_INT), 'ns1:merchantnumber'),
			new SoapParam(new SoapVar($subscriptionid, XSD_LONG), 'ns1:subscriptionid')
		);
		if ($pwd != null)
			$args[] = new SoapParam(new SoapVar($pwd, XSD_STRING), 'ns1:pwd');
		try {
			return $this->client->__soapCall("deletesubscription",$args);
		} catch(Exception $e){
			return null;
		}
	}

	public function getEpayError($merchantnumber, $language, $epayresponsecode = null, $pwd = null) {
		$args = array(
			new SoapParam(new SoapVar($merchantnumber, XSD_INT), 'ns1:merchantnumber'),
			new SoapParam(new SoapVar($language, XSD_INT), 'ns1:language')
		);
		if ($pwd != null)
			$args[] = new SoapParam(new SoapVar($pwd, XSD_STRING), 'ns1:pwd');
		if ($epayresponsecode != null)
			$args[] = new SoapParam(new SoapVar($epayresponsecode, XSD_STRING), 'ns1:epayresponsecode');

		try {
			return $this->client->__soapCall("getEpayError",$args);
		} catch(Exception $e){
			return null;
		}
	}

	public function getPbsError($merchantnumber, $language, $pbsresponsecode = null, $pwd = null) {
		$args = array(
			new SoapParam(new SoapVar($merchantnumber, XSD_INT), 'ns1:merchantnumber'),
			new SoapParam(new SoapVar($language, XSD_INT), 'ns1:language')
		);
		if ($pwd != null)
			$args[] = new SoapParam(new SoapVar($pwd, XSD_STRING), 'ns1:pwd');
		if ($pbsresponsecode != null)
			$args[] = new SoapParam(new SoapVar($pbsresponsecode, XSD_INT), 'ns1:pbsresponsecode');

		try {
			return $this->client->__soapCall("getPbsError",$args);
		} catch(Exception $e){
			return null;
		}
	}


	public function getsubscriptions($merchantnumber, $subscriptionid, $pwd = null) {
		$args = array(
			new SoapParam(new SoapVar($merchantnumber, XSD_INT), 'ns1:merchantnumber'),
			new SoapParam(new SoapVar($subscriptionid, XSD_INT), 'ns1:subscriptionid')
		);
		if ($pwd != null)
			$args[] = new SoapParam(new SoapVar($pwd, XSD_STRING), 'ns1:pwd');

		try {
			return $this->client->__soapCall("getsubscriptions",$args);
		} catch(Exception $e){
			return null;
		}
	}
}

$client = new \Epay\Payment(1);
print_r($client->getcardinfo(8014369, 000012, 12575, 208, 3));


?>