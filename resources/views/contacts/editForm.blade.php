<!DOCTYPE html>
<html>
<head>
    <title>Edit Contact</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <h1>Edit Contact</h1>

    <form action="{{ route('contacts.update', $contact->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="company_name">Company Name:</label>
        <input type="text" id="company_name" name="company_name" value="{{ $contact->company_name }}" required>
        <br>

        <label for="individual_name">Individual Name:</label>
        <input type="text" id="individual_name" name="individual_name" value="{{ $contact->individual_name }}" required>
        <br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="{{ $contact->email }}" required>
        <br>

        <label for="phone">Phone:</label>
        <input type="text" id="phone" name="phone" value="{{ $contact->phone }}" required>
        <br>

        <label for="job_title">Job Title:</label>
        <input type="text" id="job_title" name="job_title" value="{{ $contact->job_title }}">
        <br>

        <label for="location">Location:</label>
        <input type="text" id="location" name="location" value="{{ $contact->location }}">
        <br>

        <label for="date_added">Date Added:</label>
        <input type="date" id="date_added" name="date_added" value="{{ $contact->date_added }}" required>
        <br>


        <button type="submit">Update Contact</button>
        <a href="{{ route('contacts.index') }}">Back to List</a>
    </form>
</body>
</html>
