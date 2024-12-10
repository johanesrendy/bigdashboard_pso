<!DOCTYPE html>
<html>

<head>
    <title>Import Contacts</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body>
    <h1>Import Contacts</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Tautan Unduh Template -->
    <p>Download the template for uploading contacts:</p>
    <a href="{{ asset('templates/template_excel.xlsx') }}" class="btn btn-primary" download>Download Template</a>

    <form action="{{ route('contacts.import.post') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="file">Upload Excel File:</label>
        <input type="file" id="file" name="file" accept=".xls,.xlsx" required>
        <br>
        <button type="submit">Import</button>
    </form>

    
    <a href="{{ route('contacts.index') }}">Back to List</a>
</body>

</html>