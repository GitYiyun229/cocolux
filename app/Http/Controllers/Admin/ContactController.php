<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ContactDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param ContactDataTable $dataTable
     * @return mixed
     */
    public function index(ContactDataTable $dataTable)
    {
        return $dataTable->render('admin.contact.index');
    }
}
