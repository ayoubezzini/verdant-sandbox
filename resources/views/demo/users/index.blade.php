@extends('layouts.app')

@section('title', 'Users')

@section('content')
    <x-v-dynamic-table.container :data="$table" emptyText="No users found." />
@endsection
