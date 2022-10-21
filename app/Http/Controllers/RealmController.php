<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRealmRequest;
use App\Http\Requests\UpdateRealmRequest;
use App\Models\Realm;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class RealmController extends Controller
{
    public function index(): View
    {
        return view('admin.realms.index', [
            'realms' => Realm::orderBy('name')->paginate(10),
        ]);
    }

    public function show(Realm $realm): View
    {
        return view('admin.realms.show', [
            'realm' => $realm,
        ]);
    }

    public function create(): View
    {
        return view('admin.realms.create');
    }

    public function store(StoreRealmRequest $request): RedirectResponse
    {
        Realm::create($request->only(['name']));

        return redirect(route('admin.realms.index'));
    }

    public function edit(Realm $realm): View
    {
        return view('admin.realms.edit', [
            'realm' => $realm,
        ]);
    }

    public function update(UpdateRealmRequest $request, Realm $realm): RedirectResponse
    {
        $realm->update($request->only(['name']));

        return redirect(route('admin.realms.edit', ['realm' => $realm->id]))
            ->with('status', ['message' => 'admin.global.confirmation.updated', 'params' => ['resource' => 'Realm']]);
    }

    public function destroy(Realm $realm): RedirectResponse
    {
        $realm->delete();

        return redirect(route('admin.realms.index'));
    }
}
