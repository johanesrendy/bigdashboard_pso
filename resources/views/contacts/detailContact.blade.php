<!DOCTYPE html>
<html>

<head>
    <title>Contact Details</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body>
    <h1>Contact Details</h1>

    <p><strong>Company Name:</strong> {{ $contact->company_name }}</p>
    <p><strong>Individual Name:</strong> {{ $contact->individual_name }}</p>
    <p><strong>Email:</strong> {{ $contact->email }}</p>
    <p><strong>Phone:</strong> {{ $contact->phone }}</p>
    <p><strong>Job Title:</strong> {{ $contact->job_title }}</p>
    <p><strong>Location:</strong> {{ $contact->location }}</p>
    <p><strong>Date Added:</strong> {{ $contact->date_added }}</p>
    <p><strong>Lead Status:</strong> {{ $contact->lead_status }}</p>

    <a href="{{ route('contacts.editForm', $contact->id) }}">Edit</a>
    <a href="{{ route('contacts.index') }}">Back to List</a>
</body>

</html>