<?php
/*
*  Author: Gabriel Covarrubias <gcovarrubias@c4-technologies.com>
*
*  Descripton:  This is a class intended to be used as a wrapper for the Vicidial AGENT API
*	        for more information about the Vicidial AGENT API visit http://vicidial.org/docs/AGENT_API.txt
*
*  creation date: 2022-08-06
*
*  version: 0.1
*
*  license: GNU AFFERO GENERAL PUBLIC LICENSE Version 3
*
*  VICIdial is a registered trademark of the Vicidial Group which i am not related in anyway.
*  
*  TODO: -Add all the functions available in the AGENT API
*        -Add validations to all methods
*	 -Improve inline documentation 
*
*/

class VicidialNonAgentAPI {

  private $server_ip;
  private $source;
  private $api_user;
  private $api_password;
  private $base_url;
  private $debug;

  /**
   * Initializes the object with the basic information to create the base_url
   *
   */
  public function __construct($server_ip, $source, $api_user, $api_password, $debug = false)
  {
    // Validates if valid IP or resolv hostname WARNING: Not fully tested !!
    if (( filter_var($server_ip, FILTER_VALIDATE_IP ) === false) && ( filter_var(gethostbyname($server_ip), FILTER_VALIDATE_IP) === false ))
      throw new Exception('Invalid IP Address or hostname not found');

    $this->server_ip = urlencode($server_ip);
    $this->source = urlencode($source);
    $this->api_user = urlencode($api_user);
    $this->api_password = urlencode($api_password);
    $this->debug = $debug;

    $this->base_url = "https://" . $this->server_ip . "/vicidial/non_agent_api.php?";

    $url_parameters['source'] = $this->source;
    $url_parameters['user'] = $this->api_user;
    $url_parameters['pass'] = $this->api_password;

    $url_query = http_build_query($url_parameters);

    $this->base_url .= $url_query;
  }

  /**
    * It uses cURL to consume a web resource via GET given an URL
    */
  private function call_api_url($url)
  {
    if ( filter_var(urldecode($url), FILTER_VALIDATE_URL, FILTER_FLAG_QUERY_REQUIRED) === false ) 
      throw new Exception("URL may contain malicious code: $url");

    if ($this->debug) {
      echo $url . "\n\n";
      echo urldecode($url) . "\n\n";
    }

    $curl = curl_init();
    curl_setopt_array( $curl, array (
      CURLOPT_URL => $url,
      CURLOPT_HEADER => false,
      CURLOPT_CONNECTTIMEOUT => 5,
      CURLOPT_FAILONERROR => true,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_SSL_VERIFYPEER => false )    // Disabled SSL Cert checks
    );

    // Store the response from the Web method
    $response = curl_exec($curl);
    $curl_error =  curl_error($curl);

    if($curl_error)
      throw new Exception("cURL $curl_error");

    curl_close($curl);

    return $response;
  }

  /**
   * Creates the URL for the version method and calls 'call_api_url' to execute it
   */

  public function version()
  {
    $url_parameters['function'] = "version";

    $url_query = http_build_query($url_parameters);

    $url = $this->base_url ."&". $url_query;

    return $this->call_api_url($url);
  }


   /**
    * Creates the URL for  the add_list method and calls 'call_api_url' to execute it
    */

  public function add_list($list_id, $list_name, $campaign_id)
  {
    $url_parameters['list_id'] = urlencode(trim($list_id));
    $url_parameters['list_name'] = urlencode(trim($list_name));
    $url_parameters['campaign_id'] = urlencode(trim($campaign_id));
    $url_parameters['function'] = "add_list";
    $url_parameters['active'] = "Y";

    $url_query = http_build_query($url_parameters);

    $url = $this->base_url ."&". $url_query;

    return $this->call_api_url($url);
  }

   /**
    * Creates the URL for  the add_lead method and calls 'call_api_url' to execute it
    */

  public function add_lead($phone_number, $phone_code, $list_id, $vendor_lead_code, $first_name, $owner)
  {
    $url_parameters['list_id'] = urlencode(trim($list_id));
    $url_parameters['phone_number'] = urlencode(trim($phone_number));
    $url_parameters['phone_code'] = urlencode(trim($phone_code));
    $url_parameters['vendor_lead_code'] = urlencode(trim($vendor_lead_code,));
    $url_parameters['first_name,'] = urlencode(trim($first_name,));
    $url_parameters['owner'] = urlencode(trim($owner));
    $url_parameters['function'] = "add_lead";

    $url_query = http_build_query($url_parameters);

    $url = $this->base_url ."&". $url_query;

    return $this->call_api_url($url);
  }


}
