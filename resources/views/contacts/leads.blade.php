@extends('layouts.app')

@section('content')
<div class="px-1 py-8">
    <!-- Heading: Data Leads -->
    <h1 class="text-black font-poppins text-[25px] font-normal leading-[120%] mb-6">Data Leads</h1>

    <!-- Data Tracker Container -->
    <div class="datatracker-container flex flex-col items-start gap-[7.568px] p-[18.135px] rounded-[11.35px] border-[0.95px] border-[#EAECF0] w-full">

        <!-- Top Container -->
        <div class="top-container flex w-full items-center">
            <!-- Search Form -->
            <form method="GET" action="{{ route('contacts.index') }}" class="relative flex items-center w-full max-w-[400px]">
                <input type="text" name="search"
                    class="pl-10 pr-4 py-2 h-[41.622px] w-full text-[#667085] text-[13.243px] font-poppins font-normal leading-[18.919px] placeholder-[#667085] rounded-[11.351px] border border-[#D0D5DD] bg-[#F9FAFB] focus:outline-none focus:ring-0"
                    placeholder="Cari kata kunci..." value="{{ request('search') }}" />
                <img src="{{ asset('icons/search.svg') }}" alt="Search Icon" class="absolute left-3 w-[16px] h-[16px]" />
            </form>

            <!-- Filter Button -->
            <button class="ml-[200px] flex items-center h-[41.622px] px-[18.919px] gap-[7.568px] rounded-[11.351px] bg-[#F9FAFB] border">
                <span class="text-[#667085] text-[13.243px] font-poppins font-semibold whitespace-nowrap">Pilih Filter</span>
                <img src="{{ asset('icons/filter.svg') }}" alt="Filter Icon" class="w-[16px] h-[16px]" />
            </button>

            <!-- Tambah Lead Button -->
            <button class="ml-[22px] flex items-center h-[41.622px] px-[18.919px] gap-[7.568px] rounded-[11.351px] bg-[#0549CF] text-white" onclick="showPopup()">
                <span class="text-[13.243px] font-poppins font-semibold whitespace-nowrap">Tambah Lead</span>
                <img src="{{ asset('icons/add.svg') }}" alt="Add Icon" class="w-[16px] h-[16px]" />
            </button>

            <!-- Import Button -->
            <button onclick="showImportPopup()" class="ml-[22px] flex items-center h-[41.622px] px-[18.919px] gap-[7.568px] rounded-[11.351px] bg-[#DAE4F8]">
                <span class="text-[#032C7C] text-[13.243px] font-poppins font-semibold whitespace-nowrap">Import xlsx/csv</span>
                <img src="{{ asset('icons/add_blue.svg') }}" alt="Add Blue Icon" class="w-[16px] h-[16px]" />
            </button>

            <!-- Delete All Button -->
            <form method="POST" action="{{ route('contacts.deleteAll') }}" class="ml-[22px]">
                @csrf
                @method('DELETE')
                <button type="submit"
                    onclick="return confirm('Apakah Anda yakin ingin menghapus semua kontak?');"
                    class="flex items-center h-[41.622px] px-[18.919px] gap-[7.568px] rounded-[11.351px] bg-[#F54A45] text-white">
                    <span class="text-[13.243px] font-poppins font-semibold whitespace-nowrap">Hapus Semua</span>
                    <img src="{{ asset('icons/delete.svg') }}" alt="Delete Icon" class="w-[16px] h-[16px]" />
                </button>
            </form>
        </div>

        <!-- Table Section -->
        <div class="mt-5 w-full table-container">
            <table class="min-w-full bg-white border border-gray-200">
                <thead>
                    <tr class="bg-[#F2F4F7] text-black text-xs font-bold">
                        <th class="px-4 py-2">ID</th>
                        <th class="px-4 py-2">Tanggal</th>
                        <th class="px-4 py-2">Name</th>
                        <th class="px-4 py-2">Email</th>
                        <th class="px-4 py-2">Nomor Telepon</th>
                        <th class="px-4 py-2">Pekerjaan</th>
                        <th class="px-4 py-2">Perusahaan</th>
                        <th class="px-4 py-2">Lokasi</th>
                        <th class="px-4 py-2">Lead Status</th>
                        <th class="px-4 py-2">PIC</th>
                        <th class="px-4 py-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($contacts as $contact)
                        <tr class="border-t border-[#D0D5DD]">
                            <td class="px-4 py-2 text-sm text-[#1D2939]">{{ $contact->id }}</td>
                            <td class="px-4 py-2 text-sm text-[#1D2939]">{{ $contact->date_added }}</td>
                            <td class="px-4 py-2 text-sm text-[#1D2939]">{{ $contact->individual_name }}</td>
                            <td class="px-4 py-2 text-sm text-[#1D2939]">{{ $contact->email }}</td>
                            <td class="px-4 py-2 text-sm text-[#1D2939]">{{ $contact->phone }}</td>
                            <td class="px-4 py-2 text-sm text-[#1D2939]">{{ $contact->job_title }}</td>
                            <td class="px-4 py-2 text-sm text-[#1D2939]">{{ $contact->company_name }}</td>
                            <td class="px-4 py-2 text-sm text-[#1D2939]">{{ $contact->location }}</td>
                            <td class="px-4 py-2 text-sm">
                                <span class="inline-block px-[5px] py-[5px] rounded text-white whitespace-nowrap w-[100px] text-center
                                    {{ $contact->lead_status == 'Hot Leads' ? 'bg-[#F54A45]' :
                                        ($contact->lead_status == 'Warm Leads' ? 'bg-[#FF931E]' : 'bg-[#0549CF]') }}">
                                    {{ $contact->lead_status }}
                                </span>
                            </td>
                            <td class="px-4 py-2 text-sm text-center">
                                @if ($contact->pic == null)
                                    <button class="text-red-600" title="No PIC">
                                        <img src="{{ asset('icons/nouser.svg') }}" alt="No PIC" class="w-4 h-4" />
                                    </button>
                                @else
                                    {{ $contact->pic }}
                                @endif
                            </td>
                            <td class="px-4 py-2 text-sm text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <button onclick="openEditPopup({{ $contact->id }})"
                                        class="flex justify-center items-center w-[30.965px] h-[30.965px] p-[4px] gap-[2px] rounded-[5.193px] bg-[#EFF4FF]">
                                        <img src="{{ asset('icons/edit.svg') }}" alt="Edit Icon" />
                                    </button>
                                    <form action="{{ route('contacts.destroy', $contact->id) }}" method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="flex justify-center items-center w-[30.965px] h-[30.965px] p-[4px] gap-[2px] rounded-[5.193px] bg-[#FEF3F2]">
                                            <img src="{{ asset('icons/delete.svg') }}" alt="Delete Icon" />
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="px-4 py-2 text-center">No contacts found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Section -->
        <div class="mt-4 pagination-container flex items-center justify-end gap-3">
            {{ $contacts->links() }}
        </div>
    </div>
