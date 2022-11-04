# eltaws
PHP Client for Elta Courier web services

## Attention
In order to connect to ELTA server, your firewall is required to have port 9003 open for TCP OUT connections.
Open port 9003 to IP 212.205.47.226 in your firewall.

## Installation

Install via Composer:

```
composer require chinchillabrains/eltaws
```

Install via GitHub:

```
git clone https://github.com/chinchillabrains/eltaws.git
```

## Usage

### 1. Init client

```php
require 'vendor/autoload.php';
use Chinchillabrains\Eltaws\Client;
$client = new Client();
```

### 2. Create a new package to send

```php
// Available fields (details in wc/docs direcotry)
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
$response = $client->sendPackage( $packageInfo );
```

### 3. Get printable label for a package

```php
// Available fields (details in wc/docs direcotry)
$packageInfo = array(
	'pel_code'     => '',
	'wpel_user'    => '',
	'wpel_pass'    => '',
	'wpel_vg'      => '',
	'paper_size'   => 1, 0 = Label A4, 1 = Label A6, 1 Default
);
$response = $client->getLabel( $packageInfo );
```

### 4. Get tracking data for a package

```php
// Available fields (details in wc/docs direcotry)
$packageInfo = array(
	'wpel_code'   => '',
	'wpel_user'   => '',
	'wpel_pass'   => '',
	'wpel_vg'     => '',
	'wpel_ref'    => '',
	'wpel_flag'   => 1, 1 = Αναζήτηση με Αριθμό Αποστολής, 2 = Αναζήτηση με Reference_No, 1 Default
);
$response = $client->getTrackingData( $packageInfo );
```

### 5. Get Elta store that serves a ZIP code

```php
$zip = '12345';
$response = $client->getStoreByZip( $zip );
```
