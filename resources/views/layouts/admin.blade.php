<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="stylesheet" href="{{ asset('css/admin/style_admin_pending.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/style_admin.css') }}">

</head>
<body class="bg-gray-100 flex h-screen overflow-hidden">

    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-lg hidden md:block">
        <div class="p-6 font-bold text-2xl text-blue-600">
            Admin Panel
        </div>
        <nav class="mt-10 space-y-4 text-gray-700">
            <a href="{{ route('admin.users') }}" class="flex items-center p-3 hover:bg-blue-100 rounded-md mx-4">
                <span class="text-lg mr-3">👤</span> <span>User Management</span>
            </a>
            <a href="{{ route('admin.books') }}" class="flex items-center p-3 hover:bg-blue-100 rounded-md mx-4">
                <span class="text-lg mr-3">📚</span> <span>Book Management</span>
            </a>
            <a href="{{ route('admin.categories') }}" class="flex items-center p-3 hover:bg-blue-100 rounded-md mx-4">
                <span class="text-lg mr-3">🗂️</span> <span>Category/Genre Management</span>
            </a>
            <a href="{{ route('admin.subscriptions') }}" class="flex items-center p-3 hover:bg-blue-100 rounded-md mx-4">
                <span class="text-lg mr-3">💳</span> <span>Subscription Management</span>
            </a>
            <a href="{{ route('admin.analytics') }}" class="flex items-center p-3 hover:bg-blue-100 rounded-md mx-4">
                <span class="text-lg mr-3">📈</span> <span>Analytics</span>
            </a>
            <a href="{{ route('admin.feedback') }}" class="flex items-center p-3 hover:bg-blue-100 rounded-md mx-4">
                <span class="text-lg mr-3">📬</span> <span>Feedback/Reports</span>
            </a>
            <a href="{{ route('admin.settings') }}" class="flex items-center p-3 hover:bg-blue-100 rounded-md mx-4">
                <span class="text-lg mr-3">⚙️</span> <span>Site Settings</span>
            </a>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden">
        
        <!-- Header -->
        <header class="bg-white shadow-md h-16 flex items-center justify-between px-6">
            <div class="text-xl font-semibold text-gray-800">
                @yield('page-title', 'Dashboard')
            </div>
            <div class="flex items-center space-x-4">
                <span class="text-gray-600">Hello, {{ Auth::user()->name }}</span>
                <form action="{{ route('account.logout') }}" method="POST">
                    @csrf
                    <button class="bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded-md text-sm">
                        Logout
                    </button>
                </form>
            </div>
        </header>

        <!-- Content -->
        @yield('main')

        <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
      
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
        <script src="https://cdn.ckeditor.com/4.20.1/standard/ckeditor.js"></script>
        <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
        @yield('script')
    </div>

</body>
</html>
