<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ContactsExport implements FromView
{
    protected $contacts;

    public function __construct($contacts)
    {
        $this->contacts = $contacts;
    }

    public function view(): View
    {
        return view('contacts.excel', [
            'contacts' => $this->contacts
        ]);
    }
}