</div>





    <div id="leadFormPopup" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div
            class="flex flex-col gap-[36.862px] p-[30.256px] rounded-[11.128px] bg-[#FAFAFA] w-[700px] overflow-y-auto max-h-[90vh]">
            <h2 class="text-[#292929] font-poppins text-[20.052px] font-bold leading-[112%]">Tambah Leads Baru</h2>

            <form action="{{ route('contacts.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-2 gap-4">
                    <div class="flex flex-col">
                        <label for="individual_name" class="flex items-center font-poppins font-semibold">
                            Nama Lengkap <span class="text-red-600">*</span>
                        </label>
                        <input type="text" id="individual_name" name="individual_name"
                            placeholder="Masukkan nama lengkap kontak"
                            class="h-[40px] rounded-[5.564px] border border-[#C5CFEF] text-[#333] text-left pl-2 placeholder-poppins"
                            required />
                    </div>
                    <div class="flex flex-col">
                        <label for="jobrole" class="flex items-center font-poppins font-semibold">
                            Pekerjaan <span class="text-red-600">*</span>
                        </label>
                        <input type="text" id="jobrole" name="jobrole" placeholder="Masukkan pekerjaan kontak"
                            class="h-[40px] rounded-[5.564px] border border-[#C5CFEF] text-[#333] text-left pl-2 placeholder-poppins"
                            required />
                    </div>
                    <div class="flex flex-col">
                        <label for="location" class="flex items-center font-poppins font-semibold">
                            Domisili <span class="text-red-600">*</span>
                        </label>
                        <input type="text" id="location" name="location" placeholder="Masukkan domisili kontak"
                            class="h-[40px] rounded-[5.564px] border border-[#C5CFEF] text-[#333] text-left pl-2 placeholder-poppins"
                            required />
                    </div>
                    <div class="flex flex-col">
                        <label for="company_name" class="flex items-center font-poppins font-semibold">
                            Perusahaan <span class="text-red-600">*</span>
                        </label>
                        <input type="text" id="company_name" name="company_name"
                            placeholder="Masukkan nama perusahaan kontak"
                            class="h-[40px] rounded-[5.564px] border border-[#C5CFEF] text-[#333] text-left pl-2 placeholder-poppins"
                            required />
                    </div>
                    <!-- Input Jenis Perusahaan -->
                    <div class="flex flex-col">
                        <label for="company_type" class="flex items-center font-poppins font-semibold">
                            Jenis Perusahaan <span class="text-red-600">*</span>
                        </label>
                        <input type="text" id="company_type" name="company_type"
                            placeholder="Masukkan jenis perusahaan"
                            class="h-[40px] rounded-[5.564px] border border-[#C5CFEF] text-[#333] text-left pl-2 placeholder-poppins"
                            required />
                    </div>
                    <div class="flex flex-col">
                        <label for="email" class="flex items-center font-poppins font-semibold">
                            Email <span class="text-red-600">*</span>
                        </label>
                        <input type="email" id="email" name="email" placeholder="Masukkan email kontak"
                            class="h-[40px] rounded-[5.564px] border border-[#C5CFEF] text-[#333] text-left pl-2 placeholder-poppins"
                            required />
                    </div>
                    <div class="flex flex-col">
                        <label for="phone" class="flex items-center font-poppins font-semibold">
                            Phone <span class="text-red-600">*</span>
                        </label>
                        <input type="text" id="phone" name="phone" placeholder="Masukkan nomor telepon kontak"
                            class="h-[40px] rounded-[5.564px] border border-[#C5CFEF] text-[#333] text-left pl-2 placeholder-poppins"
                            required />
                    </div>
                    <div class="flex flex-col">
                        <label for="date_added" class="flex items-center font-poppins font-semibold">
                            Tanggal Ditambahkan <span class="text-red-600">*</span>
                        </label>
                        <input type="date" id="date_added" name="date_added"
                            value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" required
                            class="h-[40px] rounded-[5.564px] border border-[#C5CFEF] text-[#333] text-left pl-2 placeholder-poppins" />
                    </div>
                    <div class="flex flex-col">
                        <label for="lead_status" class="flex items-center font-poppins font-semibold">
                            Pilih Lead Status
                        </label>
                        <select id="lead_status" name="lead_status"
                            class="h-[40px] rounded-[5.564px] border border-[#C5CFEF] text-[#333] text-left pl-2">
                            <option value="Warm Leads">Warm Leads</option>
                            <option value="Cold Leads">Cold Leads</option>
                            <option value="Hot Leads">Hot Leads</option>
                        </select>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-between mt-4">
                    <button type="button"
                        class="flex items-center justify-center py-2 px-4 rounded-[5.564px] bg-[#A5A5A5] font-poppins font-semibold"
                        onclick="closePopup()">
                        <span class="text-white">Batal</span>
                    </button>
                    <button type="submit"
                        class="flex items-center justify-center py-2 px-4 rounded-[5.564px] bg-[#0549CF] font-poppins font-semibold">
                        <img src="{{ asset('icons/update.svg') }}" alt="Update Icon" class="mr-2" />
                        <span class="text-white">Tambah</span>
                    </button>
                </div>
            </form>
        </div>
    </div>


    <div id="import-popup" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="flex flex-col justify-center items-center gap-8 p-8 w-[704px] rounded-lg bg-white">
            <h2 class="text-gray-900 text-2xl font-bold">Import Data Leads</h2>

            <p class="text-gray-600 text-sm text-center">
                *Import data Leads menggunakan file dengan format xls/xlsx yang mengikuti template pada link
                <a href="{{ asset('templates/template_excel.xlsx') }}" class="font-bold text-blue-600">berikut</a>
            </p>

            <!-- Form Import -->
            <form id="popupImportForm" action="{{ route('contacts.import.post') }}" method="POST" enctype="multipart/form-data" class="w-full">
                @csrf
                <div class="flex flex-col items-center gap-4">
                    <!-- Upload File Section -->
                    <div class="w-full border-2 border-gray-400 rounded-md p-4">
                        <label for="file-upload" class="block text-center">
                            Pilih file
                            <input type="file" id="file-upload" name="file" accept=".xls,.xlsx" class="block w-full text-center" required />
                        </label>
                    </div>
                    <ul id="file-list" class="text-gray-600 text-sm"></ul>
                </div>

                <!-- Buttons -->
                <div class="flex justify-end gap-4 mt-4">
                    <button type="button" onclick="closeImportPopup()" class="bg-gray-400 text-white py-2 px-4 rounded">Batal</button>
                    <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded">Import</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Show file name when selected
        function showFileName() {
            const fileInput = document.getElementById('file-upload');
            const fileList = document.getElementById('file-list');
            fileList.innerHTML = ''; // Clear old file list

            if (fileInput.files.length > 0) {
                const fileName = fileInput.files[0].name;
                const listItem = document.createElement('li');
                listItem.textContent = fileName;
                fileList.appendChild(listItem);
            }
        }

        // Close Import Popup
        function closeImportPopup() {
            document.getElementById('import-popup').classList.add('hidden');
        }

        // Open Import Popup (optional trigger)
        function openImportPopup() {
            document.getElementById('import-popup').classList.remove('hidden');
        }
    </script>



