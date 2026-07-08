<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Tables\UsersTable;
use Dennenboom\VerdantUI\Contracts\DynamicTablePreferencesStore;
use Dennenboom\VerdantUI\Tables\Column;
use Dennenboom\VerdantUI\Tables\DynamicTableQuery;
use Dennenboom\VerdantUI\Tables\DynamicTableQueryApplier;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DemoUsersController extends Controller
{
    public function index(DynamicTablePreferencesStore $preferencesStore): View
    {
        $columns = UsersTable::queryColumns();
        $filters = UsersTable::queryFilters();

        DynamicTableQuery::restoreFromStore($preferencesStore, 'demo-users', $filters);

        $tableQuery = DynamicTableQuery::fromRequest(
            filters: $filters,
            allowedSortKeys: Column::sortableKeys($columns),
            defaultPerPage: 15,
        );

        $tableQuery->saveTo($preferencesStore, 'demo-users');

        $query = User::query();

        DynamicTableQueryApplier::apply(
            $query,
            $tableQuery,
            columns: $columns,
            filters: $filters,
        );

        $users = $query->paginate($tableQuery->perPage ?? 15)->withQueryString();

        $table = UsersTable::make($users)
            ->withFilters($filters)
            ->withSearchableColumns(Column::searchableKeys($columns))
            ->withRowOpenUrl(fn (User $user) => route('demo.users.edit', $user))
            ->withSorting($tableQuery->sort)
            ->withColumnVisibility('demo-users', null)
            ->withColumnOrder()
            ->withPersistentPreferences(
                store: $preferencesStore,
                saveUrl: route('table-preferences.store', ['key' => 'demo-users']),
            );

        return view('demo.users.index', ['table' => $table]);
    }

    public function edit(User $user): View
    {
        return view('demo.users.edit', ['user' => $user]);
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'role' => ['required', 'in:admin,manager,member'],
        ]);

        $user->update([
            'name' => $validated['name'],
            'role' => $validated['role'],
            'active' => $request->boolean('active'),
        ]);

        return redirect()->route('demo.users.index')->with('status', "Updated {$user->name}.");
    }

    public function bulkUpdate(Request $request): RedirectResponse
    {
        $ids = $request->input('_ids', []);
        $update = [];

        if ($request->filled('role')) {
            $update['role'] = $request->input('role');
        }

        if ($request->filled('active')) {
            $update['active'] = $request->input('active') === '1';
        }

        if ($update !== [] && $ids !== []) {
            User::whereIn('id', $ids)->update($update);
        }

        return redirect()->route('demo.users.index')->with('status', 'Updated ' . count($ids) . ' user(s).');
    }
}
