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
* Description can be found here: http://tech.epay.dk/da/betalingswebservice
**/
class Payment {

	private $client;
	private $url = "https://ssl.ditonlinebetalingssystem.dk/remote/payment.asmx";

	public function __construct($trace = 0){
		$this->client = new SoapClient(null, array(
			'soap_version' => SOAP_1_2,
			'location' => $this->url,
			'uri' => 'https://ssl.ditonlinebetalingssystem.dk/remote/payment',
			'trace' => $trace,

		));
	}

	public function capture($merchantnumber, $transactionid, $amount, $group = null, $pwd = null) {
		$args = array(
			new SoapParam(new SoapVar($merchantnumber, XSD_INT), 'ns1:merchantnumber'),
			new SoapParam(new SoapVar($transactionid, XSD_LONG), 'ns1:transactionid'),
			new SoapParam(new SoapVar($amount, XSD_INT), 'ns1:amount')
		);
		if ($group != null)
			$args[] = new SoapParam(new SoapVar($group, XSD_STRING), 'ns1:group');
		if ($pwd != null)
			$args[] = new SoapParam(new SoapVar($pwd, XSD_STRING), 'ns1:pwd');

		try {
			return  $this->client->__soapCall("capture",$args);
		} catch(Exception $e){
			return null;
		}
	}

	public function credit($merchantnumber, $transactionid, $amount, $group = null, $pwd = null) {
		$args = array(
			new SoapParam(new SoapVar($merchantnumber, XSD_INT), 'ns1:merchantnumber'),
			new SoapParam(new SoapVar($transactionid, XSD_LONG), 'ns1:transactionid'),
			new SoapParam(new SoapVar($amount, XSD_INT), 'ns1:amount')
		);
		if ($group != null)
			$args[] = new SoapParam(new SoapVar($group, XSD_STRING), 'ns1:group');
		if ($pwd != null)
			$args[] = new SoapParam(new SoapVar($pwd, XSD_STRING), 'ns1:pwd');
		try {
			return $this->client->__soapCall("credit",$args);
		} catch(Exception $e){
			return null;
		}
	}

	public function delete($merchantnumber, $transactionid, $group = null, $pwd = null) {
		$args = array(
			new SoapParam(new SoapVar($merchantnumber, XSD_INT), 'ns1:merchantnumber'),
			new SoapParam(new SoapVar($transactionid, XSD_LONG), 'ns1:transactionid')
		);
		if ($group != null)
			$args[] = new SoapParam(new SoapVar($group, XSD_STRING), 'ns1:group');
		if ($pwd != null)
			$args[] = new SoapParam(new SoapVar($pwd, XSD_STRING), 'ns1:pwd');
		try {
			return $this->client->__soapCall("delete",$args);
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

	public function getcardtype($merchantnumber, $cardnumber) {
		$args = array(
			new SoapParam(new SoapVar($merchantnumber, XSD_INT), 'ns1:merchantnumber'),
			new SoapParam(new SoapVar($cardnumber, XSD_STRING), 'ns1:cardnumber')
		);
		try {
			return $this->client->__soapCall("getcardtype",$args);
		} catch(Exception $e){
			return null;
		}
	}

	public function gettransaction($merchantnumber, $transactionid, $pwd = null) {
		$args = array(
			new SoapParam(new SoapVar($merchantnumber, XSD_INT), 'ns1:merchantnumber'),
			new SoapParam(new SoapVar($transactionid, XSD_LONG), 'ns1:transactionid')
		);
		if ($pwd != null)
			$args[] = new SoapParam(new SoapVar($pwd, XSD_STRING), 'ns1:pwd');
		try {
			return $this->client->__soapCall("gettransaction",$args);
		} catch(Exception $e){
			return null;
		}
	}

	public function gettransactionlist($merchantnumber, $status = null, $searchdatestart = null, $searchdateend = null, $searchgroup = null, $searchorderid = null, $pwd = null) {
		$args = array(
			new SoapParam(new SoapVar($merchantnumber, XSD_INT), 'ns1:merchantnumber')
		);
		if ($status != null)
			$args[] = new SoapParam(new SoapVar($status, XSD_INT), 'ns1:status');
		if ($searchdatestart != null)
			$args[] = new SoapParam(new SoapVar($searchdatestart, XSD_DATETIME), 'ns1:searchdatestart');
		if ($searchdateend != null)
			$args[] = new SoapParam(new SoapVar($searchdateend, XSD_DATETIME), 'ns1:searchdateend');
		if ($searchgroup != null)
			$args[] = new SoapParam(new SoapVar($searchgroup, XSD_STRING), 'ns1:searchgroup');
		if ($searchorderid != null)
			$args[] = new SoapParam(new SoapVar($searchorderid, XSD_STRING), 'ns1:searchorderid');
		if ($pwd != null)
			$args[] = new SoapParam(new SoapVar($pwd, XSD_STRING), 'ns1:pwd');
		try {
			return $this->client->__soapCall("gettransactionlist",$args);
		} catch(Exception $e){
			return null;
		}
	}


	public function getcardinfo($merchantnumber, $cardno_prefix, $amount, $currency, $acquirer) {
		$args = array(
			new SoapParam(new SoapVar($merchantnumber, XSD_INT), 'ns1:merchantnumber'),
			new SoapParam(new SoapVar($cardno_prefix, XSD_INT), 'ns1:cardno_prefix'),
			new SoapParam(new SoapVar($amount, XSD_INT), 'ns1:amount'),
			new SoapParam(new SoapVar($currency, XSD_INT), 'ns1:currency'),
			new SoapParam(new SoapVar($acquirer, XSD_INT), 'ns1:acquirer')
		);
		try {
			return $this->client->__soapCall("getcardinfo",$args);
		} catch(Exception $e){
			return null;
		}
	}
}

$client = new \Epay\Payment(1);
print_r($client->getcardinfo(8014369, 000012, 12575, 208, 3));


?>