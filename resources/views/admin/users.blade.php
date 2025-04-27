@extends('layouts.app')

@section('title', 'User Management')

@section('main')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">All Users</h1>

    <table class="w-full table-auto border border-gray-300 rounded">
        <thead class="bg-gray-200">
            <tr>
                <th class="p-2">#</th>
                <th class="p-2">Name</th>
                <th class="p-2">Email</th>
                <th class="p-2">Role</th>
                <th class="p-2">Approved</th>
                <th class="p-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $index => $user)
                <tr class="border-t">
                    <td class="p-2">{{ $index + 1 }}</td>
                    <td class="p-2">{{ $user->name }}</td>
                    <td class="p-2">{{ $user->email }}</td>
                    <td class="p-2">{{ ucfirst($user->role) }}</td>
                    <td class="p-2">
                        @if ($user->role === 'author')
                            {{ $user->is_approved ? '✅ Yes' : '⏳ No' }}
                        @else
                            -
                        @endif
                    </td>
                    <td class="p-2 text-sm">
                        <!-- You can add buttons like Edit, Delete, or Promote -->
                        <a href="#" class="text-blue-600 hover:underline">Edit</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
