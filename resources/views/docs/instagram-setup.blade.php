@extends('layouts.landing')

@section('content')
    <!-- breadcrumb -->
    <div class="site-breadcrumb" style="background: url({{ asset('assets/img/breadcrumb/01.jpg') }})">
        <div class="container">
            <h2 class="breadcrumb-title">Instagram API Setup Guide</h2>
            <ul class="breadcrumb-menu">
                <li><a href="/">Home</a></li>
                <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="active">Instagram Setup</li>
            </ul>
        </div>
    </div>
    <!-- breadcrumb end -->

    <!-- Documentation Content -->
    <div class="py-5 bg-light">
        <div class="container">
            <!-- Header -->
            <div class="row mb-5">
                <div class="col-12 text-center">
                    <div class="mb-4">
                        <i class="fab fa-instagram fa-4x"
                            style="background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;"></i>
                    </div>
                    <p class="lead text-muted">Step-by-step guide to integrate Instagram with your school's website</p>
                </div>
            </div>

            <!-- Overview -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h2 class="h4 mb-3">
                        <i class="fas fa-info-circle text-primary mr-2"></i>
                        Overview
                    </h2>
                    <p class="card-text">
                        This guide will help you set up Instagram API integration for your school's website.
                        The integration will automatically fetch and display your school's Instagram posts on the website.
                    </p>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle mr-2"></i>
                        <strong>What you'll get:</strong> Automatic Instagram feed display, analytics dashboard, and content
                        management tools.
                    </div>
                </div>
            </div>

            <!-- Prerequisites -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h2 class="h4 mb-3">
                        <i class="fas fa-list-check text-success mr-2"></i>
                        Prerequisites
                    </h2>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="fas fa-check text-success mr-2"></i> A Facebook Business account</li>
                        <li class="mb-2"><i class="fas fa-check text-success mr-2"></i> An Instagram Business account</li>
                        <li class="mb-2"><i class="fas fa-check text-success mr-2"></i> Access to Facebook Developer
                            Console</li>
                        <li class="mb-2"><i class="fas fa-check text-success mr-2"></i> Superadmin access to your school's
                            website</li>
                    </ul>
                </div>
            </div>

            <!-- Setup Steps -->
            @for ($i = 1; $i <= 7; $i++)
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h2 class="h4 mb-3">
                            <span class="badge bg-primary rounded-circle"
                                style="width: 2rem; height: 2rem; display: inline-flex; align-items: center; justify-content: center;">{{ $i }}</span>
                            @if ($i == 1)
                                Create Facebook App
                            @elseif($i == 2)
                                Add Instagram Basic Display Product
                            @elseif($i == 3)
                                Configure Instagram Basic Display
                            @elseif($i == 4)
                                Get Access Token
                            @elseif($i == 5)
                                Get User ID
                            @elseif($i == 6)
                                Configure Website Settings
                            @elseif($i == 7)
                                View Your Instagram Feed
                            @endif
                        </h2>

                        @if ($i == 1)
                            <ol class="ps-3">
                                <li>Go to Facebook Developers: <a href="https://developers.facebook.com" target="_blank"
                                        class="text-primary">https://developers.facebook.com <i
                                            class="fas fa-external-link-alt text-xs"></i></a></li>
                                <li>Click "My Apps" → "Create App"</li>
                                <li>Select "Consumer" as app type</li>
                                <li>Fill in your app details and click "Create App"</li>
                            </ol>
                        @elseif($i == 2)
                            <ol class="ps-3">
                                <li>In your app dashboard, click "Add Product"</li>
                                <li>Find "Instagram Basic Display" and click "Set Up"</li>
                                <li>You'll see the Instagram Basic Display product added to your app</li>
                            </ol>
                        @elseif($i == 3)
                            <ol class="ps-3">
                                <li>Go to "Instagram Basic Display" → "Basic Display"</li>
                                <li>Click "Create New App"</li>
                                <li>Fill in the required OAuth redirect URIs</li>
                                <li>Click "Create App"</li>
                            </ol>
                            <div class="alert alert-warning mt-3">
                                <i class="fas fa-exclamation-triangle mr-2"></i>
                                <strong>Important:</strong> Replace "yourdomain.com" with your actual domain name.
                            </div>
                        @elseif($i == 4)
                            <ol class="ps-3">
                                <li>In your Instagram Basic Display app, go to "User Token Generator"</li>
                                <li>Click "Add or Remove Instagram Testers"</li>
                                <li>Add your Instagram account as a tester</li>
                                <li>Go back to "User Token Generator"</li>
                                <li>Click "Generate Token" next to your Instagram account</li>
                                <li>Copy the generated access token</li>
                            </ol>
                        @elseif($i == 5)
                            <ol class="ps-3">
                                <li>Use the Instagram Basic Display API to get your user ID</li>
                                <li>Make a GET request to: <code class="bg-dark text-light px-2 py-1 rounded">GET
                                        https://graph.instagram.com/me?fields=id&access_token=YOUR_ACCESS_TOKEN</code></li>
                                <li>The response will contain your user ID</li>
                            </ol>
                        @elseif($i == 6)
                            <ol class="ps-3">
                                <li>Go to your school's website superadmin dashboard</li>
                                <li>Navigate to "Instagram Settings"</li>
                                <li>Enter the Access Token and User ID</li>
                                <li>Click "Test Connection" to verify your settings</li>
                                <li>Click "Save Settings" to activate the integration</li>
                            </ol>
                        @elseif($i == 7)
                            <ol class="ps-3">
                                <li>After saving settings, go to your website's Instagram feed page</li>
                                <li>Visit: <code class="bg-dark text-light px-2 py-1 rounded">/kegiatan</code></li>
                                <li>You should see your Instagram posts displayed automatically</li>
                                <li>The feed will update automatically based on your sync settings</li>
                            </ol>
                            <div class="alert alert-success mt-3">
                                <i class="fas fa-check-circle mr-2"></i>
                                <strong>Success!</strong> Your Instagram integration is now active and displaying posts on
                                your website.
                            </div>
                        @endif
                    </div>
                </div>
            @endfor

            <!-- Troubleshooting -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h2 class="h4 mb-3">
                        <i class="fas fa-tools text-warning mr-2"></i>
                        Troubleshooting
                    </h2>
                    <div class="accordion" id="troubleshootingAccordion">
                        <div class="accordion-item">
                            <h3 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse1">
                                    Connection Failed
                                </button>
                            </h3>
                            <div id="collapse1" class="accordion-collapse collapse show"
                                data-bs-parent="#troubleshootingAccordion">
                                <div class="accordion-body">
                                    <ul>
                                        <li>Verify your Access Token is correct and not expired</li>
                                        <li>Check that your User ID is correct</li>
                                        <li>Ensure your Instagram account is a Business account</li>
                                        <li>Make sure your app is approved for Instagram Basic Display</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h3 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse2">
                                    No Posts Showing
                                </button>
                            </h3>
                            <div id="collapse2" class="accordion-collapse collapse"
                                data-bs-parent="#troubleshootingAccordion">
                                <div class="accordion-body">
                                    <ul>
                                        <li>Check if your Instagram account has posts</li>
                                        <li>Verify the posts are public</li>
                                        <li>Try manually syncing the data</li>
                                        <li>Check the sync frequency settings</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h3 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse3">
                                    Token Expired
                                </button>
                            </h3>
                            <div id="collapse3" class="accordion-collapse collapse"
                                data-bs-parent="#troubleshootingAccordion">
                                <div class="accordion-body">
                                    <ul>
                                        <li>Instagram tokens expire after 60 days</li>
                                        <li>Generate a new token from Facebook Developer Console</li>
                                        <li>Update the token in your website settings</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Support Links -->
            <div class="card shadow-sm mb-4 bg-primary text-white">
                <div class="card-body">
                    <h2 class="h4 mb-3">
                        <i class="fas fa-life-ring mr-2"></i>
                        Need Help?
                    </h2>
                    <p class="mb-4">
                        If you're still having trouble setting up Instagram integration, here are some resources:
                    </p>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="https://developers.facebook.com/docs/instagram-basic-display-api" target="_blank"
                            class="btn btn-light">
                            <i class="fas fa-book mr-2"></i>
                            Instagram API Docs
                        </a>
                        <a href="{{ route('admin.instagram.management') }}" class="btn btn-success">
                            <i class="fas fa-cog mr-2"></i>
                            Settings Page
                        </a>
                        <a href="{{ route('public.instagram') }}" class="btn btn-warning">
                            <i class="fab fa-instagram mr-2"></i>
                            View Feed
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
