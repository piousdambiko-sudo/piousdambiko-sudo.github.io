<?php
// Include database connection
require_once 'database.php';

// Initialize variables
$name = $email = $subject = $message = "";
$errors = array();
$success = false;

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Sanitize and validate name
    if (empty($_POST["name"])) {
        $errors[] = "Name is required";
    } else {
        $name = trim($_POST["name"]);
        $name = htmlspecialchars($name);
        if (strlen($name) < 3) {
            $errors[] = "Name must be at least 3 characters long";
        }
    }
    
    // Sanitize and validate email
    if (empty($_POST["email"])) {
        $errors[] = "Email is required";
    } else {
        $email = trim($_POST["email"]);
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email format";
        }
    }
    
    // Sanitize and validate subject
    if (empty($_POST["subject"])) {
        $errors[] = "Subject is required";
    } else {
        $subject = trim($_POST["subject"]);
        $subject = htmlspecialchars($subject);
        if (strlen($subject) < 5) {
            $errors[] = "Subject must be at least 5 characters long";
        }
    }
    
    // Sanitize and validate message
    if (empty($_POST["message"])) {
        $errors[] = "Message is required";
    } else {
        $message = trim($_POST["message"]);
        $message = htmlspecialchars($message);
        if (strlen($message) < 10) {
            $errors[] = "Message must be at least 10 characters long";
        }
    }
    
    // If no errors, insert into database
    if (empty($errors)) {
        // Prepare SQL statement to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, subject, message) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $subject, $message);
        
        // Execute the statement
        if ($stmt->execute()) {
            $success = true;
            
            // Optional: Send email notification (uncomment and configure if needed)
            /*
            $to = "info@poultryparadise.com";
            $email_subject = "New Contact Form Submission: " . $subject;
            $email_body = "You have received a new message from the contact form.\n\n";
            $email_body .= "Name: " . $name . "\n";
            $email_body .= "Email: " . $email . "\n";
            $email_body .= "Subject: " . $subject . "\n";
            $email_body .= "Message: \n" . $message . "\n";
            
            $headers = "From: " . $email . "\r\n";
            $headers .= "Reply-To: " . $email . "\r\n";
            
            mail($to, $email_subject, $email_body, $headers);
            */
            
        } else {
            $errors[] = "Error: " . $stmt->error;
        }
        
        $stmt->close();
    }
    
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Submission - Poultry Paradise</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .message-container {
            max-width: 600px;
            margin: 100px auto;
            padding: 40px;
            text-align: center;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .success-message {
            color: #065f46;
            background: #d1fae5;
            padding: 20px;
            border-radius: 8px;
            border: 2px solid #10b981;
            margin-bottom: 20px;
        }
        .error-message {
            color: #991b1b;
            background: #fee2e2;
            padding: 20px;
            border-radius: 8px;
            border: 2px solid #dc2626;
            margin-bottom: 20px;
        }
        .message-container h2 {
            color: #1e3c72;
            margin-bottom: 20px;
        }
        .message-container ul {
            list-style: none;
            padding: 0;
        }
        .message-container li {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <div class="container">
            <div class="logo">
                <img src="images/logo.png" alt="Poultry Paradise Logo" class="logo-img">
                <h1>Poultry Paradise</h1>
            </div>
            <nav>
                <ul>
                    <li><a href="index.html">Home</a></li>
                    <li><a href="about.html">About</a></li>
                    <li><a href="products.html">Products</a></li>
                    <li><a href="contact.html" class="active">Contact</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="message-container">
        <?php if ($success): ?>
            <div class="success-message">
                <h2>✓ Thank You!</h2>
                <p><strong>Your message has been successfully submitted.</strong></p>
                <p>We have received your message and will get back to you as soon as possible.</p>
                <p>A member of our team will contact you within 24-48 hours.</p>
            </div>
            <a href="index.html" class="btn-primary">Return to Homepage</a>
            <a href="contact.html" class="btn-secondary" style="margin-left: 10px;">Send Another Message</a>
