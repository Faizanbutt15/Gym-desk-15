@extends('layouts.superadmin')

@section('content')
<div class="space-y-4 md:space-y-6" x-data="{ addModalOpen: false, editModalOpen: false, editAdmin: {} }">
    {{-- Page Header --}}
    <div class="flex items-center justify-between flex-wrap gap-2">
        <div>
            <p class="text-[10px] text-zinc-500 uppercase tracking-widest font-semibold mb-0.5">Super Admin</p>
            <h1 class="text-xl md:text-2xl font-extrabold text-zinc-900 dark:text-white tracking-tight">Gym Admins</h1>
        </div>
        <button @click="addModalOpen = true" class="bg-red-600 hover:bg-red-700 focus:ring-4 focus:ring-red-500/20 text-white px-4 py-2 rounded-xl text-sm font-semibold transition-all shadow-sm flex items-center gap-2">
            <i class="ph-bold ph-plus text-lg"></i> Add Admin
        </button>
    </div>

    <!-- Admins Table -->
    <div class="rounded-2xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 overflow-hidden shadow-sm">
        <div class="px-6 py-5 border-b border-zinc-200 dark:border-zinc-800 flex items-center justify-between">
            <div>
                <h2 class="text-base font-bold text-zinc-900 dark:text-white tracking-tight">Admin Accounts</h2>
                <p class="text-[11px] text-zinc-500 mt-0.5">Manage access for individual gym administrators</p>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead class="bg-zinc-50 dark:bg-zinc-800/50 text-zinc-500 dark:text-zinc-400 uppercase tracking-wider text-[11px] border-b border-zinc-200 dark:border-zinc-800">
                    <tr>
                        <th class="px-6 py-4 font-semibold">Admin Details</th>
                        <th class="px-6 py-4 font-semibold">Assigned Gym</th>
                        <th class="px-6 py-4 font-semibold">Created</th>
                        <th class="px-6 py-4 font-semibold text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800/60">
                    @forelse($gymAdmins as $admin)
                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/30 transition">
                            <td class="px-6 py-4">
                                <div class="font-medium text-zinc-900 dark:text-white">{{ $admin->name }}</div>
                                <div class="text-zinc-500 dark:text-zinc-400 text-xs mt-0.5">{{ $admin->email }}</div>
                            </td>
                            <td class="px-6 py-4">
                                @if($admin->gym)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-blue-50 dark:bg-blue-900/10 text-blue-700 dark:text-blue-400 border border-blue-200 dark:border-blue-900/30 shadow-sm">
                                        {{ $admin->gym->name }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-red-50 dark:bg-red-900/10 text-red-700 dark:text-red-400 border border-red-200 dark:border-red-900/30 shadow-sm">Unassigned</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-zinc-500 dark:text-zinc-400 text-xs">
                                {{ $admin->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <button @click="editAdmin = {{ json_encode($admin) }}; editModalOpen = true" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 font-medium mr-3 transition-colors">Edit</button>
                                <form method="POST" action="{{ route('superadmin.gym-admins.destroy', $admin) }}" class="inline" id="delete-form-{{ $admin->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" onclick="confirmDelete('{{ $admin->id }}')" class="text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 font-medium transition-colors">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-zinc-500 dark:text-zinc-400">
                                <div class="flex flex-col items-center">
                                    <span class="w-12 h-12 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center mb-3">
                                        <i class="ph-fill ph-user-gear text-zinc-400 dark:text-zinc-500 text-2xl"></i>
                                    </span>
                                    <span class="text-sm font-medium text-zinc-500 dark:text-zinc-400">No Gym Admins Found</span>
                                    <p class="text-xs mt-1">Get started by assigning a new admin to a gym.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($gymAdmins->hasPages())
        <div class="px-6 py-4 border-t border-zinc-200 dark:border-zinc-800">
            {{ $gymAdmins->links() }}
        </div>
        @endif
    </div>

    <!-- Add Modal -->
    <div x-show="addModalOpen" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <div x-show="addModalOpen" x-transition.opacity class="fixed inset-0 bg-zinc-900/70" @click="addModalOpen = false"></div>
            <div x-show="addModalOpen" x-transition.scale class="relative inline-block w-full max-w-md p-6 overflow-hidden text-left align-middle transition-all transform bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 shadow-xl rounded-2xl">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-lg font-bold text-zinc-900 dark:text-white">Add Gym Admin</h3>
                    <button @click="addModalOpen = false" class="text-zinc-400 hover:text-zinc-500 dark:hover:text-zinc-300 focus:outline-none">
                        <i class="ph-bold ph-x text-lg"></i>
                    </button>
                </div>
                <form action="{{ route('superadmin.gym-admins.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Full Name <span class="text-red-500">*</span></label>
                        <input type="text" name="name" required class="w-full bg-zinc-50 dark:bg-zinc-900 text-zinc-900 dark:text-white border border-zinc-200 dark:border-zinc-700 focus:ring-2 focus:ring-red-500/20 focus:border-red-500 rounded-xl px-4 py-2 transition-all duration-200 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Email Address <span class="text-red-500">*</span></label>
                        <input type="email" name="email" required class="w-full bg-zinc-50 dark:bg-zinc-900 text-zinc-900 dark:text-white border border-zinc-200 dark:border-zinc-700 focus:ring-2 focus:ring-red-500/20 focus:border-red-500 rounded-xl px-4 py-2 transition-all duration-200 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Password <span class="text-red-500">*</span></label>
                        <input type="password" name="password" required minlength="8" class="w-full bg-zinc-50 dark:bg-zinc-900 text-zinc-900 dark:text-white border border-zinc-200 dark:border-zinc-700 focus:ring-2 focus:ring-red-500/20 focus:border-red-500 rounded-xl px-4 py-2 transition-all duration-200 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Assign to Gym <span class="text-red-500">*</span></label>
                        <select name="gym_id" required class="w-full bg-zinc-50 dark:bg-zinc-900 text-zinc-900 dark:text-white border border-zinc-200 dark:border-zinc-700 focus:ring-2 focus:ring-red-500/20 focus:border-red-500 rounded-xl px-4 py-2 transition-all duration-200 outline-none">
                            <option value="">Select a Gym</option>
                            @foreach($gyms as $gym)
                                <option value="{{ $gym->id }}">{{ $gym->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="pt-4 flex justify-end gap-3 border-t border-zinc-200 dark:border-zinc-800">
                        <button type="button" @click="addModalOpen = false" class="px-4 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-300 bg-white dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 rounded-xl hover:bg-zinc-50 dark:hover:bg-zinc-700 focus:outline-none shadow-sm transition-all">Cancel</button>
                        <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-xl hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-red-500/20 shadow-sm transition-all" onclick="this.innerHTML='Saving...'; this.form.submit();">Save Admin</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div x-show="editModalOpen" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <div x-show="editModalOpen" x-transition.opacity class="fixed inset-0 bg-zinc-900/70" @click="editModalOpen = false"></div>
            <div x-show="editModalOpen" x-transition.scale class="relative inline-block w-full max-w-md p-6 overflow-hidden text-left align-middle transition-all transform bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 shadow-xl rounded-2xl">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-lg font-bold text-zinc-900 dark:text-white">Edit Gym Admin</h3>
                    <button @click="editModalOpen = false" class="text-zinc-400 hover:text-zinc-500 dark:hover:text-zinc-300 focus:outline-none">
                        <i class="ph-bold ph-x text-lg"></i>
                    </button>
                </div>
                <form :action="'{{ url('superadmin/gym-admins') }}/' + editAdmin.id" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Full Name <span class="text-red-500">*</span></label>
                        <input type="text" name="name" x-model="editAdmin.name" required class="w-full bg-zinc-50 dark:bg-zinc-900 text-zinc-900 dark:text-white border border-zinc-200 dark:border-zinc-700 focus:ring-2 focus:ring-red-500/20 focus:border-red-500 rounded-xl px-4 py-2 transition-all duration-200 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Email Address <span class="text-red-500">*</span></label>
                        <input type="email" name="email" x-model="editAdmin.email" required class="w-full bg-zinc-50 dark:bg-zinc-900 text-zinc-900 dark:text-white border border-zinc-200 dark:border-zinc-700 focus:ring-2 focus:ring-red-500/20 focus:border-red-500 rounded-xl px-4 py-2 transition-all duration-200 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">New Password <span class="text-xs text-zinc-400 dark:text-zinc-500">(Leave blank to keep current)</span></label>
                        <input type="password" name="password" minlength="8" class="w-full bg-zinc-50 dark:bg-zinc-900 text-zinc-900 dark:text-white border border-zinc-200 dark:border-zinc-700 focus:ring-2 focus:ring-red-500/20 focus:border-red-500 rounded-xl px-4 py-2 transition-all duration-200 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Assign to Gym <span class="text-red-500">*</span></label>
                        <select name="gym_id" x-model="editAdmin.gym_id" required class="w-full bg-zinc-50 dark:bg-zinc-900 text-zinc-900 dark:text-white border border-zinc-200 dark:border-zinc-700 focus:ring-2 focus:ring-red-500/20 focus:border-red-500 rounded-xl px-4 py-2 transition-all duration-200 outline-none">
                            <option value="">Select a Gym</option>
                            @foreach($gyms as $gym)
                                <option value="{{ $gym->id }}">{{ $gym->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="pt-4 flex justify-end gap-3 border-t border-zinc-200 dark:border-zinc-800">
                        <button type="button" @click="editModalOpen = false" class="px-4 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-300 bg-white dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 rounded-xl hover:bg-zinc-50 dark:hover:bg-zinc-700 focus:outline-none shadow-sm transition-all">Cancel</button>
                        <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-xl hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-red-500/20 shadow-sm transition-all" onclick="this.innerHTML='Saving...'; this.form.submit();">Update Admin</button>
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
            confirmButtonText: 'Yes, delete it!',
            ...window.gymSwalConfig
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        })
    }
</script>
@endpush
@endsection
