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
                    <label for="height">Enter Height: </label><br>
                    <input type="number" name="height" id="height">
                </div>
                <div class="filed">
                    <label for="weight">Enter Weight: </label><br>
                    <input type="number" name="weight" id="weight" required>
                </div>
                <div class="filed">
                    <label for="bmi">Enter BMI: </label><br>
                    <input type="number" name="bmi" step="0.01" id="bmi" required>
                </div>
                <div class="filed">
                    <label for="systolic">Enter Systolic: </label><br>
                    <input type="number" name="systolic" id="systolic" required >
                </div>
                <div class="filed">
                    <label for="diastolic">Enter Diastolic: </label><br>
                    <input type="number" name="diastolic" id="diastolic" required>
                </div>
                <div class="filed">
                    <label for="heartrate">Enter Heartrate: </label><br>
                    <input type="number" name="heartrate" id="heartrate" required>
                </div>
                <div class="filed">
                    <label for="glucose">Enter Glucose Level: </label><br>
                    <input type="number" name="glucose" id="glucose" required >
                </div>
                <div class="filed">
                    <label for="oxygen">Enter Blood Oxygen Precentage: </label><br>
                    <input type="number" name="oxygen" id="oxygen" required>
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