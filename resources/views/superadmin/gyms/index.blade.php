@extends('layouts.superadmin')

@section('content')
<div class="space-y-6" x-data="{ addModalOpen: false, editModalOpen: false, editGym: {} }">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-900">Gyms</h1>
        <button @click="addModalOpen = true" class="bg-primary hover:bg-blue-800 text-white px-4 py-2 rounded-lg text-sm font-medium transition shadow-sm">
            + Add New Gym
        </button>
    </div>

    <!-- Gyms Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead class="bg-gray-50 text-gray-500 uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-4 font-medium">Gym</th>
                        <th class="px-6 py-4 font-medium">Status</th>
                        <th class="px-6 py-4 font-medium">Subscription</th>
                        <th class="px-6 py-4 font-medium text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($gyms as $gym)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 font-medium text-gray-900 flex items-center gap-3">
                                @if($gym->logo)
                                    <img src="{{ asset('storage/' . $gym->logo) }}" class="w-10 h-10 rounded-full object-cover border border-gray-200">
                                @else
                                    <div class="w-10 h-10 rounded-full bg-blue-100 text-primary flex items-center justify-center font-bold border border-blue-200">
                                        {{ substr($gym->name, 0, 1) }}
                                    </div>
                                @endif
                                <div>
                                    <div class="text-gray-900">{{ $gym->name }}</div>
                                    <div class="text-gray-500 text-xs font-normal">{{ $gym->address ?? 'No address' }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <form method="POST" action="{{ route('superadmin.gyms.status', $gym) }}" class="inline">
                                    @csrf
                                    <input type="hidden" name="status" value="{{ $gym->status === 'active' ? 'inactive' : 'active' }}">
                                    <button type="submit" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $gym->status === 'active' ? 'bg-green-100 text-green-800 hover:bg-green-200' : 'bg-red-100 text-red-800 hover:bg-red-200' }} transition cursor-pointer shadow-sm">
                                        {{ ucfirst($gym->status) }}
                                    </button>
                                </form>
                            </td>
                            <td class="px-6 py-4">
                                @if($gym->subscription_end)
                                    @php
                                        $daysLeft = now()->diffInDays($gym->subscription_end, false);
                                    @endphp
                                    <div class="flex items-center gap-2">
                                        <span>{{ $gym->subscription_start ? $gym->subscription_start->format('M d, Y') : '-' }} - {{ $gym->subscription_end->format('M d, Y') }}</span>
                                        @if($daysLeft < 0)
                                            <span class="px-2 py-0.5 text-[10px] uppercase font-bold rounded bg-red-100 text-red-600">Expired</span>
                                        @elseif($daysLeft <= 7)
                                            <span class="px-2 py-0.5 text-[10px] uppercase font-bold rounded bg-orange-100 text-orange-600">Expiring Soon</span>
                                        @endif
                                    </div>
                                @else
                                    <span class="text-gray-400">Not set</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <button @click="editGym = {{ json_encode($gym) }}; editModalOpen = true" class="text-blue-600 hover:text-blue-900 font-medium mr-3">Edit</button>
                                <form method="POST" action="{{ route('superadmin.gyms.destroy', $gym) }}" class="inline" id="delete-form-{{ $gym->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" onclick="confirmDelete('{{ $gym->id }}')" class="text-red-500 hover:text-red-700 font-medium">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                <div class="flex flex-col items-center">
                                    <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                    <span class="text-lg font-medium">No Gyms Found</span>
                                    <p class="text-sm mt-1">Get started by creating a new gym.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($gyms->hasPages())
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $gyms->links() }}
        </div>
        @endif
    </div>

    <!-- Add Modal -->
    <div x-show="addModalOpen" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <div x-show="addModalOpen" class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" @click="addModalOpen = false"></div>
            <div class="relative inline-block w-full max-w-lg p-6 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-2xl">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-lg font-bold text-gray-900">Add New Gym</h3>
                    <button @click="addModalOpen = false" class="text-gray-400 hover:text-gray-500 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <form action="{{ route('superadmin.gyms.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Gym Name <span class="text-red-500">*</span></label>
                        <input type="text" name="name" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Address</label>
                        <input type="text" name="address" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Logo</label>
                        <input type="file" name="logo" accept="image/*" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-primary hover:file:bg-blue-100 border border-gray-300">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Status <span class="text-red-500">*</span></label>
                            <select name="status" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Subscription Start</label>
                            <input type="date" name="subscription_start" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Subscription End</label>
                            <input type="date" name="subscription_end" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
                        </div>
                    </div>
                    <div class="pt-4 flex justify-end gap-3 border-t border-gray-100">
                        <button type="button" @click="addModalOpen = false" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none shadow-sm">Cancel</button>
                        <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-primary rounded-lg hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary shadow-sm" onclick="this.innerHTML='Saving...'; this.form.submit();">Save Gym</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div x-show="editModalOpen" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <div x-show="editModalOpen" class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" @click="editModalOpen = false"></div>
            <div class="relative inline-block w-full max-w-lg p-6 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-2xl">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-lg font-bold text-gray-900">Edit Gym</h3>
                    <button @click="editModalOpen = false" class="text-gray-400 hover:text-gray-500 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <form :action="'{{ url('superadmin/gyms') }}/' + editGym.id" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Gym Name <span class="text-red-500">*</span></label>
                        <input type="text" name="name" x-model="editGym.name" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Address</label>
                        <input type="text" name="address" x-model="editGym.address" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Update Logo <span class="text-gray-400 text-xs">(leave empty to keep current)</span></label>
                        <input type="file" name="logo" accept="image/*" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-primary hover:file:bg-blue-100 border border-gray-300">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Status <span class="text-red-500">*</span></label>
                            <select name="status" x-model="editGym.status" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Subscription Start</label>
                            <input type="date" name="subscription_start" x-model="editGym.subscription_start ? editGym.subscription_start.substring(0,10) : ''" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Subscription End</label>
                            <input type="date" name="subscription_end" x-model="editGym.subscription_end ? editGym.subscription_end.substring(0,10) : ''" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
                        </div>
                    </div>
                    <div class="pt-4 flex justify-end gap-3 border-t border-gray-100">
                        <button type="button" @click="editModalOpen = false" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none shadow-sm">Cancel</button>
                        <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-primary rounded-lg hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary shadow-sm" onclick="this.innerHTML='Saving...'; this.form.submit();">Update Gym</button>
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
            text: "This action cannot be undone. All data related to this gym will be deleted.",
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
