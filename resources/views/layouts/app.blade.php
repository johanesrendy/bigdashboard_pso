<!DOCTYPE html>
<html>

<head>
    <title>Dashboard</title>

    <!-- Vite resources for CSS -->
    @vite('resources/css/app.css')

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Custom CSS for layout -->
    <style>
        .container {
            display: flex;
            min-height: 100vh;
        }

        .main-content {
            margin-left: 20px;
            flex: 1;
            padding: 20px;
            box-sizing: border-box;
        }
    </style>

    <!-- ApexCharts CSS -->
    <link rel="stylesheet" href="./node_modules/apexcharts/dist/apexcharts.css">

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>

<body>
    <div class="container">
        <!-- Sidebar -->
        <aside class="sidebar">
            @include('partials.sidebar')
        </aside>

        <!-- Main Content -->
        <div class="main-content">
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Lodash Library -->
    <script src="./node_modules/lodash/lodash.min.js"></script>

    <!-- ApexCharts JS -->
    <script src="./node_modules/apexcharts/dist/apexcharts.min.js"></script>

    <script>
        function showPopup() {
            document.getElementById('leadFormPopup').classList.remove('hidden');
        }

        function closePopup() {
            document.getElementById('leadFormPopup').classList.add('hidden');
        }
    </script>

    <script>
        function showImportPopup() {
            document.getElementById('import-popup').classList.remove('hidden');
        }

        function closeImportPopup() {
            document.getElementById('import-popup').classList.add('hidden');
        }

        function showFileName() {
            const input = document.getElementById('file-upload');
            const fileList = document.getElementById('file-list');

            fileList.innerHTML = ''; // Clear the list before adding new files

            if (input.files.length > 0) {
                for (const file of input.files) {
                    const li = document.createElement('li');
                    li.classList.add('flex', 'justify-between', 'items-center', 'p-2', 'border', 'rounded', 'bg-gray-100');
                    li.textContent = file.name;

                    const removeBtn = document.createElement('button');
                    removeBtn.textContent = 'Hapus';
                    removeBtn.classList.add('text-red-600', 'font-bold', 'ml-2');
                    removeBtn.onclick = () => li.remove();

                    li.appendChild(removeBtn);
                    fileList.appendChild(li);
                }
            }
        }
    </script>

    <script>
        function openEditPopup(contactId) {
            $.ajax({
                url: `/contacts/${contactId}/edit`,
                type: 'GET',
                success: function(data) {
                    $('#individual_name').val(data.individual_name);
                    $('#jobrole').val(data.jobrole);
                    $('#location').val(data.location);
                    $('#company_name').val(data.company_name);
                    $('#company_type').val(data.company_type); // Ambil company_type
                    $('#email').val(data.email);
                    $('#phone').val(data.phone);
                    $('#date_added').val(data.date_added);
                    $('#contactId').val(data.id); // Store the contact ID

                    // Show the popup
                    $('#editLeadPopup').removeClass('hidden');
                },
                error: function(error) {
                    console.log(error);
                    alert('Error fetching contact data.');
                }
            });
        }
    </script>

    {{-- <script>
        let currentPage = 1;
        const itemsPerPage = 10;

        function changePage(page) {
            if (page === 'prev') {
                currentPage = Math.max(1, currentPage - 1);
            } else if (page === 'next') {
                currentPage++;
            } else {
                currentPage = page;
            }

            fetchContacts();
        }

        function fetchContacts() {
            // Ganti dengan logika untuk mengambil data berdasarkan halaman saat ini
            fetch(`/api/contacts?page=${currentPage}`)
                .then(response => response.json())
                .then(data => {
                    updateTable(data.contacts);
                    updatePagination(data.totalPages); // Pastikan Anda mengirimkan totalPages dari server
                });
        }

        function updateTable(contacts) {
            const tableBody = document.querySelector('tbody');
            tableBody.innerHTML = '';

            contacts.forEach(contact => {
                const row = document.createElement('tr');
                row.className = 'border-t border-[#D0D5DD]';

                row.innerHTML = `
            <td class="px-4 py-2 text-sm text-[#1D2939]">${contact.id}</td>
            <td class="px-4 py-2 text-sm text-[#1D2939]">${contact.date_added}</td>
            <td class="px-4 py-2 text-sm text-[#1D2939]">${contact.individual_name}</td>
            <td class="px-4 py-2 text-sm text-[#1D2939]">${contact.email}</td>
            <td class="px-4 py-2 text-sm text-[#1D2939]">${contact.phone}</td>
            <td class="px-4 py-2 text-sm text-[#1D2939]">${contact.job_title}</td>
            <td class="px-4 py-2 text-sm text-[#1D2939]">${contact.company_name}</td>
            <td class="px-4 py-2 text-sm text-[#1D2939]">${contact.location}</td>
            <td class="px-4 py-2 text-sm">
                <span class="inline-block px-2 py-1 rounded text-white whitespace-nowrap ${contact.lead_status === 'Hot Leads' ? 'bg-[#F54A45]' : (contact.lead_status === 'Warm Leads' ? 'bg-[#FF931E]' : 'bg-[#0549CF]')}">
                    ${contact.lead_status}
                </span>
            </td>
            <td class="px-4 py-2 text-sm text-center">${contact.pic ? contact.pic : '<img src="path_to_nouser_icon" alt="No PIC" class="w-4 h-4" />'}</td>
            <td class="px-4 py-2 text-sm text-center">
                <button onclick="openEditPopup(${contact.id})" class="...">Edit</button>
                <form action="/contacts/${contact.id}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                    @csrf
                    @method('DELETE')
                    <button class="...">Delete</button>
                </form>
            </td>
        `;

                tableBody.appendChild(row);
            });
        }

        function updatePagination(totalPages) {
            const paginationContainer = document.querySelector('.pagination-container');
            paginationContainer.querySelectorAll('.page-button').forEach(button => button
        .remove()); // Kosongkan tombol halaman

            for (let i = 1; i <= totalPages; i++) {
                const pageButton = document.createElement('button');
                pageButton.onclick = () => changePage(i);
                pageButton.innerText = i;
                pageButton.className = `page-button ${i === currentPage ? 'active' : 'inactive'}`;
                paginationContainer.insertBefore(pageButton, paginationContainer
                .lastElementChild); // Tambahkan sebelum tombol berikutnya
            }
        }

        document.addEventListener('DOMContentLoaded', fetchContacts);
    </script> --}}

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const stackedBarChartCtx = document.getElementById('stacked-bar-chart').getContext('2d');
            const donutChartCtx = document.getElementById('donut-chart').getContext('2d');

            // Data dari server
            const hotLeads = {{ $hotLeads }};
            const warmLeads = {{ $warmLeads }};
            const coldLeads = {{ $coldLeads }};
            const totalLeads = {{ $totalLeads }};

            // Stacked Bar Chart
            const stackedBarChart = new Chart(stackedBarChartCtx, {
                type: 'bar',
                data: {
                    labels: ['Leads'],
                    datasets: [{
                            label: 'Cold Leads',
                            data: [coldLeads],
                            backgroundColor: '#0549CF',
                        },
                        {
                            label: 'Warm Leads',
                            data: [warmLeads],
                            backgroundColor: '#FF931E',
                        },
                        {
                            label: 'Hot Leads',
                            data: [hotLeads],
                            backgroundColor: '#F54A45',
                        },
                    ],
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Donut Chart
            const donutChart = new Chart(donutChartCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Cold Leads', 'Warm Leads', 'Hot Leads'],
                    datasets: [{
                        data: [coldLeads, warmLeads, hotLeads],
                        backgroundColor: ['#0549CF', '#FF931E', '#F54A45'],
                    }],
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        }
                    }
                }
            });
        });
    </script>

</body>

</html>
