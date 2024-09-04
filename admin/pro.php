<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Get Room Book Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #ADD8E6;
            color: white;
            text-align: center;
            margin: 50px;
        }

        h1 {
            color: #2c3e50;
        }

        form {
            margin-top: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input {
            padding: 8px;
            margin-bottom: 16px;
        }

        button {
            padding: 10px 20px;
            background-color: #2ecc71;
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #27ae60;
        }

        .details {
            margin-top: 20px;
            padding: 20px;
            background-color: #2c3e50;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .details div {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <h1>Get Room Book Details by Name</h1>
    <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <label for="fname">First Name:</label>
        <input type="text" name="fname" required>
        <label for="lname">Last Name:</label>
        <input type="text" name="lname" required>
        <br>
        <button type="submit">Get Details</button>
    </form>

    <div class="details">
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            session_start();
            if (!isset($_SESSION["user"])) {
                header("location:");  // Redirect to the appropriate location
            }

            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "hotel";

            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $fname = $_POST["fname"];
            $lname = $_POST["lname"];

            // Use a prepared statement to prevent SQL injection
            $sql = "CALL GetRoomBookDetailsByName(?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $fname, $lname);  // "ss" indicates two string parameters
            $stmt->execute();

            // Check if the stored procedure executed successfully
            if (!$stmt) {
                echo "Error executing stored procedure: " . $conn->error;
            } else {
                // Fetch the results
                $result = $stmt->get_result();

                // Check if there are results
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<div>Details for $fname $lname:</div>";
                        echo "<div>ID: " . $row['id'] . "</div>";
                        echo "<div>Title: " . $row['Title'] . "</div>";
                        echo "<div>Email: " . $row['Email'] . "</div>";
                        echo "<div>Phone: " . $row['Phone'] . "</div>";
                        echo "<div>TRoom: " . $row['TRoom'] . "</div>";
                        echo "<div>cin: " . $row['cin'] . "</div>";
                        echo "<div>cout: " . $row['cout'] . "</div>";
                    }
                } else {
                    echo "No records found for $fname $lname";
                }

                $stmt->close();
            }

            // Close the connection
            $conn->close();
        }
        ?>
    </div>
</body>
</html>
