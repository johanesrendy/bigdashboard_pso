<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Imports\ContactsImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Exports\ContactsExport;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{

    // Menampilkan daftar kontak dengan pencarian, filter, dan pengurutan
    public function index(Request $request)
    {
        $query = Contact::query();

        // Pencarian
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('company_name', 'like', "%{$search}%")
                    ->orWhere('individual_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('job_title', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%")
                    ->orWhere('date_added', 'like', "%{$search}%")
                    ->orWhere('lead_status', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan lead_status
        if ($request->filled('lead_status')) {
            $leadStatus = $request->input('lead_status');
            if (in_array($leadStatus, ['Hot Leads', 'Warm Leads', 'Cold Leads'])) {
                $query->where('lead_status', $leadStatus);
            }
        }

        // Pengurutan berdasarkan tanggal
        $sortOrder = $request->input('sort', 'asc'); // default ke 'asc'
        if (in_array($sortOrder, ['asc', 'desc'])) {
            $query->orderBy('created_at', $sortOrder);
        }

        // Filter untuk kontak yang tidak di-follow up lebih dari 7 hari
        if ($request->has('unfollowed') && $request->input('unfollowed') == 'true') {
            $query->where('updated_at', '<=', now()->subDays(7)); // Kontak yang tidak ada perubahan status setelah 7 hari
        }

        // Mengambil data kontak dengan pagination
        $contacts = $query->paginate(10);

        // Statistik Ringkasan
        $totalLeads = Contact::count();
        $hotLeads = Contact::where('lead_status', 'Hot Leads')->count();
        $warmLeads = Contact::where('lead_status', 'Warm Leads')->count();
        $coldLeads = Contact::where('lead_status', 'Cold Leads')->count();
        $newLeadsToday = Contact::whereDate('date_added', now()->toDateString())->count();



        // Ambil nama pengguna
        $userName = Auth::user()->name;
        $role = Auth::user()->role;

        $logs = ActivityLog::with('user')->paginate(10);

        return view('contacts.index', compact('contacts', 'totalLeads', 'hotLeads', 'warmLeads', 'coldLeads', 'newLeadsToday', 'userName', 'logs', 'role'));
    }


    // Menampilkan formulir untuk menambahkan kontak baru
    public function form()
    {
        return view('contacts.form');
    }

    public function import()
    {
        return view('contacts.import');
    }

    public function importPost(Request $request)
    {
        // Validasi file upload
        $request->validate([
            'file' => 'required|mimes:xls,xlsx|max:2048',
        ]);

        // Dapatkan nama file yang di-upload
        $fileName = $request->file('file')->getClientOriginalName();

        // Lakukan proses import menggunakan Excel::import
        Excel::import(new ContactsImport, $request->file('file'));

        // Simpan log aktivitas dengan nama file yang diimport
        $this->logActivity(
            'Import Data',
            'Mengimport kontak baru dari file: ' . $fileName,
            Auth::user()->id,
            Auth::user()->role
        );

        // Redirect ke halaman kontak setelah berhasil di-import
        return redirect()->route('contacts.index');
    }


    // Export data leads
    public function export()
    {
        return view('contacts.export');
    }

    public function exportData(Request $request)
    {
        // Ambil filter dari request (status lead atau rentang tanggal)
        $query = Contact::query();

        if ($request->lead_status) {
            $query->where('lead_status', $request->lead_status);
        }

        if ($request->from_date && $request->to_date) {
            $query->whereBetween('date_added', [$request->from_date, $request->to_date]);
        }

        $contacts = $query->get();

        // Jika data kosong, kembalikan dengan pesan error
        if ($contacts->isEmpty()) {
            return back()->with('error', 'No data available for export with the selected filters.');
        }

        // Tentukan format yang diinginkan
        $format = $request->input('format');


        if ($format == 'csv' || $format == 'xls') {
            return Excel::download(new ContactsExport($contacts), 'contacts.' . $format);
        }

        if ($format == 'pdf') {
            $pdf = Pdf::loadView('contacts.pdf', ['contacts' => $contacts])->setPaper('a4', 'landscape');
            return $pdf->download('contacts.pdf');
        }

        // Setelah data berhasil di-export, simpan log aktivitas
        $this->logActivity('Export Data', 'Mengekspor data kontak', Auth::user()->id, Auth::user()->role);

        return back()->with('error', 'Format tidak didukung');
    }


    // Menyimpan kontak baru
    public function store(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'company_type' => 'required|string|max:255',
            'individual_name' => 'required|string|max:255',
            'email' => 'required|email|unique:contacts,email',
            'phone' => 'required|string|max:20',
            'job_title' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'date_added' => 'required|date',
        ]);

        // Membuat kontak baru
        $contact = Contact::create($request->all());
        // Menyimpan detail kontak yang baru ditambahkan
        $contactDetails = "ID: {$contact->id}, Name: {$contact->individual_name}, Company: {$contact->company_name}, Email: {$contact->email}";

        // Simpan log aktivitas dengan detail
        $this->logActivity('Tambah Data', " {$contactDetails}", Auth::user()->id, Auth::user()->role);

        return redirect()->route('contacts.index')->with('success', 'Contact added successfully.');
    }

    // Menampilkan detail kontak
    public function detailContact($id)
    {
        $contact = Contact::findOrFail($id);
        return view('contacts.detailContact', compact('contact'));
    }

    // Menampilkan formulir untuk mengedit kontak
    public function getContact($id)
    {
        $contact = Contact::findOrFail($id);
        return response()->json($contact);
    }

    public function editForm($id)
    {
        $contact = Contact::findOrFail($id);
        return response()->json($contact);
    }


    // Memperbarui kontak yang ada
    public function update(Request $request, $id)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'company_type' => 'required|string|max:255',
            'individual_name' => 'required|string|max:255',
            'email' => 'required|email|unique:contacts,email,' . $id,
            'phone' => 'required|string|max:20',
            'job_title' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'date_added' => 'required|date',
        ]);

        $contact = Contact::findOrFail($id);
        $oldData = $contact->toArray(); // Data lama sebelum perubahan
        $contact->update($request->all());
        $newData = $contact->toArray(); // Data baru setelah perubahan

        // Mencatat detail perubahan
        $details = $this->generateChangeDetails($oldData, $newData);

        // Simpan log aktivitas
        $this->logActivity('Edit Data', $details, Auth::user()->id, Auth::user()->role);


        return redirect()->route('contacts.index')->with('success', 'Contact updated successfully.');
    }

    private function generateChangeDetails($oldData, $newData)
    {
        $changes = [];

        $ignoreFields = ['updated_at'];
        foreach ($newData as $key => $newValue) {
            if (in_array($key, $ignoreFields)) {
                continue; // Lewati kolom yang tidak perlu dipantau
            }

            $oldValue = $oldData[$key] ?? '';
            if ($oldValue != $newValue) {
                $changes[] = "{$key} diubah dari '{$oldValue}' menjadi '{$newValue}'";
            }
        }
        return implode(', ', $changes);
    }
    // Menghapus kontak
    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        // Menyimpan detail sebelum dihapus
        $contactDetails = "ID: {$contact->id}, Name: {$contact->individual_name}, Company: {$contact->company_name}";
        $contact->delete();

        // Simpan log aktivitas dengan detail
        $this->logActivity('Hapus Data', "{$contactDetails}", Auth::user()->id, Auth::user()->role);

        return redirect()->route('data.leads')->with('success', 'Contact deleted successfully.');
    }

    private function logActivity($activity, $details, $userId, $role)
    {
        ActivityLog::create([
            'admin_id' => $userId,
            'activity' => $activity,
            'role' => $role,
            'details' => $details,
        ]);
    }

    // ContactController.php
    public function updateLeadStatus(Request $request, $id)
    {
        $request->validate([
            'lead_status' => 'required|string|in:Hot Leads,Warm Leads,Cold Leads',
        ]);

        // Ambil kontak berdasarkan ID
        $contact = Contact::findOrFail($id);

        // Update status lead
        $contact->lead_status = $request->input('lead_status');
        $contact->save();

        // Simpan log aktivitas dengan informasi tambahan id, name, dan company
        $this->logActivity(
            'Ubah Status Lead',

            '  ID: ' . $contact->id .
                ', Name: ' . $contact->individual_name .
                ', Company: ' . $contact->company_name . ' status lead menjadi ' . $contact->lead_status,
            Auth::user()->id,
            Auth::user()->role
        );

        return redirect()->route('contacts.index')->with('status', 'Lead status updated successfully.');
    }


    // Fungsi untuk mendapatkan kontak yang belum ditindaklanjuti


    public function lost_data()
    {
        return view('contacts.lostData');
    }

    public function tracker(Request $request)
    {
        $query = Contact::query();

        // Pencarian
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('company_name', 'like', "%{$search}%")
                    ->orWhere('individual_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('job_title', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%")
                    ->orWhere('date_added', 'like', "%{$search}%")
                    ->orWhere('lead_status', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan lead_status
        if ($request->filled('lead_status')) {
            $leadStatus = $request->input('lead_status');
            if (in_array($leadStatus, ['Hot Leads', 'Warm Leads', 'Cold Leads'])) {
                $query->where('lead_status', $leadStatus);
            }
        }

        // Pengurutan berdasarkan tanggal
        $sortOrder = $request->input('sort', 'asc'); // default ke 'asc'
        if (in_array($sortOrder, ['asc', 'desc'])) {
            $query->orderBy('created_at', $sortOrder);
        }

        // Mengambil data kontak dengan pagination
        $contacts = $query->paginate(10);

        // Statistik Ringkasan
        $totalLeads = Contact::count();
        $hotLeads = Contact::where('lead_status', 'Hot Leads')->count();
        $warmLeads = Contact::where('lead_status', 'Warm Leads')->count();
        $coldLeads = Contact::where('lead_status', 'Cold Leads')->count();
        $newLeadsToday = Contact::whereDate('date_added', now()->toDateString())->count();

        // Ambil nama pengguna
        $userName = Auth::user()->name;
        $role = Auth::user()->role;

        return view('contacts.dataTracker', compact('contacts', 'totalLeads', 'hotLeads', 'warmLeads', 'coldLeads', 'newLeadsToday', 'userName', 'role'));
    }


    public function leads(Request $request)
    {
        $query = Contact::query();

        // Pencarian
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('company_name', 'like', "%{$search}%")
                    ->orWhere('individual_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('job_title', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%")
                    ->orWhere('date_added', 'like', "%{$search}%")
                    ->orWhere('lead_status', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan lead_status
        if ($request->filled('lead_status')) {
            $leadStatus = $request->input('lead_status');
            if (in_array($leadStatus, ['Hot Leads', 'Warm Leads', 'Cold Leads'])) {
                $query->where('lead_status', $leadStatus);
            }
        }

        // Pengurutan berdasarkan tanggal
        $sortOrder = $request->input('sort', 'asc'); // default ke 'asc'
        if (in_array($sortOrder, ['asc', 'desc'])) {
            $query->orderBy('created_at', $sortOrder);
        }

        // Mengambil data kontak dengan pagination
        $contacts = $query->paginate(10);

        // Statistik Ringkasan
        $totalLeads = Contact::count();
        $hotLeads = Contact::where('lead_status', 'Hot Leads')->count();
        $warmLeads = Contact::where('lead_status', 'Warm Leads')->count();
        $coldLeads = Contact::where('lead_status', 'Cold Leads')->count();
        $newLeadsToday = Contact::whereDate('date_added', now()->toDateString())->count();

        // Ambil nama pengguna
        $userName = Auth::user()->name;
        $role = Auth::user()->role;

        // Kembalikan view dengan data kontak dan paginasi
        return view('contacts.leads', [
            'contacts' => $contacts,
            'totalLeads' => $totalLeads,
            'hotLeads' => $hotLeads,
            'warmLeads' => $warmLeads,
            'coldLeads' => $coldLeads,
            'newLeadsToday' => $newLeadsToday,
            'userName' => $userName,
            'role' => $role,
        ]);
    }


}
