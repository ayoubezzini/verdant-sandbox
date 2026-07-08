@extends('layouts.app')

@section('title', 'Edit user')

@section('content')
    <div class="v-max-w-lg v-bg-surface v-border dark:v-border-gray-700 v-rounded v-p-6">
        <h2 class="v-text-lg v-font-semibold v-text-gray-900 dark:v-text-gray-100 v-mb-4">
            Edit {{ $user->name }}
        </h2>

        <form method="POST" action="{{ route('demo.users.update', $user) }}" class="v-space-y-4">
            @csrf
            @method('PUT')

            <x-v-form.input name="name" label="Name" :value="old('name', $user->name)" />
            <x-v-form.input name="email" label="Email" :value="$user->email" disabled />

            <x-v-form.select
                name="role"
                label="Role"
                :options="[
                    ['value' => 'admin', 'label' => 'Admin'],
                    ['value' => 'manager', 'label' => 'Manager'],
                    ['value' => 'member', 'label' => 'Member'],
                ]"
                :selected="old('role', $user->role)"
                :first_empty="false"
            />

            <x-v-form.checkbox name="active" label="Active" value="1" :checked="old('active', $user->active)" />

            <div class="v-flex v-justify-between v-pt-2">
                <x-v-button.light href="{{ route('demo.users.index') }}">Cancel</x-v-button.light>
                <x-v-button.primary type="submit">Save</x-v-button.primary>
            </div>
        </form>
    </div>
@endsection
