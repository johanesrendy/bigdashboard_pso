<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export Contacts</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body>
    <h1>Export Contacts</h1>

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('contacts.export') }}" method="POST">
        @csrf
        <label for="lead_status">Filter by Lead Status:</label>
        <select name="lead_status" id="lead_status">
            <option value="">All</option>
            <option value="Hot Leads">Hot Leads</option>
            <option value="Warm Leads">Warm Leads</option>
            <option value="Cold Leads">Cold Leads</option>
        </select>

        <br><br>

        <label for="from_date">From Date:</label>
        <input type="date" id="from_date" name="from_date">

        <label for="to_date">To Date:</label>
        <input type="date" id="to_date" name="to_date">

        <br><br>

        <label for="format">Select Format:</label>
        <select name="format" id="format" required>
            <option value="csv">CSV</option>
            <option value="xls">Excel (XLS)</option>
            <option value="pdf">PDF</option>
        </select>

        <br><br>

        <button type="submit">Export</button>
    </form>


    <a href="{{ route('contacts.index') }}">Back to List</a>
</body>

</html>