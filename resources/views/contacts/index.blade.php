@extends('layouts.app')

@section('content')
    <!-- Greeting -->
    @php
        $hour = date('H');
        $greeting = 'Selamat Malam';
        if ($hour >= 5 && $hour < 12) {
            $greeting = 'Selamat Pagi';
        } elseif ($hour >= 12 && $hour < 18) {
            $greeting = 'Selamat Siang';
        }
    @endphp
    <h1 class="heading">{{ $greeting }}, {{ $userName }}</h1>

    <br><br>

    <!-- Statistik Ringkasan -->
    <div class="stats">
        <div class="stat-card">
            <img src="{{ asset('icons/leads-card.svg') }}" alt="Leads" class="stat-icon">
            <div>
                <div class="stat-text">Leads</div>
                <div class="stat-number">{{ $totalLeads }}</div>
            </div>
        </div>
        <div class="stat-card">
            <img src="{{ asset('icons/hot-leads.svg') }}" alt="Hot Leads" class="stat-icon">
            <div>
                <div class="stat-text">Hot Leads</div>
                <div class="stat-number">{{ $hotLeads }}</div>
            </div>
        </div>
        <div class="stat-card">
            <img src="{{ asset('icons/warm-leads.svg') }}" alt="Warm Leads" class="stat-icon">
            <div>
                <div class="stat-text">Warm Leads</div>
                <div class="stat-number">{{ $warmLeads }}</div>
            </div>
        </div>
        <div class="stat-card">
            <img src="{{ asset('icons/cold-leads.svg') }}" alt="Cold Leads" class="stat-icon">
            <div>
                <div class="stat-text">Cold Leads</div>
                <div class="stat-number">{{ $coldLeads }}</div>
            </div>
        </div>
        <div class="stat-card">
            <img src="{{ asset('icons/today-leads.svg') }}" alt="New Leads Today" class="stat-icon">
            <div>
                <div class="stat-text">Today Leads</div>
                <div class="stat-number">{{ $newLeadsToday }}</div>
            </div>
        </div>
    </div>


    <div class="stat-section">
        <div class="stat-title-dropdown">
            <div class="stat-title">Statistik</div>
            <div class="sort-by-dropdown">
                <div class="dd-title">Urutkan berdasarkan</div>
                <select id="sort-by" onchange="sortData()">
                    <option value="daily">Harian</option>
                    <option value="weekly">Mingguan</option>
                    <option value="monthly">Bulanan</option>
                </select>
            </div>
        </div>

        <div class="stat-chart">
            <div class="stacked-chart">
                <h3>Pencapaian Leads <span id="stacked-timeframe">Harian</span></h3>
                <canvas id="stacked-bar-chart" class="w-full h-20"></canvas>
            </div>

            <div class="chart-donut">
                <h3>Perbandingan Kategori Leads <span id="donut-timeframe">Harian</span></h3>
                <canvas id="donut-chart" class="w-full h-10"></canvas>
            </div>
        </div>
    </div>






    <!-- Data Leads Section -->
    <div class="leads-head flex items-center justify-between mb-4">
        <h2 class="text-black text-2xl font-medium leading-8">10 Data Leads Terkini</h2>
        <a href="{{ route('contacts.index') }}" class="text-blue-600 mr-10 text-lg font-normal leading-5 underline">Lihat
            Detail</a>
    </div>

    <div class="tabel-leads flex flex-col gap-4 p-4 border border-[#EAECF0] rounded-xl">
        <!-- Tabel daftar kontak -->
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
                            <span
                                class="inline-block px-[5px] py-[5px] rounded text-white whitespace-nowrap w-[100px] text-center {{ $contact->lead_status == 'Hot Leads'
                                    ? 'bg-[#F54A45]'
                                    : ($contact->lead_status == 'Warm Leads'
                                        ? 'bg-[#FF931E]'
                                        : 'bg-[#0549CF]') }}">
                                {{ $contact->lead_status }}
                            </span>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="px-4 py-2 text-center text-2xl">No contacts found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
