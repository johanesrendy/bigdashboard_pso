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
