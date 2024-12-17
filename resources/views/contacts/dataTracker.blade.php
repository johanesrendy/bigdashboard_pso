@extends('layouts.app')

@section('content')
    <div class="px-1 py-8">
        <!-- Heading: Data Leads -->
        <h1 class="text-black font-poppins text-[25px] font-normal leading-[120%] mb-6">Data Tracker</h1>

        <!-- Subheading: Data Leads yang belum ditindaklanjuti lebih dari 7 hari -->
        <p class="text-[#555] font-poppins text-[16px] font-normal leading-[120%] mb-2">
            Data leads yang belum ditindaklanjuti lebih dari 7 hari
        </p>
    </div>

    <!-- Table Section -->
    <div class="datatracker-container flex flex-col items-start gap-[7.568px] p-[18.135px] rounded-[11.35px] border-[0.95px] border-[#EAECF0] w-full">
        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr class="bg-[#F2F4F7] text-black text-xs font-bold">
                    <th class="px-4 py-2">Perusahaan</th>
                    <th class="px-4 py-2">Tanggal</th>
                    <th class="px-4 py-2">Nama</th>
                    <th class="px-4 py-2">Email</th>
                    <th class="px-4 py-2">Nomor Telepon</th>
                    <th class="px-4 py-2">Pekerjaan</th>
                    <th class="px-4 py-2">Lokasi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($contacts as $contact)
                    <tr class="border-t border-[#D0D5DD]">
                        <td class="px-4 py-2 text-sm text-[#1D2939]">{{ $contact->company_name }}</td>
                        <td class="px-4 py-2 text-sm text-[#1D2939]">{{ $contact->date_added }}</td>
                        <td class="px-4 py-2 text-sm text-[#1D2939]">{{ $contact->individual_name }}</td>
                        <td class="px-4 py-2 text-sm text-[#1D2939]">{{ $contact->email }}</td>
                        <td class="px-4 py-2 text-sm text-[#1D2939]">{{ $contact->phone }}</td>
                        <td class="px-4 py-2 text-sm text-[#1D2939]">{{ $contact->job_title }}</td>
                        <td class="px-4 py-2 text-sm text-[#1D2939]">{{ $contact->location }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-2 text-center">No contacts found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination Section -->
    <div class="mt-4 pagination-container flex items-center justify-end gap-3">
        <!-- Previous Button -->
        <button onclick="changePage('prev')" class="pagination-button">
            <img src="{{ asset('icons/arrow-left.svg') }}" alt="Previous" />
        </button>

        <!-- Page Number Buttons will be dynamically added -->
        {{ $contacts->links() }} <!-- Laravel pagination links -->

        <!-- Next Button -->
        <button onclick="changePage('next')" class="pagination-button">
            <img src="{{ asset('icons/arrow-right.svg') }}" alt="Next" />
        </button>
    </div>
@endsection
