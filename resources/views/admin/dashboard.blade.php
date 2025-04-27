@extends('layouts.admin')

@section('main')
<link rel="stylesheet" href="{{ asset('css/admin/style_admin.css') }}">

<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Admin Dashboard</h1>

    <!-- Dashboard Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg shadow hover:shadow-md transition">
            <h4 class="text-sm font-semibold text-gray-500 mb-2">Total Users</h4>
            <p class="text-2xl font-bold text-blue-600">500</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow hover:shadow-md transition">
            <h4 class="text-sm font-semibold text-gray-500 mb-2">Total Books</h4>
            <p class="text-2xl font-bold text-green-600">125</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow hover:shadow-md transition">
            <h4 class="text-sm font-semibold text-gray-500 mb-2">Total Subscriptions</h4>
            <p class="text-2xl font-bold text-purple-600">300</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow hover:shadow-md transition">
            <h4 class="text-sm font-semibold text-gray-500 mb-2">Total Likes/Views</h4>
            <p class="text-2xl font-bold text-pink-600">1000</p>
        </div>
    </div>

    <!-- Quick Management Links -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <a href="{{ route('admin.users') }}" class="bg-white p-6 rounded-lg shadow hover:bg-gray-50 transition">
            <h2 class="text-lg font-semibold text-gray-700 mb-2">Manage Users</h2>
            <p class="text-gray-500 text-sm">View and manage all registered users.</p>
        </a>

        <a href="{{ route('admin.pendingAuthors') }}" class="bg-white p-6 rounded-lg shadow hover:bg-gray-50 transition">
            <h2 class="text-lg font-semibold text-gray-700 mb-2">Pending Authors</h2>
            <p class="text-gray-500 text-sm">Approve or reject new author requests.</p>
        </a>
    </div>

    <!-- Current Approval Mode -->
    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">Author Approval Mode</h2>
        <p class="text-gray-600">
            Current Approval Mode: 
            <span class="font-semibold text-blue-600">{{ ucfirst($mode) }}</span>
        </p>
    </div>

    <!-- Graphs Section (Placeholder) -->
    <div class="mt-10">
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">Analytics Graphs</h2>
            <p class="text-gray-500">Charts will be added here soon (e.g., using Chart.js or ApexCharts).</p>
        </div>
    </div>
</div>
@endsection
