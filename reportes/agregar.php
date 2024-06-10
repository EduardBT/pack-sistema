<?php

$countryCode = 'AR'; // Country code for Argentina

// Make a request to GeoNames API
$response = file_get_contents("http://api.geonames.org/postalCodeSearchJSON?country={$countryCode}&username=your_geonames_username");

// Check if the request was successful
if ($response) {
    $data = json_decode($response, true);
    
    // Iterate over the postal codes and insert them into the database
    foreach ($data['postalCodes'] as $item) {
        $postalCode = $item['postalCode'];
        $city = $item['placeName'];
        $stateProvince = $item['adminName1'];
        $latitude = $item['lat'];
        $longitude = $item['lng'];
        
        // Insert the postal code into the database table
        // Use your preferred database connection method here
        $sql = "INSERT INTO PostalCodes (country_code, postal_code, city, state_province, latitude, longitude) VALUES ('$countryCode', '$postalCode', '$city', '$stateProvince', '$latitude', '$longitude')";
        // Execute the SQL statement
        // ...
    }
} else {
    echo "Failed to fetch postal codes for {$countryCode}.";
}
?>
