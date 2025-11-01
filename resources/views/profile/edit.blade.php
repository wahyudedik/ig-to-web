<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Profile updated success message
                @if (session('status') === 'profile-updated')
                    if (typeof showSuccess !== 'undefined') {
                        showSuccess('{{ __('Profile Updated') }}',
                            '{{ __('Your profile information has been saved successfully.') }}');
                    }
                @endif

                // Password updated success message
                @if (session('status') === 'password-updated')
                    if (typeof showSuccess !== 'undefined') {
                        showSuccess('{{ __('Password Updated') }}',
                            '{{ __('Your password has been updated successfully.') }}');
                    }
                @endif

                // Verification link sent
                @if (session('status') === 'verification-link-sent')
                    if (typeof showSuccess !== 'undefined') {
                        showSuccess('{{ __('Verification Email Sent') }}',
                            '{{ __('A new verification link has been sent to your email address.') }}');
                    }
                @endif
            });
        </script>
    @endpush
</x-app-layout>
