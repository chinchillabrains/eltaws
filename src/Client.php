<?php namespace Chinchillabrains\Eltaws;

/**
 * Client class for communicating with Elta web services
 */
class Client{

    /**
     * @var string Service location as supplied by ELTA Courier
     */
    private $serviceLocation = 'http://212.205.47.226:9003';
    
    /**
     * @var string SOAP Web service descriptions directory
     */
    private $wsdir = __DIR__ . '/ws/';

    /**
     * Create a new package to send
     * 
     * @param array $packageInfo Fields to send to web service
     * 
     * @return array Web service response
     */
    public function sendPackage( array $packageInfo ): array
    {
        $service = 'CREATEAWB.wsdl';
        
        /* Available fields (details in wc/docs direcotry)
        $packageInfo = array(
            'pel_user_code'      => '9999999',  //test: 9999999
            'pel_user_pass'      => '9999999',  //test: 9999999
            'pel_apost_code'     => '999999999', //test: 999999999
            'pel_apost_sub_code' => '',
            'pel_user_lang'      => '',
            'pel_paral_name'     => '',
            'pel_paral_address'  => '',
            'pel_paral_area'     => '',
            'pel_paral_tk'       => '',
            'pel_paral_thl_1'    => '',
            'pel_paral_thl_2'    => '',
            'pel_service'        => '1',
            'pel_temaxia'        => '001',
            'pel_baros'          => '',
            'pel_paral_sxolia'   => '',
            'pel_ant_poso'       => '', // Not available in testing mode
            'pel_sur_1'          => '',
            'pel_sur_2'          => '',
            'pel_sur_3'          => '',
            'pel_ant_poso1'      => '',
            'pel_ant_poso2'      => '',
            'pel_ant_poso3'      => '',
            'pel_ant_poso4'      => '',
            'pel_ant_date1'      => '',
            'pel_ant_date2'      => '',
            'pel_ant_date3'      => '',
            'pel_ant_date4'      => '',
            'pel_asf_poso'       => '',
            'pel_ref_no'         => ''
        );
        */
        return $this->sendRequest( $service, $packageInfo );
    }

    /**
     * Get printable label for a package
     * 
     * @param array $packageInfo Fields to send to web service
     * 
     * @return array Web service response
     */
    public function getLabel( array $packageInfo ): array
    {
        $service = 'PELB64VG.wsdl';

        /* Available fields (details in wc/docs direcotry)
        $packageInfo = array(
            'pel_code'     => '',
            'wpel_user'    => '',
            'wpel_pass'    => '',
            'wpel_vg'      => '',
            'paper_size'   => 1, 0 = Label A4, 1 = Label A6, 1 Default
        );
        */
        return $this->sendRequest( $service, $packageInfo );
    }

    /**
     * Get tracking data for a package
     * 
     * @param array $packageInfo Fields to send to web service
     * 
     * @return array Web service response
     */
    public function getTrackingData( array $packageInfo ): array
    {
        $service = 'PELTT01.wsdl';

        /* Available fields (details in wc/docs direcotry)
        $packageInfo = array(
            'wpel_code'   => '',
            'wpel_user'   => '',
            'wpel_pass'   => '',
            'wpel_vg'     => '',
            'wpel_ref'    => '',
            'wpel_flag'   => 1, 1 = Αναζήτηση με Αριθμό Αποστολής, 2 = Αναζήτηση με Reference_No, 1 Default
        );
        */
        return $this->sendRequest( $service, $packageInfo );
    }

    /**
     * Get Elta store that serves the supplied ZIP code
     * 
     * @param string $zip Postal code
     * 
     * @return array Web service response
     */
    public function getStoreByZip( string $zip ): array
    {
        $service = 'PELSTATION.wsdl';
        $reqData = [
            'web_tk' => $zip
        ];
        return $this->sendRequest( $service, $reqData );
    }

    /**
     * Send request to the web service
     * 
     * @param string $service Selected Web service 
     * @param array $requestData Fields to send to web service
     * 
     * @return array Web service response
     */
    private function sendRequest( string $service, array $requestData ): array
    {
        $client = new \SoapClient( 
            $this->wsdir . $service,
            [ 'location' => $this->serviceLocation ] 
        );
        try {
            $res = $client->READ( $requestData );
        } catch ( \SoapFault $e ) {
            error_log( $e );
            $res = [
                'error' => $e
            ];
        }
        return json_decode( json_encode( $res ), true );
    }

}