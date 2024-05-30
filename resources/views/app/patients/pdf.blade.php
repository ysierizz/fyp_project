<!DOCTYPE html>
<html>
<head>
    <title>Patient Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        h1 {
            text-align: center;
        }
        .patient-details {
            margin-top: 30px;
        }
        .patient-details table {
            width: 100%;
            border-collapse: collapse;
        }
        .patient-details th,
        .patient-details td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .patient-details th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Patient Details</h1>
        <div class="patient-details">
            <table>
                <tr>
                    <th>Name</th>
                    <td>{{ $patient->name }}</td>
                </tr>
                <tr>
                    <th>Contact No</th>
                    <td>{{ $patient->contact_no }}</td>
                </tr>
                <tr>
                    <th>Address</th>
                    <td>{{ $patient->address }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $patient->email }}</td>
                </tr>
                <tr>
                    <th>Emergency Contact</th>
                    <td>{{ $patient->emergency_contact }}</td>
                </tr>
                <tr>
                    <th>Date of Birth</th>
                    <td>{{ $patient->date_of_birth }}</td>
                </tr>
                <tr>
                    <th>Gender</th>
                    <td>{{ $patient->gender }}</td>
                </tr>
                <tr>
                    <th>Medical History</th>
                    <td>{{ $patient->medical_history }}</td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>
