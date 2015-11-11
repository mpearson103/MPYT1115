<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use SimpleXMLElement;
use Carbon\Carbon;

class GetDomainsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:get-domains';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pulls the top 500 global websites from Alexa and inserts the domains with their ranks into the database.';

	/**
	 * Query parameters for the API request.
	 */
	protected static $ActionName        = 'TopSites';
    protected static $ResponseGroupName = 'Country';
    protected static $ServiceHost		= 'ats.amazonaws.com';
    protected static $NumReturn         = 100;
    protected static $SigVersion        = '2';
    protected static $HashAlgorithm     = 'HmacSHA256';
	protected static $accessKeyId		= '';
	protected static $secretAccessKey	= '';
	protected static $countryCode		= '';
	protected $StartNum					= 1;

	/**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
		$domainsArray = [];

		for ($i = 0; $i <= 4; $i++) {
			$domainsArray = $this->getTopSites($domainsArray);
			$this->StartNum = $this->StartNum + 100;
		}

		self::insertDomains($domainsArray);
    }

    /**
     * Get top sites from ATS
	 *
	 * @param array $domainsArray    master array with all domains
	 * @return array                 aggregated domains array
     */
    protected function getTopSites($domainsArray) {
        $queryParams = $this->buildQueryParams();
        $sig = $this->generateSignature($queryParams);
        $url = 'http://' . self::$ServiceHost . '/?' . $queryParams .
            '&Signature=' . $sig;
        $ret = self::makeRequest($url);
		$returnedArray = self::parseResponse($ret, $domainsArray);

		return $returnedArray;
    }

    /**
     * Builds an ISO 8601 timestamp for request
	 *
	 * @return string    ISO 8601 formatted string
     */
    protected static function getTimestamp() {
		return Carbon::now()->toIso8601String();
    }

    /**
     * Builds the url for the request to ATS
     * The url will be urlencoded as per RFC 3986 and the uri params
     * will be in alphabetical order
	 *
	 * @return string    url encoded query parameters
     */
    protected function buildQueryParams() {
        $params = array(
            'Action'            => self::$ActionName,
            'ResponseGroup'     => self::$ResponseGroupName,
            'AWSAccessKeyId'    => self::$accessKeyId,
            'Timestamp'         => self::getTimestamp(),
            'CountryCode'       => self::$countryCode,
            'Count'             => self::$NumReturn,
            'Start'             => $this->StartNum,
            'SignatureVersion'  => self::$SigVersion,
            'SignatureMethod'   => self::$HashAlgorithm
        );
        ksort($params);
        $keyvalue = array();
        foreach($params as $k => $v) {
            $keyvalue[] = $k . '=' . rawurlencode($v);
        }
        return implode('&',$keyvalue);
    }

    /**
     * Makes an http request
     *
     * @param string $url    URL to make request to
     * @return string        Result of request
     */
    protected static function makeRequest($url) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 4);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

	/**
     * Parses the XML response from ATS and adds each domain into
	 * the $domainsArray for later use
     *
     * @param string $response       xml response from ATS
	 * @param array $domainsArray    master array with all domains
	 * @return array                 aggregated array of domains
     */
    protected function parseResponse($response, $domainsArray) {
		$time = Carbon::now()->toDateTimeString();

        $xml = new SimpleXMLElement($response,null, false,
                                    'http://ats.amazonaws.com/doc/2005-11-21');

        foreach($xml->Response->TopSitesResult->Alexa->TopSites->Country->Sites->children('http://ats.amazonaws.com/doc/2005-11-21') as $site) {
			array_push($domainsArray, ["domain" => "$site->DataUrl", "rank" => "" .
				$site->Country->Rank. "", "created_at" => $time]);
        }

		return $domainsArray;
    }

	/**
	 * Inserts all domains and their rankings into the
	 * domains table
	 *
	 * @param array $domainsArray    master array with all domains
	 */
	protected function insertDomains($domainsArray) {
		DB::table('domains')->insert($domainsArray);
	}

    /**
     * Generates a signature per RFC 2104
     *
     * @param string $queryParams    query parameters to use in creating signature
     * @return string                signature
     */
    protected function generateSignature($queryParams) {
        $sign = "GET\n" . strtolower(self::$ServiceHost) . "\n/\n". $queryParams;
        $sig = base64_encode(hash_hmac('sha256', $sign, self::$secretAccessKey, true));
        return rawurlencode($sig);
    }
}
