<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Models\Client;
use App\Models\Realm;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ClientController extends Controller
{
    public function index(Realm $realm): View
    {
        return view('admin.clients.index', [
            'realm' => $realm,
            'clients' => $realm->clients()->paginate(20),
        ]);
    }

    public function create(Realm $realm): View
    {
        return view('admin.clients.create', [
            'realm' => $realm,
        ]);
    }

    public function store(StoreClientRequest $request, Realm $realm): RedirectResponse
    {
        $clientSecret = Str::random();

        Client::create([
            'name' => $request->string('name'),
            'clientId' => Str::uuid(),
            'clientSecret' => md5($clientSecret),
            'realm_id' => $realm->id,
        ]);

        return redirect(route('admin.realms.clients.index', ['realm' => $realm]))->with('clientSecret', $clientSecret);
    }

    public function show(Realm $realm, Client $client): View
    {
        return view('admin.clients.show', [
            'realm' => $realm,
            'client' => $client,
        ]);
    }

    public function edit(Realm $realm, Client $client): View
    {
        return view('admin.clients.edit', [
            'realm' => $realm,
            'client' => $client,
        ]);
    }

    public function update(UpdateClientRequest $request, Realm $realm, Client $client): RedirectResponse
    {
        $client->update($request->only(['name']));

        return redirect(route('admin.realms.clients.index', ['realm' => $realm]))
            ->with('status', ['message' => 'admin.global.confirmation.updated', 'params' => ['resource' => sprintf('Client "%s"', $client->name)]]);
    }

    public function destroy(Realm $realm, Client $client): RedirectResponse
    {
        $client->delete();

        return redirect(route('admin.realms.clients.index', ['realm' => $realm]))
            ->with('status', ['message' => 'admin.global.confirmation.deleted', 'params' => ['resource' => sprintf('Client "%s"', $client->name)]]);
    }
}