<!-- Edit Leads Popup -->
<div id="editLeadPopup" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="flex flex-col gap-[36.862px] p-[30.256px] rounded-[11.128px] bg-[#FAFAFA] w-[700px] overflow-y-auto max-h-[90vh]">
        <h2 class="text-[#292929] font-poppins text-[20.052px] font-bold leading-[112%]">Edit Lead</h2>

        @isset($contact)
            <form id="editLeadForm" action="{{ route('contacts.update', $contact->id) }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" id="contactId" name="contactId" value="{{ $contact->id }}">

                <div class="grid grid-cols-2 gap-4">
                    <div class="flex flex-col">
                        <label for="individual_name" class="flex items-center font-poppins font-semibold">
                            Nama Lengkap <span class="text-red-600">*</span>
                        </label>
                        <input type="text" id="individual_name" name="individual_name"
                            value="{{ $contact->individual_name }}"
                            class="h-[40px] rounded-[5.564px] border border-[#C5CFEF] text-[#333] text-left pl-2 placeholder-poppins"
                            required />
                    </div>

                    <div class="flex flex-col">
                        <label for="jobrole" class="flex items-center font-poppins font-semibold">
                            Pekerjaan <span class="text-red-600">*</span>
                        </label>
                        <input type="text" id="jobrole" name="jobrole" value="{{ $contact->jobrole }}"
                            class="h-[40px] rounded-[5.564px] border border-[#C5CFEF] text-[#333] text-left pl-2 placeholder-poppins"
                            required />
                    </div>

                    <div class="flex flex-col">
                        <label for="location" class="flex items-center font-poppins font-semibold">
                            Domisili <span class="text-red-600">*</span>
                        </label>
                        <input type="text" id="location" name="location" value="{{ $contact->location }}"
                            class="h-[40px] rounded-[5.564px] border border-[#C5CFEF] text-[#333] text-left pl-2 placeholder-poppins"
                            required />
                    </div>

                    <div class="flex flex-col">
                        <label for="company_name" class="flex items-center font-poppins font-semibold">
                            Perusahaan <span class="text-red-600">*</span>
                        </label>
                        <input type="text" id="company_name" name="company_name"
                            value="{{ $contact->company_name }}"
                            class="h-[40px] rounded-[5.564px] border border-[#C5CFEF] text-[#333] text-left pl-2 placeholder-poppins"
                            required />
                    </div>

                    <div class="flex flex-col">
                        <label for="company_type" class="flex items-center font-poppins font-semibold">
                            Jenis Perusahaan <span class="text-red-600">*</span>
                        </label>
                        <input type="text" id="company_type" name="company_type"
                            value="{{ $contact->company_type }}"
                            class="h-[40px] rounded-[5.564px] border border-[#C5CFEF] text-[#333] text-left pl-2 placeholder-poppins"
                            required />
                    </div>

                    <div class="flex flex-col">
                        <label for="email" class="flex items-center font-poppins font-semibold">
                            Email <span class="text-red-600">*</span>
                        </label>
                        <input type="email" id="email" name="email" value="{{ $contact->email }}"
                            class="h-[40px] rounded-[5.564px] border border-[#C5CFEF] text-[#333] text-left pl-2 placeholder-poppins"
                            required />
                    </div>

                    <div class="flex flex-col">
                        <label for="phone" class="flex items-center font-poppins font-semibold">
                            Phone <span class="text-red-600">*</span>
                        </label>
                        <input type="text" id="phone" name="phone" value="{{ $contact->phone }}"
                            class="h-[40px] rounded-[5.564px] border border-[#C5CFEF] text-[#333] text-left pl-2 placeholder-poppins"
                            required />
                    </div>

                    <div class="flex flex-col">
                        <label for="date_added" class="flex items-center font-poppins font-semibold">
                            Tanggal Ditambahkan <span class="text-red-600">*</span>
                        </label>
                        <input type="date" id="date_added" name="date_added" value="{{ $contact->date_added }}"
                            class="h-[40px] rounded-[5.564px] border border-[#C5CFEF] text-[#333] text-left pl-2 placeholder-poppins"
                            required />
                    </div>

                    <!-- New Field: Lead Status -->
                    <div class="flex flex-col">
                        <label for="lead_status" class="flex items-center font-poppins font-semibold">
                            Pilih Lead Status
                        </label>
                        <select id="lead_status" name="lead_status"
                            class="h-[40px] rounded-[5.564px] border border-[#C5CFEF] text-[#333] text-left pl-2">
                            <option value="Warm Leads" @if($contact->lead_status == 'Warm Leads') selected @endif>Warm Leads</option>
                            <option value="Cold Leads" @if($contact->lead_status == 'Cold Leads') selected @endif>Cold Leads</option>
                            <option value="Hot Leads" @if($contact->lead_status == 'Hot Leads') selected @endif>Hot Leads</option>
                        </select>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-between mt-4">
                    <button type="button"
                        class="flex items-center justify-center py-2 px-4 rounded-[5.564px] bg-[#A5A5A5] font-poppins font-semibold"
                        onclick="closeEditPopup()">
                        <span class="text-white">Batal</span>
                    </button>
                    <button type="submit"
                        class="flex items-center justify-center py-2 px-4 rounded-[5.564px] bg-[#0549CF] font-poppins font-semibold">
                        <img src="{{ asset('icons/update.svg') }}" alt="Update Icon" class="mr-2" />
                        <span class="text-white">Update</span>
                    </button>
                </div>
            </form>
        @else
            <p class="text-red-600">Kontak tidak ditemukan atau data tidak tersedia.</p>
        @endisset
    </div>
</div>


@endsection
