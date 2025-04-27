@extends('layouts.admin.app')

@section('main')
<link rel="stylesheet" href="{{ asset('css/admin/style_admin_pending.css') }}">
    <h1>Pending Authors</h1>
    <!-- Toggle Button for Admin to switch between Auto and Manual approval -->
    <form method="POST" action="{{ route('admin.toggleApprovalMode', 'auto') }}" class="inline">
    @csrf
    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded mr-2">
        Set to Auto Approval
    </button>
    </form>

    <form method="POST" action="{{ route('admin.toggleApprovalMode', 'manual') }}" class="inline">
        @csrf
        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">
            Set to Manual Approval
        </button>
    </form>

<p class="mt-2">Current Mode: <strong>{{ ucfirst($mode) }}</strong></p>


    <!-- List of authors who are waiting for approval -->
    @foreach($authors as $author)
        <div class="p-4 border mb-4 rounded shadow">
            <p><strong>Name:</strong> {{ $author->name }}</p>
            <p><strong>Email:</strong> {{ $author->email }}</p>

            <!-- Show the buttons based on the current approval mode -->
            @if($mode == 'manual')
                <form method="POST" action="{{ route('admin.approveAuthor', $author->id) }}" class="inline">
                    @csrf
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Approve Author</button>
                </form>
            @elseif($mode == 'auto')
                <form method="POST" action="{{ route('admin.autoApproveAuthor', $author->id) }}" class="inline ml-2">
                    @csrf
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Auto Approve</button>
                </form>
            @endif
        </div>
    @endforeach
@endsection
