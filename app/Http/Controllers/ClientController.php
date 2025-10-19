<?php

namespace App\Http\Controllers;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index(Request $request)
{
    $query = Client::query();

    if ($request->filled('search')) {
        $search = $request->search;
        $query->where('name', 'like', "%$search%")
              ->orWhere('phone', 'like', "%$search%");
    }

    $clients = $query->latest()->paginate(10);

    return view('clients.index', compact('clients'));
}


    public function create()
    {
        return view('clients.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'phone'   => 'required|string|max:20|unique:clients,phone',
            'address' => 'nullable|string',
            'notes'   => 'nullable|string',
        ]);

        Client::create($request->all());

        return redirect()->route('clients.index')->with('success', '✅ تم إضافة العميل بنجاح');
    }

    public function edit(Client $client)
    {
        return view('clients.edit', compact('client'));
    }

    public function show(Client $client)
    {
        return view('clients.show', compact('client'));
    }
    public function update(Request $request, Client $client)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'phone'   => 'required|string|max:20|unique:clients,phone,' . $client->id,
            'address' => 'nullable|string',
            'notes'   => 'nullable|string',
        ]);

        $client->update($request->all());

        return redirect()->route('clients.index')->with('success', '✅ تم تعديل بيانات العميل');
    }
}
