<x-admin-layout>
    <x-slot name="header">
        Edit Pengguna
    </x-slot>

    <div class="bg-white rounded-lg shadow-lg p-6">
        <form action="{{ route('admin.users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nama -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password (Opsional) -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password (Opsional)</label>
                    <input type="password" name="password" id="password"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                        placeholder="Biarkan kosong jika tidak ingin diubah">
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Role -->
                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                    <select name="role" id="role" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                        required>
                        <option value="admin" @selected(old('role', $user->role) == 'admin')>Admin</option>
                        <option value="staff" @selected(old('role', $user->role) == 'staff')>Staff</option>
                        <option value="customer" @selected(old('role', $user->role) == 'customer')>Customer</option>
                    </select>
                    <x-input-error :messages="$errors->get('role')" class="mt-2" />
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <a href="{{ route('admin.users.index') }}"
                    class="bg-gray-200 text-gray-700 py-2 px-4 rounded-md mr-2 hover:bg-gray-300">
                    Batal
                </a>
                <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700">
                    Update
                </button>
            </div>
        </form>
    </div>
</x-admin-layout>
