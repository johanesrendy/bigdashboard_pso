<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacts PDF</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Contacts</h1>
    <table>
        <thead>
            <tr>
                <th>Company Name</th>
                <th>Individual Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Job Title</th>
                <th>Location</th>
                <th>Date Added</th>
                <th>Lead Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($contacts as $contact)
                <tr>
                    <td>{{ $contact->company_name }}</td>
                    <td>{{ $contact->individual_name }}</td>
                    <td>{{ $contact->email }}</td>
                    <td>{{ $contact->phone }}</td>
                    <td>{{ $contact->job_title }}</td>
                    <td>{{ $contact->location }}</td>
                    <td>{{ $contact->date_added }}</td>
                    <td>{{ $contact->lead_status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
