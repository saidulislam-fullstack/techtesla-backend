<?php

namespace App\Http\Controllers;

use App\Models\RequestedQuotation;
use Illuminate\Http\Request;

class RequestedQuotationController extends Controller
{
    /**
     * RequestedQuotationController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:rf-quotes-index')->only('index', 'show');
        $this->middleware('permission:rf-quotes-add')->only('create', 'store');
        // $this->middleware('permission:rf-quotes-edit')->only('edit', 'update');
        // $this->middleware('permission:rf-quotes-delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('backend.rf-quotation.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.rf-quotation.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(RequestedQuotation $requestedQuotation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RequestedQuotation $requestedQuotation)
    {
        return view('backend.rf-quotation.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RequestedQuotation $requestedQuotation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RequestedQuotation $requestedQuotation)
    {
        //
    }
}
