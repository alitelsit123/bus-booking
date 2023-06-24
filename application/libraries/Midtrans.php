<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH . 'third_party/midtrans-php-master/Midtrans.php');

class Midtrans {

    private $clientKey;
    private $serverKey;

		public $getStatus;

    public function __construct()
    {
        $this->clientKey = 'SB-Mid-client-86RRXTySbEI4j9Ls';
        $this->serverKey = 'SB-Mid-server-Dn1FPy5blpoQMzVpNSx2o1Mv';
        \Midtrans\Config::$clientKey = $this->clientKey;
        \Midtrans\Config::$serverKey = $this->serverKey;
        \Midtrans\Config::$isProduction = false; // Set to true for production environment

        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;
    }

    public function getSnapToken($params)
    {
        \Midtrans\Config::$serverKey = $this->serverKey;
        return \Midtrans\Snap::getSnapToken($params);
    }

		public function getStatus($id) {
			return \Midtrans\Transaction::status($id);
		}
}
