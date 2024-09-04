<?php
include('db.php'); // Make sure to include your database connection file

if (isset($_GET['email'])) {
    $email = $_GET['email'];

    // Fetch invoice details from the database
    $query = "SELECT * FROM roombook WHERE Email = '$email'";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        // Display the invoice details
?>
<!DOCTYPE html>
<html>
<head>
    <title>Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        #invoice-container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: green;
            text-align: center;
        }

        #thank-you {
            margin-top: 20px;
            font-size: 18px;
            font-weight: bold;
            color: green;
            text-align: center;
        }

        #customer-info {
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }

        #hotel-info {
            margin-top: 15px;
        }

        #underline {
            border-bottom: 1px solid #ddd;
            margin-bottom: 15px;
        }

        #contact-info {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div id="invoice-container">
        <h2>You have booked a Room</h2>

        <!-- Information of Guest -->
        <div id="customer-info">
            <p><strong>Name:</strong> <?php echo $row['Title'] . ' ' . $row['FName'] . ' ' . $row['LName']; ?></p>
            <p><strong>Email:</strong> <?php echo $row['Email']; ?></p>
            <p><strong>Room Type:</strong> <?php echo $row['TRoom']; ?></p>
            <!-- Add more customer details as needed -->
        </div>

        <!-- Hotel Information -->
        <div id="hotel-info">
            <p><strong>INFORMATION OF HOTEL:-</strong></p>
            <p>SUN RISE HOTEL,</p>
            <p>JP Nagar Road,</p>
            <p>Bangalore Karnataka,</p>
            <p>India.</p>
            <p>(+94) 65 222 44 55</p>
        </div>

        <!-- Underline between sections -->
        <div id="underline"></div>

        <!-- Booking Details -->
        <p><strong>Booking Details:</strong></p>
        <p><strong>Customer ID:</strong> <?php echo $row['id']; ?></p>
        <p><strong>Check-in Date:</strong> <?php echo $row['cin']; ?></p>
        <p><strong>Check-out Date:</strong> <?php echo $row['cout']; ?></p>
        <p><strong>Customer Phone:</strong> <?php echo $row['Phone']; ?></p>
        <p><strong>Customer National:</strong> <?php echo $row['National']; ?></p>
        <p><strong>Customer Country:</strong> <?php echo $row['Country']; ?></p>

        <!-- Contact Information -->
        <div id="contact-info">
            <p><strong>CONTACT US</strong></p>
            <p>Email: info@sunrise.com || Web: www.sunrise.com || Phone: +94 65 222 44 55</p>
        </div>

        <!-- Thank You Message -->
        <div id="thank-you">
            <p>Thank you for booking a room with us!</p>
            <p>Booking Date: <?php echo date('Y-m-d H:i:s'); ?></p>
        </div>
    </div>
</body>
</html>
<?php
    } else {
        echo "Invoice not found for the given email.";
    }
} else {
    echo "Email not provided.";
}
?>
