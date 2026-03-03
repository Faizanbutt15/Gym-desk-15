@extends('layouts.superadmin')

@section('content')
<div class="space-y-6" x-data="{ addModalOpen: false, editModalOpen: false, editAdmin: {} }">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-900">Gym Admins</h1>
        <button @click="addModalOpen = true" class="bg-primary hover:bg-blue-800 text-white px-4 py-2 rounded-lg text-sm font-medium transition shadow-sm">
            + Add Admin
        </button>
    </div>

    <!-- Admins Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead class="bg-gray-50 text-gray-500 uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-4 font-medium">Admin Details</th>
                        <th class="px-6 py-4 font-medium">Assigned Gym</th>
                        <th class="px-6 py-4 font-medium">Created</th>
                        <th class="px-6 py-4 font-medium text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($gymAdmins as $admin)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <div class="font-medium text-gray-900">{{ $admin->name }}</div>
                                <div class="text-gray-500 text-xs mt-0.5">{{ $admin->email }}</div>
                            </td>
                            <td class="px-6 py-4">
                                @if($admin->gym)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100">
                                        {{ $admin->gym->name }}
                                    </span>
                                @else
                                    <span class="text-red-500 text-xs">Unassigned</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-gray-500">
                                {{ $admin->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <button @click="editAdmin = {{ json_encode($admin) }}; editModalOpen = true" class="text-blue-600 hover:text-blue-900 font-medium mr-3">Edit</button>
                                <form method="POST" action="{{ route('superadmin.gym-admins.destroy', $admin) }}" class="inline" id="delete-form-{{ $admin->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" onclick="confirmDelete('{{ $admin->id }}')" class="text-red-500 hover:text-red-700 font-medium">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                <div class="flex flex-col items-center">
                                    <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                    <span class="text-lg font-medium">No Gym Admins Found</span>
                                    <p class="text-sm mt-1">Get started by assigning a new admin to a gym.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($gymAdmins->hasPages())
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $gymAdmins->links() }}
        </div>
        @endif
    </div>

    <!-- Add Modal -->
    <div x-show="addModalOpen" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <div x-show="addModalOpen" class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" @click="addModalOpen = false"></div>
            <div class="relative inline-block w-full max-w-md p-6 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-2xl">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-lg font-bold text-gray-900">Add Gym Admin</h3>
                    <button @click="addModalOpen = false" class="text-gray-400 hover:text-gray-500 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <form action="{{ route('superadmin.gym-admins.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Full Name <span class="text-red-500">*</span></label>
                        <input type="text" name="name" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email Address <span class="text-red-500">*</span></label>
                        <input type="email" name="email" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Password <span class="text-red-500">*</span></label>
                        <input type="password" name="password" required minlength="8" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Assign to Gym <span class="text-red-500">*</span></label>
                        <select name="gym_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
                            <option value="">Select a Gym</option>
                            @foreach($gyms as $gym)
                                <option value="{{ $gym->id }}">{{ $gym->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="pt-4 flex justify-end gap-3 border-t border-gray-100">
                        <button type="button" @click="addModalOpen = false" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none shadow-sm">Cancel</button>
                        <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-primary rounded-lg hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary shadow-sm" onclick="this.innerHTML='Saving...'; this.form.submit();">Save Admin</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div x-show="editModalOpen" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <div x-show="editModalOpen" class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" @click="editModalOpen = false"></div>
            <div class="relative inline-block w-full max-w-md p-6 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-2xl">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-lg font-bold text-gray-900">Edit Gym Admin</h3>
                    <button @click="editModalOpen = false" class="text-gray-400 hover:text-gray-500 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <form :action="'{{ url('superadmin/gym-admins') }}/' + editAdmin.id" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Full Name <span class="text-red-500">*</span></label>
                        <input type="text" name="name" x-model="editAdmin.name" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email Address <span class="text-red-500">*</span></label>
                        <input type="email" name="email" x-model="editAdmin.email" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">New Password <span class="text-xs text-gray-500">(Leave blank to keep current)</span></label>
                        <input type="password" name="password" minlength="8" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Assign to Gym <span class="text-red-500">*</span></label>
                        <select name="gym_id" x-model="editAdmin.gym_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
                            <option value="">Select a Gym</option>
                            @foreach($gyms as $gym)
                                <option value="{{ $gym->id }}">{{ $gym->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="pt-4 flex justify-end gap-3 border-t border-gray-100">
                        <button type="button" @click="editModalOpen = false" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none shadow-sm">Cancel</button>
                        <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-primary rounded-lg hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary shadow-sm" onclick="this.innerHTML='Saving...'; this.form.submit();">Update Admin</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "This action cannot be undone. You are removing access for this admin.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        })
    }
</script>
@endpush
@endsection
