<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function index()
    {
        $stores = Store::latest()->paginate(12);

        return view('admin.stores.index', compact('stores'));
    }

    public function create()
    {
        return view('admin.stores.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|min:3',
            'tagline'=>'nullable|string',
            'whatsapp'=>'nullable|string',
            'logo'=>'nullable|image'
        ]);

        $path = null;
        if ($request->hasFile('logo')){
            $path = $request->file('logo')->store('logos','public');
        }

        Store::create([
            'name'=>$request->name,
            'tagline'=>$request->tagline,
            'whatsapp'=>$request->whatsapp,
            'logo_url'=>$path,
        ]);

        return redirect()->route('admin.stores.index')
            ->with('success','Toko berhasil ditambahkan 🎉');
    }

    public function edit(Store $store)
    {
        return view('admin.stores.edit', compact('store'));
    }

    public function update(Request $request, Store $store)
    {
        $request->validate([
            'name'=>'required',
            'tagline'=>'nullable',
            'whatsapp'=>'nullable',
            'logo'=>'nullable|image',
        ]);

        if ($request->hasFile('logo')){
            $path = $request->file('logo')->store('logos','public');
            $store->logo_url = $path;
        }

        $store->name = $request->name;
        $store->tagline = $request->tagline;
        $store->whatsapp = $request->whatsapp;
        $store->save();

        return redirect()->route('admin.stores.index')
            ->with('success','Toko berhasil diperbarui ✨');
    }

    public function destroy(Store $store)
    {
        $store->delete();

        return back()->with('success','Toko berhasil dihapus ❌');
    }
}
