<?php namespace Chinchillabrains\Eltaws;

class Client{

    private $serviceLocation = 'http://212.205.47.226:9003';
    
    private $wsdir = __DIR__ . '/ws/';

    public function sendPackage( array $packageInfo ): array
    {
        $service = 'CREATEAWB.wsdl';
        return $this->sendRequest( $service, $packageInfo );
    }

    public function getLabel( array $packageInfo ): array
    {
        $service = 'PELB64VG.wsdl';
        return $this->sendRequest( $service, $packageInfo );
    }

    public function getTrackingData( array $packageInfo ): array
    {
        $service = 'PELTT01.wsdl';
        return $this->sendRequest( $service, $packageInfo );
    }

    public function getStoreByZip( string $zip ): array
    {
        $service = 'PELTT01.wsdl';
        $reqData = ['web_tk' => $zip];
        return $this->sendRequest( $service, $reqData );
    }

    private function sendRequest( string $service, array $requestData )
    {
        $client = new SoapClient( 
            $this->wsdir . $service,
            [ 'location' => $this->$serviceLocation ] 
        );
        try {
            return $client->READ( $requestData );
        } catch ( SoapFault $e ) {
            error_log( $e );
            return [
                'error' => $e
            ];
        }
    }

}