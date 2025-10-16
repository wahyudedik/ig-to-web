<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Testimonial Link Expired</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="bg-gray-50">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div class="text-center">
                <div class="mx-auto h-16 w-16 bg-red-100 rounded-full flex items-center justify-center mb-4">
                    <i class="fas fa-clock text-red-600 text-2xl"></i>
                </div>
                <h2 class="text-3xl font-bold text-gray-900 mb-2">Link Expired</h2>
                <p class="text-gray-600 mb-6">
                    This testimonial link has expired and is no longer accepting submissions.
                </p>

                <div class="bg-gray-100 rounded-lg p-4 mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $link->title }}</h3>
                    @if ($link->description)
                        <p class="text-gray-600 text-sm mb-2">{{ $link->description }}</p>
                    @endif
                    <div class="text-sm text-gray-500">
                        <p><strong>Expired:</strong> {{ $link->active_until->format('M d, Y H:i') }}</p>
                        <p><strong>Submissions:</strong> {{ $link->current_submissions }}</p>
                    </div>
                </div>

                <div class="space-y-4">
                    <a href="/"
                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="fas fa-home mr-2"></i>
                        Back to Home
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
