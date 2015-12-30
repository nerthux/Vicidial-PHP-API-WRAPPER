<?php
/*
*  Author: Gabriel Covarrubias <gcovarrubias@c4-technologies.com>
*
*  Descripton:  This is a class intended to be used as a wrapper for the Vicidial AGENT API
*	        for more information about the Vicidial AGENT API visit http://vicidial.org/docs/AGENT_API.txt
*
*  creation date: 2015-1-30
*
*  version: 0.1
*
*  license: GNU AFFERO GENERAL PUBLIC LICENSE Version 3
*
*  VICIdial is a registered trademark of the Vicidial Group which i am not related in anyway.
*   
*/

class VicidialAgentAPI {

	private $server_ip;
	private $source;
	private $api_user;
	private $api_password;
	private $base_url;


	/**
	 * Initializes the object with the basic information to create the base_url
	 */
	public function __construct($server_ip, $source, $api_user, $api_password){

		$this->server_ip = $server_ip;
		$this->source = $source;
                $this->api_user = $api_user;
                $this->api_password = $api_password;
		
		$this->base_url = "http://" . $this->server_ip . "/agc/api.php?";

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

                $curl = curl_init();
                curl_setopt_array( $curl, array (
                        CURLOPT_URL => $url,
                        CURLOPT_HEADER => false,
                        CURLOPT_RETURNTRANSFER => true )
                );

		// Store the response from the Web method
                $response = curl_exec($curl);
                curl_close($curl);

                return $response;
        }


	/**
	 * Creates the URL for  the external_hangup method and calls 'call_api_url' to execute it
	 */
	public function hangup($agent_user)
	{
		$url_parameters['agent_user'] = $agent_user;
                $url_parameters['function'] = "external_hangup";
                $url_parameters['value'] = "1";

		
		$url_query = http_build_query($url_parameters);

		$url = $this->base_url ."&". $url_query;


		return $this->call_api_url($url);	
	}


        /**
         * Creates the URL for  the external_status method and calls 'call_api_url' to execute it
         */
        public function dispo($agent_user, $status)
        {
                $url_parameters['agent_user'] = $agent_user;
                $url_parameters['function'] = "external_status";
                $url_parameters['value'] = $status;


                $url_query = http_build_query($url_parameters);

                $url = $this->base_url ."&". $url_query;


                return $this->call_api_url($url);
        }


        /**
         * Creates the URL for  the external_puse method and calls 'call_api_url' to execute it
         */
        public function pause($agent_user, $status)
        {
                $url_parameters['agent_user'] = $agent_user;
                $url_parameters['function'] = "external_pause";
                $url_parameters['value'] = $status;


                $url_query = http_build_query($url_parameters);

                $url = $this->base_url ."&". $url_query;


                return $this->call_api_url($url);
        }

        /**
         * Creates the URL for the webserver method and calls 'call_api_url' to execute it
         */

        public function webserver()
        {
                $url_parameters['function'] = "webserver";


                $url_query = http_build_query($url_parameters);

                $url = $this->base_url ."&". $url_query;


                return $this->call_api_url($url);
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
         * Creates the URL for the logout method and calls 'call_api_url' to execute it
         */

        public function logout($agent_user)
        {
                $url_parameters['agent_user'] = $agent_user;
                $url_parameters['function'] = "logout";
                $url_parameters['value'] = "LOGOUT";


                $url_query = http_build_query($url_parameters);

                $url = $this->base_url ."&". $url_query;


                return $this->call_api_url($url);
        }


        /**
         * Creates the URL for  the external_dial method and calls 'call_api_url' to execute it
	 *
	 * TODO: This method has additional parameters, the current code only supports basic dialing
         */

        public function dial($agent_user, $phone_number, $phone_code)
        {
                $url_parameters['agent_user'] = $agent_user;
                $url_parameters['function'] = "external_dial";
                $url_parameters['value'] = $phone_number;
                $url_parameters['phone_code'] = $phone_code;
                $url_parameters['search'] = "YES";
		$url_parameters['preview'] = "NO";
                $url_parameters['focus'] = "YES";


                $url_query = http_build_query($url_parameters);

                $url = $this->base_url ."&". $url_query;


                return $this->call_api_url($url);
        }
}

?>
