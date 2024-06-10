<?php
// Import necessary libraries
require_once 'path_to_vendor_folder/pdo-library/autoload.php';
use Aura\SqlQuery\QueryFactory;
use GuzzleHttp\Client;

// MySQL database connection details
$host = 'your_host';
$user = 'your_user';
$password = 'your_password';
$database = 'your_database';

// Create a PDO connection
$pdo = new PDO("mysql:host=$host;dbname=$database", $user, $password);

// Create a query factory
$queryFactory = new QueryFactory('mysql');

// GeoNames API endpoint URL
$url = 'http://api.geonames.org/postalCodeSearchJSON';

// Parameters for the API request
$params = [
    'country' => '',
    'username' => 'your_geonames_username'
];

try {
    // Retrieve a list of countries
    $client = new Client();
    $countriesResponse = $client->get('http://api.geonames.org/countryInfoJSON');
    $countriesData = json_decode($countriesResponse->getBody(), true);
    $countries = $countriesData['geonames'];

    // Iterate over each country
    foreach ($countries as $country) {
        $countryCode = $country['countryCode'];

        // Update the API request parameters with the country code
        $params['country'] = $countryCode;

        // Send the API request
        $client = new Client();
        $response = $client->get($url, ['query' => $params]);

        // Check if the request was successful (status code 200)
        if ($response->getStatusCode() === 200) {
            // Parse the JSON response
            $data = json_decode($response->getBody(), true)['postalCodes'];

            // Iterate over the postal codes and insert them into the database
            foreach ($data as $item) {
                $postalCode = $item['postalCode'];
                $city = $item['placeName'];
                $stateProvince = $item['adminName1'];
                $latitude = $item['lat'];
                $longitude = $item['lng'];

                // Insert the postal code into the database table
                $insert = $queryFactory->newInsert();
                $insert->into('PostalCodes')
                    ->cols([
                        'country_code' => $countryCode,
                        'postal_code' => $postalCode,
                        'city' => $city,
                        'state_province' => $stateProvince,
                        'latitude' => $latitude,
                        'longitude' => $longitude
                    ]);

                $statement = $pdo->prepare($insert->getStatement());
                $statement->execute($insert->getBindValues());
            }

            echo "Postal codes for $countryCode inserted successfully.\n";
        } else {
            echo "API request failed for $countryCode with status code: {$response->getStatusCode()}\n";
        }
    }
} catch (Exception $e) {
    echo "Error making API request: " . $e->getMessage() . "\n";
} finally {
    // Close the database connection
    $pdo = null;
}
?>
