<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blood Pressure Report</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="wrapper">
        <div class="headingrow">
            <div class="headingcontent">
                <div class="logo"><img src="../imgs/logo-tp-long.png" alt="logo"></div>
                <div class="contactinfo">
                    <p>Email: info@syncmedi.com</p>
                    <p>Website: www.syncmedi.com</p>
                    <p>Address: 123 Main Street, City, State 12345</p>
                    <p>Tel: 123-456-7890</p>
                    <p>Fax: 123-456-7890</p>
                </div>
            </div>
        </div>
        <hr></hr>
        <div class="content">
            <div class="topcontent">
                <div class="reporttitle">
                    <h1>Blood Pressure Report</h1>
                </div>
                <div class="patientdetails">
                    <p>Patient Name: $patientName</p>
                    <p>Patient ID: $patientId</p>
                    <p>Date Range: $startDate to $endDate </p>
                    <p>Email: $patientEmail</p>
                </div>
                <div class="chart">
                    <img src="../imgs/graph.jpg" alt="Blood Pressure Chart">
                </div>
                <div class="table">
                    <table>
                        <tr>
                            <th>Index</th>
                            <th>Systolic</th>
                            <th>Diastolic</th>
                            <th>DateTime</th>
                            <th>Status</th>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>120</td>
                            <td>80</td>
                            <td>2023-01-01 10:00:00</td>
                            <td>Normal</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>130</td>
                            <td>85</td>
                            <td>2023-01-02 11:00:00</td>
                            <td>Elevated</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>140</td>
                            <td>90</td>
                            <td>2023-01-03 12:00:00</td>
                            <td>High Blood Pressure (Stage 1)</td>
                        </tr>
                        <tr> 
                            <td>4</td>
                            <td>150</td>
                            <td>95</td>
                            <td>2023-01-04 13:00:00</td>
                            <td>High Blood Pressure (Stage 2)</td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>160</td>
                            <td>100</td>
                            <td>2023-01-05 14:00:00</td>
                            <td>Hypertensive Crisis</td>
                        </tr>
                        <tr>
                            <td>6</td>
                            <td>110</td>
                            <td>70</td>
                            <td>2023-01-06 15:00:00</td>
                            <td>Normal</td>
                        </tr>
                        <tr>
                            <td>7</td>
                            <td>125</td>
                            <td>82</td>
                            <td>2023-01-07 16:00:00</td>
                            <td>Elevated</td>
                        </tr>
                        <tr>
                            <td>8</td>
                            <td>135</td>
                            <td>88</td>
                            <td>2023-01-08 17:00:00</td>
                            <td>High Blood Pressure (Stage 1)</td>
                        </tr>
                        <tr>
                            <td>9</td>
                            <td>145</td>
                            <td>92</td>
                            <td>2023-01-09 18:00:00</td>
                            <td>High Blood Pressure (Stage 2)</td>
                        </tr>
                        <tr>
                            <td>10</td>
                            <td>155</td>
                            <td>98</td>
                            <td>2023-01-10 19:00:00</td>
                            <td>Hypertensive Crisis</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="footer">
                <hr></hr>
                <div class="details">
                    <p>Generated on: $generationDate</p>
                    <p>Report ID: $reportId</p>
                </div>
                <p style="text-align: center; font-size: 10px;">
                    This is an electronically generated report, hence does not require signature
                </p>
            </div>
        </div>
    </div>
</body>
</html>