<?php

namespace App\Http\Controllers;

class InventoryDispatchController extends Controller
{
    public function index()
    {
        return view('pages.inventory-dispatches.index');
    }

    public function create()
    {
        return view('pages.inventory-dispatches.create');
    }

    public function show(int $id)
    {
        return view('pages.inventory-dispatches.show', ['id' => $id]);
    }
}
