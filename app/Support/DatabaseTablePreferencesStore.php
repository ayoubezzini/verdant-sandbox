<?php

namespace App\Support;

use Dennenboom\VerdantUI\Contracts\DynamicTablePreferencesStore;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DatabaseTablePreferencesStore implements DynamicTablePreferencesStore
{
    public function get(string $key): ?array
    {
        $row = DB::table('user_table_preferences')
            ->where('user_id', Auth::id())
            ->where('table_key', $key)
            ->first();

        return $row ? json_decode($row->preferences, true) : null;
    }

    public function put(string $key, array $preferences): void
    {
        DB::table('user_table_preferences')->updateOrInsert(
            ['user_id' => Auth::id(), 'table_key' => $key],
            ['preferences' => json_encode($preferences), 'updated_at' => now()],
        );
    }
}
