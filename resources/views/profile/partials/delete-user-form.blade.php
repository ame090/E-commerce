<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">Delete Account</h2>
        <p class="mt-1 text-sm text-gray-600">
            Once your account is deleted, all of its resources and data will be permanently deleted. 
            Before deleting your account, please download any data or information that you wish to retain.
        </p>
    </header>

    <div class="bg-red-50 border border-red-200 p-4 rounded-lg">
        <h3 class="text-sm font-semibold text-red-800 mb-2">⚠️ Warning: This action is irreversible!</h3>
        <p class="text-sm text-red-700 mb-4">
            Deleting your account will permanently remove all your data, including orders, products (if seller), 
            and personal information.
        </p>

        <details class="mt-4">
            <summary class="cursor-pointer text-sm font-medium text-red-800 hover:text-red-900">
                I understand, proceed with account deletion
            </summary>
            
            <form method="post" action="{{ route('profile.destroy') }}" class="mt-4 space-y-4">
                @csrf
                @method('delete')

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">
                        Confirm with your password
                    </label>
                    <input id="password" name="password" type="password" required
                        class="mt-1 block w-full max-w-md rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500"
                        placeholder="Enter your password to confirm">
                    @error('password', 'userDeletion')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center gap-4">
                    <button type="submit" 
                        class="bg-red-600 text-white px-6 py-2 rounded-md hover:bg-red-700 font-semibold"
                        onclick="return confirm('Are you absolutely sure you want to delete your account? This cannot be undone.')">
                        Delete My Account
                    </button>
                </div>
            </form>
        </details>
    </div>
</section>
