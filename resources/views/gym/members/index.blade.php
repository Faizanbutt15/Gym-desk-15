@extends('layouts.gym')

@section('content')
<div class="space-y-6" x-data="{ addModalOpen: false, editModalOpen: false, viewModalOpen: false, editMember: {}, viewMember: {} }">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <h1 class="text-2xl font-bold text-gray-900">Members</h1>
        <div class="flex items-center gap-3">
            <form action="{{ route('members.index') }}" method="GET" class="relative">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search members..." class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent w-full md:w-64">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
            </form>
            <button @click="addModalOpen = true" class="bg-primary hover:bg-blue-800 text-white px-4 py-2 rounded-lg text-sm font-medium transition shadow-sm whitespace-nowrap">
                + Add Member
            </button>
        </div>
    </div>

    <!-- Members Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead class="bg-gray-50 text-gray-500 uppercase tracking-wider border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4 font-medium">Member</th>
                        <th class="px-6 py-4 font-medium">Contact</th>
                        <th class="px-6 py-4 font-medium">Fee Due Date</th>
                        <th class="px-6 py-4 font-medium">Status</th>
                        <th class="px-6 py-4 font-medium text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($members as $member)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 font-medium text-gray-900 flex items-center gap-3">
                                @if($member->photo)
                                    <img src="{{ asset('storage/' . $member->photo) }}" class="w-10 h-10 rounded-full object-cover border border-gray-200">
                                @else
                                    <div class="w-10 h-10 rounded-full bg-blue-100 text-primary flex items-center justify-center font-bold border border-blue-200">
                                        {{ substr($member->name, 0, 1) }}
                                    </div>
                                @endif
                                <div>
                                    <div class="text-gray-900 font-semibold">{{ $member->name }}</div>
                                    <div class="text-gray-500 text-xs font-normal">{{ $member->email }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                {{ $member->contact ?? '-' }}
                            </td>
                            <td class="px-6 py-4">
                                @if($member->fee_due_date)
                                    @php
                                        $daysLeft = now()->startOfDay()->diffInDays($member->fee_due_date, false);
                                    @endphp
                                    <div class="font-medium {{ $daysLeft < 0 ? 'text-red-600' : ($daysLeft <= 3 ? 'text-orange-600' : 'text-gray-900') }}">
                                        {{ $member->fee_due_date->format('M d, Y') }}
                                        @if($daysLeft < 0)
                                            <span class="ml-1 text-[10px] text-red-500 font-bold uppercase">(Expired)</span>
                                        @elseif($daysLeft <= 3)
                                            <span class="ml-1 text-[10px] text-orange-500 font-bold uppercase">(Soon)</span>
                                        @endif
                                    </div>
                                @else
                                    <span class="text-gray-400">Not set</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($member->status === 'active')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Active</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">Inactive</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right flex items-center justify-end gap-2">
                                <form method="POST" action="{{ route('members.markPaid', $member) }}" class="inline">
                                    @csrf
                                    <button type="submit" class="text-white bg-green-500 hover:bg-green-600 p-1.5 rounded-lg transition shadow-sm" onclick="return confirm('Mark as Paid? This will add 30 days to due date and record a payment.')" title="Mark Paid">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </button>
                                </form>
                                <button @click="viewMember = {{ json_encode($member) }}; viewModalOpen = true" class="text-blue-500 bg-blue-50 hover:bg-blue-100 p-1.5 rounded-lg transition" title="View">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                </button>
                                <button @click="editMember = {{ json_encode($member) }}; editModalOpen = true" class="text-amber-500 bg-amber-50 hover:bg-amber-100 p-1.5 rounded-lg transition" title="Edit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </button>
                                <form method="POST" action="{{ route('members.destroy', $member) }}" class="inline" id="delete-form-{{ $member->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" onclick="confirmDelete('{{ $member->id }}')" class="text-red-500 bg-red-50 hover:bg-red-100 p-1.5 rounded-lg transition" title="Delete">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                <div class="flex flex-col items-center">
                                    <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                    <span class="text-lg font-medium">No Members Found</span>
                                    <p class="text-sm mt-1">Add your first member to get started.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($members->hasPages())
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $members->links() }}
        </div>
        @endif
    </div>

    <!-- Add Modal -->
    <div x-show="addModalOpen" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <div x-show="addModalOpen" class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" @click="addModalOpen = false"></div>
            <div class="relative inline-block w-full max-w-xl p-6 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-2xl">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-lg font-bold text-gray-900">Add New Member</h3>
                    <button @click="addModalOpen = false" class="text-gray-400 hover:text-gray-500 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <form action="{{ route('members.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Full Name <span class="text-red-500">*</span></label>
                            <input type="text" name="name" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email Address</label>
                            <input type="email" name="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Contact Number</label>
                            <input type="text" name="contact" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Monthly Gym Fee ($) <span class="text-red-500">*</span></label>
                            <input type="number" step="0.01" name="fee_amount" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Admission Fee ($) <span class="text-xs text-gray-400 font-normal">(One-time)</span></label>
                            <input type="number" step="0.01" name="admission_fee" value="0.00" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Trainer Fee ($) <span class="text-xs text-gray-400 font-normal">(Monthly)</span></label>
                            <input type="number" step="0.01" name="trainer_fee" value="0.00" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Locker Fee ($) <span class="text-xs text-gray-400 font-normal">(Monthly)</span></label>
                            <input type="number" step="0.01" name="locker_fee" value="0.00" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Next Fee Due Date</label>
                            <input type="date" name="fee_due_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Joined Date</label>
                            <input type="date" name="joined_date" value="{{ date('Y-m-d') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Photo</label>
                            <div x-data="{ cameraActive: false, capturedImage: null }" class="space-y-3">
                                <div x-show="!capturedImage" class="flex items-center gap-3">
                                    <input type="file" name="photo" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-primary hover:file:bg-blue-100 border border-gray-300">
                                    <span class="text-sm text-gray-400 font-medium">OR</span>
                                    <button type="button" @click="cameraActive = true; initCamera($refs.videoElement)" x-show="!cameraActive" class="px-3 py-2 bg-gray-100 text-gray-700 rounded-md border border-gray-300 shadow-sm text-sm hover:bg-gray-200 whitespace-nowrap font-medium flex-shrink-0">
                                        📷 Open Camera
                                    </button>
                                </div>
                                
                                <input type="hidden" name="photo_base64" :value="capturedImage">

                                <div x-show="cameraActive && !capturedImage" class="relative bg-gray-900 rounded-lg overflow-hidden flex flex-col items-center">
                                    <video x-ref="videoElement" autoplay playsinline class="w-full max-h-64 object-cover"></video>
                                    <div class="absolute bottom-4 left-0 right-0 flex justify-center gap-3">
                                        <button type="button" @click="cameraActive = false; stopCamera($refs.videoElement)" class="px-4 py-2 bg-red-600 text-white rounded-full shadow-md text-sm font-bold hover:bg-red-700">Cancel</button>
                                        <button type="button" @click="capturedImage = captureImage($refs.videoElement, $refs.canvasElement); stopCamera($refs.videoElement); cameraActive = false;" class="px-4 py-2 bg-green-500 text-white rounded-full shadow-md text-sm font-bold hover:bg-green-600">Take Photo</button>
                                    </div>
                                    <canvas x-ref="canvasElement" class="hidden"></canvas>
                                </div>

                                <div x-show="capturedImage" class="relative inline-block">
                                    <img :src="capturedImage" class="h-32 w-32 object-cover rounded-xl border border-gray-300 shadow-sm">
                                    <button type="button" @click="capturedImage = null" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center shadow hover:bg-red-600 text-xs font-bold">&times;</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="pt-4 flex justify-end gap-3 border-t border-gray-100">
                        <button type="button" @click="addModalOpen = false" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none shadow-sm">Cancel</button>
                        <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-primary rounded-lg hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary shadow-sm" onclick="this.innerHTML='Saving...'; this.form.submit();">Save Member</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div x-show="editModalOpen" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <div x-show="editModalOpen" class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" @click="editModalOpen = false"></div>
            <div class="relative inline-block w-full max-w-xl p-6 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-2xl">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-lg font-bold text-gray-900">Edit Member</h3>
                    <button @click="editModalOpen = false" class="text-gray-400 hover:text-gray-500 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <form :action="'{{ url('members') }}/' + editMember.id" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Full Name <span class="text-red-500">*</span></label>
                            <input type="text" name="name" x-model="editMember.name" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email Address</label>
                            <input type="email" name="email" x-model="editMember.email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Contact Number</label>
                            <input type="text" name="contact" x-model="editMember.contact" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Monthly Gym Fee ($) <span class="text-red-500">*</span></label>
                            <input type="number" step="0.01" name="fee_amount" x-model="editMember.fee_amount" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Admission Fee ($) <span class="text-xs text-gray-400 font-normal">(One-time)</span></label>
                            <input type="number" step="0.01" name="admission_fee" x-model="editMember.admission_fee" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Trainer Fee ($) <span class="text-xs text-gray-400 font-normal">(Monthly, set to 0 to remove)</span></label>
                            <input type="number" step="0.01" name="trainer_fee" x-model="editMember.trainer_fee" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Locker Fee ($) <span class="text-xs text-gray-400 font-normal">(Monthly, set to 0 to remove)</span></label>
                            <input type="number" step="0.01" name="locker_fee" x-model="editMember.locker_fee" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Fee Due Date</label>
                            <input type="date" name="fee_due_date" x-model="editMember.fee_due_date ? editMember.fee_due_date.substring(0,10) : ''" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Status <span class="text-red-500">*</span></label>
                            <select name="status" x-model="editMember.status" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Update Photo <span class="text-xs text-gray-400 font-normal">(leave empty to keep current)</span></label>
                            <div x-data="{ cameraActive: false, capturedImage: null }" class="space-y-3">
                                <div x-show="!capturedImage" class="flex items-center gap-3">
                                    <input type="file" name="photo" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-primary hover:file:bg-blue-100 border border-gray-300">
                                    <span class="text-sm text-gray-400 font-medium">OR</span>
                                    <button type="button" @click="cameraActive = true; initCamera($refs.videoElement)" x-show="!cameraActive" class="px-3 py-2 bg-gray-100 text-gray-700 rounded-md border border-gray-300 shadow-sm text-sm hover:bg-gray-200 whitespace-nowrap font-medium flex-shrink-0">
                                        📷 Open Camera
                                    </button>
                                </div>
                                
                                <input type="hidden" name="photo_base64" :value="capturedImage">

                                <div x-show="cameraActive && !capturedImage" class="relative bg-gray-900 rounded-lg overflow-hidden flex flex-col items-center">
                                    <video x-ref="videoElement" autoplay playsinline class="w-full max-h-64 object-cover"></video>
                                    <div class="absolute bottom-4 left-0 right-0 flex justify-center gap-3">
                                        <button type="button" @click="cameraActive = false; stopCamera($refs.videoElement)" class="px-4 py-2 bg-red-600 text-white rounded-full shadow-md text-sm font-bold hover:bg-red-700">Cancel</button>
                                        <button type="button" @click="capturedImage = captureImage($refs.videoElement, $refs.canvasElement); stopCamera($refs.videoElement); cameraActive = false;" class="px-4 py-2 bg-green-500 text-white rounded-full shadow-md text-sm font-bold hover:bg-green-600">Take Photo</button>
                                    </div>
                                    <canvas x-ref="canvasElement" class="hidden"></canvas>
                                </div>

                                <div x-show="capturedImage" class="relative inline-block">
                                    <img :src="capturedImage" class="h-32 w-32 object-cover rounded-xl border border-gray-300 shadow-sm">
                                    <button type="button" @click="capturedImage = null" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center shadow hover:bg-red-600 text-xs font-bold">&times;</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="pt-4 flex justify-end gap-3 border-t border-gray-100">
                        <button type="button" @click="editModalOpen = false" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none shadow-sm">Cancel</button>
                        <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-primary rounded-lg hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary shadow-sm" onclick="this.innerHTML='Saving...'; this.form.submit();">Update Member</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- View Modal (Card Style) -->
    <div x-show="viewModalOpen" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <div x-show="viewModalOpen" class="fixed inset-0 transition-opacity bg-gray-900 bg-opacity-75" @click="viewModalOpen = false"></div>
            
            <div class="relative inline-block w-full max-w-[360px] overflow-hidden text-left align-middle transition-all transform bg-white shadow-2xl rounded-2xl flex flex-col h-[85vh] sm:h-auto sm:max-h-[90vh]">
                
                <!-- Scrollable Content Area -->
                <div class="flex-1 overflow-y-auto w-full bg-white relative pb-16">
                    
                    <!-- Top Dark Header Section -->
                    <div class="bg-black pt-4 pb-8 px-4 relative flex flex-col items-center">
                        <!-- Top Actions (Back & Check) -->
                        <div class="w-full flex justify-between items-center text-white mb-2 relative left-0 px-1">
                            <button @click="viewModalOpen = false" class="text-white hover:text-gray-300 transition focus:outline-none">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                            </button>
                            <button @click="viewModalOpen = false; editMember = viewMember; editModalOpen = true" class="text-white hover:text-gray-300 transition focus:outline-none">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </button>
                        </div>
                        
                        <!-- Profile Image Avatar -->
                        <div class="flex justify-center mt-1 relative z-10 w-full">
                            <template x-if="viewMember.photo">
                                <img :src="'/storage/' + viewMember.photo" class="w-32 h-32 rounded-full object-cover border-2 border-white shadow-sm bg-white">
                            </template>
                            <template x-if="!viewMember.photo">
                                <div class="w-32 h-32 rounded-full bg-blue-100 text-primary flex items-center justify-center font-bold text-5xl shadow-sm border-2 border-white" x-text="viewMember.name ? viewMember.name.substring(0, 1) : ''"></div>
                            </template>
                        </div>
                        
                        <div class="text-center mt-3 mb-1">
                            <h3 class="text-xl font-medium text-white tracking-wide" x-text="viewMember.name"></h3>
                        </div>
                    </div>

                    <!-- Action Bar -->
                    <div class="flex justify-center border-b border-gray-200 bg-white">
                        <form method="POST" :action="'{{ url('gym/members') }}/' + viewMember.id + '/mark-paid'" class="w-1/2 border-r border-gray-200" x-ref="markPaidForm">
                            @csrf
                            <button type="button" @click="$refs.markPaidForm.submit()" class="w-full flex flex-col items-center justify-center gap-1.5 py-3 hover:bg-gray-50 transition text-gray-700">
                                <svg class="w-5 h-5 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                <span class="text-[11px] font-semibold text-gray-800">Mark Paid</span>
                            </button>
                        </form>
                        <button type="button" @click="viewModalOpen = false; editMember = viewMember; editModalOpen = true" class="w-1/2 flex flex-col items-center justify-center gap-1.5 py-3 hover:bg-gray-50 transition text-gray-700">
                            <svg class="w-5 h-5 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <span class="text-[11px] font-semibold text-gray-800">Edit Member</span>
                        </button>
                    </div>

                    <!-- Details Section Head -->
                    <div class="bg-gray-100 px-4 py-2 flex items-center gap-2 border-b border-gray-200">
                        <svg class="w-4 h-4 text-gray-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                        <span class="text-xs uppercase tracking-wider font-bold text-black">Details</span>
                    </div>

                    <!-- Details List -->
                    <div class="px-4 bg-white divide-y divide-gray-100 text-sm">
                        <div class="py-3.5 flex items-center justify-between">
                            <span class="text-gray-400 w-1/3 text-[13px] font-medium">Status</span>
                            <span class="text-gray-800 w-2/3 font-medium text-[13px]" x-text="viewMember.status === 'active' ? 'Active' : 'Inactive'"></span>
                        </div>
                        <div class="py-3.5 flex items-center justify-between">
                            <span class="text-gray-400 w-1/3 text-[13px] font-medium">Gym Fee</span>
                            <span class="text-gray-800 w-2/3 font-bold text-[13px]" x-text="'$' + (viewMember.fee_amount ? parseFloat(viewMember.fee_amount).toFixed(2) : '0.00')"></span>
                        </div>
                        <template x-if="viewMember.trainer_fee > 0">
                            <div class="py-3.5 flex items-center justify-between">
                                <span class="text-gray-400 w-1/3 text-[13px] font-medium">Trainer Fee</span>
                                <span class="text-gray-800 w-2/3 font-bold text-[13px] text-blue-600" x-text="'$' + parseFloat(viewMember.trainer_fee).toFixed(2) + ' /mo'"></span>
                            </div>
                        </template>
                        <template x-if="viewMember.locker_fee > 0">
                            <div class="py-3.5 flex items-center justify-between">
                                <span class="text-gray-400 w-1/3 text-[13px] font-medium">Locker Fee</span>
                                <span class="text-gray-800 w-2/3 font-bold text-[13px] text-purple-600" x-text="'$' + parseFloat(viewMember.locker_fee).toFixed(2) + ' /mo'"></span>
                            </div>
                        </template>
                        <div class="py-3.5 flex items-center justify-between bg-gray-50 -mx-4 px-4 border-y border-gray-100">
                            <span class="text-gray-500 w-1/3 text-[13px] font-bold">Total Monthly</span>
                            <span class="text-green-600 w-2/3 font-bold text-[14px]" x-text="'$' + (parseFloat(viewMember.fee_amount || 0) + parseFloat(viewMember.trainer_fee || 0) + parseFloat(viewMember.locker_fee || 0)).toFixed(2)"></span>
                        </div>
                        <template x-if="viewMember.admission_fee > 0">
                            <div class="py-3.5 flex items-center justify-between">
                                <span class="text-gray-400 w-1/3 text-[13px] font-medium">Admission</span>
                                <span class="text-gray-500 w-2/3 font-medium text-[13px]" x-text="'$' + parseFloat(viewMember.admission_fee).toFixed(2) + ' (Paid once)'"></span>
                            </div>
                        </template>
                        <div class="py-3.5 flex items-center justify-between">
                            <span class="text-gray-400 w-1/3 text-[13px] font-medium">Joined Date</span>
                            <div class="w-2/3 flex items-center justify-between">
                                <span class="text-gray-800 font-medium text-[13px]" x-text="viewMember.joined_date ? new Date(viewMember.joined_date).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' }) : ''"></span>
                            </div>
                        </div>
                        <div class="py-3.5 flex items-center justify-between">
                            <span class="text-gray-400 w-1/3 text-[13px] font-medium">Due Date</span>
                            <div class="w-2/3 flex items-center justify-between">
                                <span class="text-gray-800 font-medium text-[13px]" x-text="viewMember.fee_due_date ? new Date(viewMember.fee_due_date).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' }) : ''"></span>
                                <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Info Section Head -->
                    <div class="bg-gray-100 px-4 py-2 border-y border-gray-200 flex items-center gap-2 mt-2 border-t-0">
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                        <span class="text-xs uppercase tracking-wider font-bold text-black">Contact</span>
                    </div>

                    <!-- Contact List -->
                    <div class="px-4 bg-white divide-y divide-gray-100 text-sm pb-2">
                        <div class="py-3.5 flex items-center justify-between overflow-hidden">
                            <span class="text-gray-400 w-1/3 text-[13px] font-medium mr-4">Phone</span>
                            <span class="text-gray-900 w-2/3 font-medium text-[13px] truncate" x-text="viewMember.contact || ''"></span>
                        </div>
                        <div class="py-3.5 flex items-center justify-between overflow-hidden">
                            <span class="text-gray-400 w-1/3 text-[13px] font-medium mr-4">Email</span>
                            <span class="text-gray-900 w-2/3 font-medium text-[13px] truncate" x-text="viewMember.email || ''"></span>
                        </div>
                    </div>
                </div>

                <!-- Bottom Navigation Bar Dummy -->
                <div class="absolute bottom-0 left-0 w-full bg-white border-t border-gray-200 flex justify-between items-center px-4 py-2 pb-3 shadow-[0_-2px_10px_rgba(0,0,0,0.05)] pt-2.5">
                    <button class="flex flex-col items-center gap-1 text-indigo-600 focus:outline-none">
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                        <span class="text-[9px] font-bold">Details</span>
                    </button>
                    <button class="flex flex-col items-center gap-1 text-gray-400 hover:text-gray-600 transition focus:outline-none">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
                        <span class="text-[9px] font-bold">Membership</span>
                    </button>
                    <button class="flex flex-col items-center gap-1 text-gray-400 hover:text-gray-600 transition focus:outline-none">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        <span class="text-[9px] font-bold">Communication</span>
                    </button>
                    <button class="flex flex-col items-center gap-1 text-gray-400 hover:text-gray-600 transition focus:outline-none">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span class="text-[9px] font-bold">Bookings</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Delete Member?',
            text: "This action cannot be undone.",
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

    let currentStream = null;

    function initCamera(videoElement) {
        if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
            navigator.mediaDevices.getUserMedia({ video: true }).then(function(stream) {
                currentStream = stream;
                videoElement.srcObject = stream;
                videoElement.play();
            }).catch(function(err) {
                console.error("Camera access denied:", err);
                alert("Could not access camera. Please check permissions.");
            });
        } else {
            alert("Camera API is not supported in this browser.");
        }
    }

    function stopCamera(videoElement) {
        if (currentStream) {
            currentStream.getTracks().forEach(track => track.stop());
            videoElement.srcObject = null;
            currentStream = null;
        }
    }

    function captureImage(videoElement, canvasElement) {
        const width = videoElement.videoWidth;
        const height = videoElement.videoHeight;
        
        // Square aspect ratio crop
        const size = Math.min(width, height);
        const startX = (width - size) / 2;
        const startY = (height - size) / 2;

        canvasElement.width = 400; // standard out size
        canvasElement.height = 400;
        const context = canvasElement.getContext('2d');
        
        context.drawImage(videoElement, startX, startY, size, size, 0, 0, 400, 400);
        return canvasElement.toDataURL('image/png'); // returns base64
    }
</script>
@endpush
@endsection
