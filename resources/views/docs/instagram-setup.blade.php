<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Instagram API Setup Guide - Website Sekolah</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <style>
            /* Include the existing Tailwind CSS here */
        </style>
    @endif

    <style>
        .instagram-gradient {
            background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%);
        }

        .step-card {
            transition: all 0.3s ease;
        }

        .step-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .code-block {
            background-color: #1f2937;
            color: #f9fafb;
            padding: 1rem;
            border-radius: 0.5rem;
            font-family: 'Courier New', monospace;
            overflow-x: auto;
        }

        .warning-box {
            background-color: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 1rem;
            margin: 1rem 0;
        }

        .success-box {
            background-color: #d1fae5;
            border-left: 4px solid #10b981;
            padding: 1rem;
            margin: 1rem 0;
        }
    </style>
</head>

<body class="bg-gray-50 dark:bg-gray-900">
    <!-- Navigation -->
    <nav class="bg-white dark:bg-gray-800 shadow-lg fixed w-full z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <a href="/" class="text-2xl font-bold text-gray-900 dark:text-white">
                            <i class="fas fa-graduation-cap text-blue-600 mr-2"></i>
                            Website Sekolah
                        </a>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="/kegiatan"
                        class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 px-3 py-2 rounded-md text-sm font-medium transition duration-300">
                        Instagram Feed
                    </a>
                    <a href="/superadmin/instagram-settings"
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium">
                        Settings
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Header Section -->
    <section class="pt-20 pb-8 bg-white dark:bg-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <div class="flex items-center justify-center mb-4">
                    <i class="fab fa-instagram text-3xl instagram-gradient mr-3"></i>
                    <h1 class="text-4xl font-bold text-gray-900 dark:text-white">Instagram API Setup Guide</h1>
                </div>
                <p class="text-xl text-gray-600 dark:text-gray-300 mb-6">
                    Step-by-step guide to integrate Instagram with your school's website
                </p>
            </div>
        </div>
    </section>

    <!-- Content -->
    <section class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Overview -->
            <div class="step-card bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 mb-8">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                    <i class="fas fa-info-circle text-blue-600 mr-2"></i>
                    Overview
                </h2>
                <p class="text-gray-700 dark:text-gray-300 mb-4">
                    This guide will help you set up Instagram API integration for your school's website.
                    The integration will automatically fetch and display your school's Instagram posts on the website.
                </p>
                <div class="success-box">
                    <p class="text-green-800">
                        <i class="fas fa-check-circle mr-2"></i>
                        <strong>What you'll get:</strong> Automatic Instagram feed display, analytics dashboard, and
                        content management tools.
                    </p>
                </div>
            </div>

            <!-- Prerequisites -->
            <div class="step-card bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 mb-8">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                    <i class="fas fa-list-check text-green-600 mr-2"></i>
                    Prerequisites
                </h2>
                <ul class="space-y-2 text-gray-700 dark:text-gray-300">
                    <li><i class="fas fa-check text-green-500 mr-2"></i> A Facebook Business account</li>
                    <li><i class="fas fa-check text-green-500 mr-2"></i> An Instagram Business account</li>
                    <li><i class="fas fa-check text-green-500 mr-2"></i> Access to Facebook Developer Console</li>
                    <li><i class="fas fa-check text-green-500 mr-2"></i> Superadmin access to your school's website</li>
                </ul>
            </div>

            <!-- Step 1 -->
            <div class="step-card bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 mb-8">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                    <span
                        class="bg-blue-600 text-white rounded-full w-8 h-8 inline-flex items-center justify-center text-sm font-bold mr-3">1</span>
                    Create Facebook App
                </h2>
                <ol class="space-y-4 text-gray-700 dark:text-gray-300">
                    <li>
                        <strong>Go to Facebook Developers:</strong>
                        <a href="https://developers.facebook.com" target="_blank"
                            class="text-blue-600 hover:text-blue-700 ml-2">
                            https://developers.facebook.com
                            <i class="fas fa-external-link-alt text-xs ml-1"></i>
                        </a>
                    </li>
                    <li>Click "My Apps" → "Create App"</li>
                    <li>Select "Consumer" as app type</li>
                    <li>Fill in your app details:
                        <div class="code-block mt-2">
                            App Name: Your School Name - Instagram Integration<br>
                            App Contact Email: your-email@school.com<br>
                            App Purpose: Educational institution social media integration
                        </div>
                    </li>
                    <li>Click "Create App"</li>
                </ol>
            </div>

            <!-- Step 2 -->
            <div class="step-card bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 mb-8">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                    <span
                        class="bg-blue-600 text-white rounded-full w-8 h-8 inline-flex items-center justify-center text-sm font-bold mr-3">2</span>
                    Add Instagram Basic Display Product
                </h2>
                <ol class="space-y-4 text-gray-700 dark:text-gray-300">
                    <li>In your app dashboard, click "Add Product"</li>
                    <li>Find "Instagram Basic Display" and click "Set Up"</li>
                    <li>You'll see the Instagram Basic Display product added to your app</li>
                </ol>
            </div>

            <!-- Step 3 -->
            <div class="step-card bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 mb-8">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                    <span
                        class="bg-blue-600 text-white rounded-full w-8 h-8 inline-flex items-center justify-center text-sm font-bold mr-3">3</span>
                    Configure Instagram Basic Display
                </h2>
                <ol class="space-y-4 text-gray-700 dark:text-gray-300">
                    <li>Go to "Instagram Basic Display" → "Basic Display"</li>
                    <li>Click "Create New App"</li>
                    <li>Fill in the required fields:
                        <div class="code-block mt-2">
                            Valid OAuth Redirect URIs: https://yourdomain.com/instagram/callback<br>
                            Deauthorize Callback URL: https://yourdomain.com/instagram/deauthorize<br>
                            Data Deletion Request URL: https://yourdomain.com/instagram/data-deletion
                        </div>
                    </li>
                    <li>Click "Create App"</li>
                </ol>
                <div class="warning-box">
                    <p class="text-yellow-800">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        <strong>Important:</strong> Replace "yourdomain.com" with your actual domain name.
                    </p>
                </div>
            </div>

            <!-- Step 4 -->
            <div class="step-card bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 mb-8">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                    <span
                        class="bg-blue-600 text-white rounded-full w-8 h-8 inline-flex items-center justify-center text-sm font-bold mr-3">4</span>
                    Get Access Token
                </h2>
                <ol class="space-y-4 text-gray-700 dark:text-gray-300">
                    <li>In your Instagram Basic Display app, go to "User Token Generator"</li>
                    <li>Click "Add or Remove Instagram Testers"</li>
                    <li>Add your Instagram account as a tester</li>
                    <li>Go back to "User Token Generator"</li>
                    <li>Click "Generate Token" next to your Instagram account</li>
                    <li>Copy the generated access token</li>
                </ol>
                <div class="success-box">
                    <p class="text-green-800">
                        <i class="fas fa-key mr-2"></i>
                        <strong>Access Token:</strong> This is what you'll need to enter in the website settings.
                    </p>
                </div>
            </div>

            <!-- Step 5 -->
            <div class="step-card bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 mb-8">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                    <span
                        class="bg-blue-600 text-white rounded-full w-8 h-8 inline-flex items-center justify-center text-sm font-bold mr-3">5</span>
                    Get User ID
                </h2>
                <ol class="space-y-4 text-gray-700 dark:text-gray-300">
                    <li>Use the Instagram Basic Display API to get your user ID</li>
                    <li>Make a GET request to:
                        <div class="code-block mt-2">
                            GET https://graph.instagram.com/me?fields=id&access_token=YOUR_ACCESS_TOKEN
                        </div>
                    </li>
                    <li>The response will contain your user ID</li>
                </ol>
                <div class="warning-box">
                    <p class="text-yellow-800">
                        <i class="fas fa-info-circle mr-2"></i>
                        <strong>Alternative:</strong> You can also find your User ID in the Instagram Basic Display
                        dashboard.
                    </p>
                </div>
            </div>

            <!-- Step 6 -->
            <div class="step-card bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 mb-8">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                    <span
                        class="bg-blue-600 text-white rounded-full w-8 h-8 inline-flex items-center justify-center text-sm font-bold mr-3">6</span>
                    Configure Website Settings
                </h2>
                <ol class="space-y-4 text-gray-700 dark:text-gray-300">
                    <li>Go to your school's website superadmin dashboard</li>
                    <li>Navigate to "Instagram Settings"</li>
                    <li>Enter the following information:
                        <ul class="ml-4 mt-2 space-y-2">
                            <li><strong>Access Token:</strong> The token you generated in Step 4</li>
                            <li><strong>User ID:</strong> The user ID you got in Step 5</li>
                            <li><strong>App ID:</strong> Your Facebook App ID (optional)</li>
                            <li><strong>App Secret:</strong> Your Facebook App Secret (optional)</li>
                        </ul>
                    </li>
                    <li>Click "Test Connection" to verify your settings</li>
                    <li>Click "Save Settings" to activate the integration</li>
                </ol>
            </div>

            <!-- Step 7 -->
            <div class="step-card bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 mb-8">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                    <span
                        class="bg-blue-600 text-white rounded-full w-8 h-8 inline-flex items-center justify-center text-sm font-bold mr-3">7</span>
                    View Your Instagram Feed
                </h2>
                <ol class="space-y-4 text-gray-700 dark:text-gray-300">
                    <li>After saving settings, go to your website's Instagram feed page</li>
                    <li>Visit: <code class="bg-gray-200 dark:bg-gray-700 px-2 py-1 rounded">/kegiatan</code></li>
                    <li>You should see your Instagram posts displayed automatically</li>
                    <li>The feed will update automatically based on your sync settings</li>
                </ol>
                <div class="success-box">
                    <p class="text-green-800">
                        <i class="fas fa-check-circle mr-2"></i>
                        <strong>Success!</strong> Your Instagram integration is now active and displaying posts on your
                        website.
                    </p>
                </div>
            </div>

            <!-- Troubleshooting -->
            <div class="step-card bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 mb-8">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                    <i class="fas fa-tools text-orange-600 mr-2"></i>
                    Troubleshooting
                </h2>
                <div class="space-y-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Connection Failed</h3>
                        <ul class="text-gray-700 dark:text-gray-300 space-y-1">
                            <li>• Verify your Access Token is correct and not expired</li>
                            <li>• Check that your User ID is correct</li>
                            <li>• Ensure your Instagram account is a Business account</li>
                            <li>• Make sure your app is approved for Instagram Basic Display</li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">No Posts Showing</h3>
                        <ul class="text-gray-700 dark:text-gray-300 space-y-1">
                            <li>• Check if your Instagram account has posts</li>
                            <li>• Verify the posts are public</li>
                            <li>• Try manually syncing the data</li>
                            <li>• Check the sync frequency settings</li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Token Expired</h3>
                        <ul class="text-gray-700 dark:text-gray-300 space-y-1">
                            <li>• Instagram tokens expire after 60 days</li>
                            <li>• Generate a new token from Facebook Developer Console</li>
                            <li>• Update the token in your website settings</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Support -->
            <div class="step-card bg-blue-50 dark:bg-blue-900 rounded-xl shadow-lg p-6 mb-8">
                <h2 class="text-2xl font-bold text-blue-900 dark:text-blue-100 mb-4">
                    <i class="fas fa-life-ring text-blue-600 mr-2"></i>
                    Need Help?
                </h2>
                <p class="text-blue-800 dark:text-blue-200 mb-4">
                    If you're still having trouble setting up Instagram integration, here are some resources:
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="https://developers.facebook.com/docs/instagram-basic-display-api" target="_blank"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-300">
                        <i class="fas fa-book mr-2"></i>
                        Instagram API Docs
                    </a>
                    <a href="/superadmin/instagram-settings"
                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-300">
                        <i class="fas fa-cog mr-2"></i>
                        Settings Page
                    </a>
                    <a href="/kegiatan"
                        class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-300">
                        <i class="fab fa-instagram mr-2"></i>
                        View Feed
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p>&copy; 2024 Website Sekolah. Semua hak cipta dilindungi.</p>
        </div>
    </footer>
</body>

</html>
