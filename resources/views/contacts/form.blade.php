<!DOCTYPE html>
<html>
<head>
    <title>Add New Contact</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <h1>Add New Contact</h1>

    <form action="{{ route('contacts.store') }}" method="POST">
        @csrf
        <label for="company_name">Company Name:</label>
        <input type="text" id="company_name" name="company_name" required>
        <br>

        <label for="individual_name">Individual Name:</label>
        <input type="text" id="individual_name" name="individual_name" required>
        <br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <br>

        <label for="phone">Phone:</label>
        <input type="text" id="phone" name="phone" required>
        <br>

        <label for="job_title">Job Title:</label>
        <input type="text" id="job_title" name="job_title">
        <br>

        <label for="location">Location:</label>
        <input type="text" id="location" name="location">
        <br>

        <label for="date_added">Date Added:</label>
        <input type="date" id="date_added" name="date_added" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" required>
        <br>


        <button type="submit">Add Contact</button>
        
    </form>
</body>
</html>
