<?php

include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST['name']);
    $phone = trim($_POST['phone']);
    $service = trim($_POST['service']);
    $message = trim($_POST['message']);

    // Insert into database
    $stmt = $conn->prepare("INSERT INTO bookings (name, phone, service, message) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $phone, $service, $message);

    if ($stmt->execute()) {

        // Email
        $to = "your_email@gmail.com";
        $subject = "New Salon Booking";

        $body = "
        New Booking Received

        Name : $name
        Phone : $phone
        Service : $service
        Preferred Date & Time : $message
        ";

        $headers = "From: noreply@yourdomain.com";

        mail($to, $subject, $body, $headers);

        echo "<script>
                alert('Booking Successful!');
                window.location='index.html';
              </script>";

    } else {

        echo "<script>
                alert('Database Error!');
                history.back();
              </script>";
    }

    $stmt->close();
    $conn->close();
}
?>