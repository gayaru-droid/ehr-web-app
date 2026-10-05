<?php
session_start();
if(!isset($_SESSION['p_id'])){
    header('location:../../login/login.php');
};
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Measurement</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="title">
                <p class=heading>Add Measurement</p>
                <p>Add measurements to update</p>
            </div>
            <div class="form">
                <form action="process.php" method="post">
                <div class="filed">
                    <label for="medname">Enter Medicine Name: </label><br>
                    <input type="text" name="medname" id="medname">
                </div>
                <div class="filed">
                    <label for="dosage">Enter Dosage: </label><br>
                    <input type="text" name="dosage" id="dosage" required>
                </div>
                <div class="filed">
                    <label for="quantity">Enter Quantity: </label><br>
                    <input type="number" name="quantity" id="quantity" required>
                </div>
                <div class="filed">
                    <label for="start_date">Enter Start Date: </label><br>
                    <input type="date" name="start_date" id="start_date" required >
                </div>
                <div class="filed">
                    <label for="end_date">Enter End Date: </label><br>
                    <input type="date" name="end_date" id="diastend_dateolic" required>
                </div>
                <div class="submit">
                    <input type="submit" value="Add" name="add">
                </div>
                </form>
            </div>
        </div>
    </div>
</body>
<script src="sctrips.js"></script>
</html>