<?php
include("connection.php");
// Set your secret key. Remember to switch to your live secret key in production.
// See your keys here: https://dashboard.stripe.com/apikeys
\Stripe\Stripe::setApiKey('sk_test_51PCZTIP4WM0wm2kRpVQ6cavdBljHQS2ruXrvT6FAjpw4lQSxFqfgae7nkOGX3GvnBVoPd6WSpSoc8lCltAMNnTre00dJWxygPN');

// You can find your endpoint's secret in your webhook settings
$endpoint_secret = 'whsec_...';

$payload = @file_get_contents('php://input');
$sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
$event = null;

try {
  $event = \Stripe\Webhook::constructEvent(
    $payload, $sig_header, $endpoint_secret
  );
} catch(\UnexpectedValueException $e) {
  // Invalid payload
  http_response_code(400);
  exit();
} catch(\Stripe\Exception\SignatureVerificationException $e) {
  // Invalid signature
  http_response_code(400);
  exit();
}

function create_order($session) {
    global $conn;  // Make sure your database connection is accessible

    // Assuming $session includes all necessary information
    $userID = $session->metadata->userID;
    $burgerName = $session->metadata->burger_name;
    $date = date("Y-m-d"); // Use the current date or a specific event date

    // Prepare the SQL statement
    $stmt = $conn->prepare("INSERT INTO Orders (user_ID, burger, date) VALUES (:userID, :burgerName, :date)");
    $stmt->bindParam(':userID', $userID);
    $stmt->bindParam(':burgerName', $burgerName);
    $stmt->bindParam(':date', $date);
    $stmt->execute();
}

switch ($event->type) {
    case 'checkout.session.completed':
        $session = $event->data->object;

        // Check if the order is paid (from a card payment)
        if ($session->payment_status == 'paid') {
            // Only create an order record for successful payments
            create_order($session);
        }
        break;

}

http_response_code(200);
?>