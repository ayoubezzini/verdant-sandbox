<?php

namespace App\Tables;

use App\Models\User;
use Dennenboom\VerdantUI\Tables\BaseTable;
use Dennenboom\VerdantUI\Tables\BulkField;
use Dennenboom\VerdantUI\Tables\Column;
use Dennenboom\VerdantUI\Tables\Filter;

class UsersTable extends BaseTable
{
    /**
     * @return array<int, Column>
     */
    public static function queryColumns(): array
    {
        return [
            Column::make('name', 'Name')->default()->sortable()->searchable()->width('16rem'),
            Column::make('email', 'Email')->default()->sortable()->searchable(),
            Column::make('role', 'Role')
                ->default()
                ->sortable()
                ->format(static fn (string $role) => ucfirst($role))
                ->width('10rem'),
            Column::make('active', 'Active')
                ->default()
                ->sortable()
                ->format(static fn (bool $active) => $active ? 'Yes' : 'No')
                ->width('8rem')
                ->align('center'),
            Column::make('created_at', 'Joined')
                ->sortable()
                ->format(static fn (string $value) => \Illuminate\Support\Carbon::parse($value)->format('Y-m-d'))
                ->width('10rem'),
        ];
    }

    /**
     * @return array<int, Filter>
     */
    public static function queryFilters(): array
    {
        return [
            Filter::make('role', 'Role', 'select')
                ->multiple()
                ->options([
                    ['value' => 'admin', 'label' => 'Admin'],
                    ['value' => 'manager', 'label' => 'Manager'],
                    ['value' => 'member', 'label' => 'Member'],
                ]),
            Filter::make('active', 'Active only', 'checkbox'),
            Filter::make('q', 'Keyword', 'text')->placeholder('Search…'),
        ];
    }

    protected static function columns(): array
    {
        return static::queryColumns();
    }

    protected static function actions(): ?callable
    {
        return static fn (User $user) => [
            ['label' => 'Edit', 'route' => 'demo.users.edit', 'params' => ['user' => 'id'], 'button' => 'secondary'],
        ];
    }

    protected static function bulkFields(): array
    {
        return [
            BulkField::make('role', 'Role', 'select')
                ->options([
                    ['value' => 'admin', 'label' => 'Admin'],
                    ['value' => 'manager', 'label' => 'Manager'],
                    ['value' => 'member', 'label' => 'Member'],
                ]),
            BulkField::make('active', 'Active', 'select')
                ->options([
                    ['value' => '1', 'label' => 'Yes'],
                    ['value' => '0', 'label' => 'No'],
                ]),
        ];
    }

    protected static function bulkActionUrl(): ?string
    {
        return route('demo.users.bulk-update');
    }
}
