@extends('layouts.gym')

@section('content')
<div class="space-y-4 md:space-y-6" x-data="{ addModalOpen: false, editModalOpen: false, payModalOpen: false, editStaff: {}, payStaff: {} }">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
            <h1 class="text-xl md:text-2xl font-bold text-zinc-900 dark:text-zinc-100">Staff Management</h1>
            <p class="text-xs text-zinc-500 mt-0.5">Manage your gym team members</p>
        </div>
        <button @click="addModalOpen = true" class="self-start sm:self-auto bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition shadow-sm whitespace-nowrap flex items-center gap-2">
            <i class="ph-bold ph-plus text-base"></i> Add Staff
        </button>
    </div>

    {{-- Staff Table --}}
    <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead class="bg-zinc-50 dark:bg-zinc-800/50 text-zinc-500 dark:text-zinc-400 uppercase tracking-wider text-[11px] border-b border-zinc-200 dark:border-zinc-800">
                    <tr>
                        <th class="px-6 py-4 font-semibold">Staff Member</th>
                        <th class="px-6 py-4 font-semibold">Role</th>
                        <th class="px-6 py-4 font-semibold">Base Salary</th>
                        <th class="px-6 py-4 font-semibold text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800/60">
                    @forelse($staff as $member)
                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/30 transition">
                            <td class="px-6 py-4 flex items-center gap-3">
                                @if($member->photo)
                                    <img src="{{ asset('storage/' . $member->photo) }}" class="w-10 h-10 rounded-full object-cover border border-zinc-200 dark:border-zinc-700 shrink-0">
                                @else
                                    <div class="w-10 h-10 rounded-full bg-zinc-100 dark:bg-zinc-800 text-zinc-500 dark:text-zinc-400 flex items-center justify-center font-bold border border-zinc-200 dark:border-zinc-700 shrink-0">
                                        {{ substr($member->name, 0, 1) }}
                                    </div>
                                @endif
                                <div>
                                    <div class="text-zinc-900 dark:text-zinc-100 font-semibold">{{ $member->name }}</div>
                                    <div class="text-zinc-500 text-xs font-normal">{{ $member->contact ?? 'No contact' }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 border border-zinc-200 dark:border-zinc-700 px-2.5 py-1 rounded-full text-xs font-medium">{{ $member->role }}</span>
                            </td>
                            <td class="px-6 py-4 font-bold text-zinc-900 dark:text-zinc-100">
                                ${{ number_format($member->salary, 2) }}
                            </td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <button @click="payStaff = {{ json_encode($member) }}; payModalOpen = true"
                                        class="text-white bg-emerald-600 hover:bg-emerald-700 px-3 py-1.5 rounded-lg text-xs font-bold transition shadow-sm">
                                    Pay Salary
                                </button>
                                <button @click="editStaff = {{ json_encode($member) }}; editModalOpen = true"
                                        class="text-amber-500 dark:text-amber-400 hover:text-amber-700 dark:hover:text-amber-300 font-medium px-2">
                                    Edit
                                </button>
                                <form method="POST" action="{{ route('staff.destroy', $member) }}" class="inline" id="delete-form-{{ $member->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" onclick="confirmDelete('{{ $member->id }}')"
                                            class="text-red-500 hover:text-red-700 font-medium px-2 border-l border-zinc-200 dark:border-zinc-700">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <i class="ph-fill ph-briefcase text-zinc-300 dark:text-zinc-700 mb-3" style="font-size:48px;"></i>
                                    <span class="text-base font-medium text-zinc-500 dark:text-zinc-400">No Staff Found</span>
                                    <p class="text-sm text-zinc-400 dark:text-zinc-600 mt-1">Add a staff member to start managing your team.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($staff->hasPages())
        <div class="px-6 py-4 border-t border-zinc-200 dark:border-zinc-800">
            {{ $staff->links() }}
        </div>
        @endif
    </div>

    {{-- Add Modal --}}
    <div x-show="addModalOpen" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <div x-show="addModalOpen" class="fixed inset-0 transition-opacity bg-black/60" @click="addModalOpen = false"></div>
            <div class="relative inline-block w-full max-w-lg p-6 overflow-hidden text-left align-middle transition-all transform bg-white dark:bg-zinc-900 shadow-xl rounded-2xl border border-zinc-200 dark:border-zinc-700">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-lg font-bold text-zinc-900 dark:text-zinc-100">Add Staff</h3>
                    <button @click="addModalOpen = false" class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <form action="{{ route('staff.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Full Name <span class="text-red-500">*</span></label>
                            <input type="text" name="name" required class="mt-1 block w-full rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800 dark:text-zinc-100 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Role <span class="text-red-500">*</span></label>
                            <input type="text" name="role" required placeholder="e.g. Trainer, Receptionist" class="mt-1 block w-full rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800 dark:text-zinc-100 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Monthly Salary ($) <span class="text-red-500">*</span></label>
                            <input type="number" step="0.01" name="salary" required class="mt-1 block w-full rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800 dark:text-zinc-100 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Contact Number</label>
                            <input type="text" name="contact" class="mt-1 block w-full rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800 dark:text-zinc-100 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Joined Date <span class="text-red-500">*</span></label>
                            <input type="date" name="joined_date" value="{{ date('Y-m-d') }}" required class="mt-1 block w-full rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800 dark:text-zinc-100 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Photo</label>
                            <div x-data="{ cameraActive: false, capturedImage: null }" class="space-y-3">
                                <div x-show="!capturedImage" class="flex items-center gap-3">
                                    <input type="file" name="photo" accept="image/*" class="block w-full text-sm text-zinc-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-600 hover:file:bg-red-100 border border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800 rounded-md">
                                    <span class="text-sm text-zinc-400 font-medium">OR</span>
                                    <button type="button" @click="cameraActive = true; initCamera($refs.videoElement)" x-show="!cameraActive" class="px-3 py-2 bg-zinc-100 dark:bg-zinc-700 text-zinc-700 dark:text-zinc-200 rounded-md border border-zinc-300 dark:border-zinc-600 text-sm hover:bg-zinc-200 dark:hover:bg-zinc-600 whitespace-nowrap font-medium flex-shrink-0">
                                        📷 Open Camera
                                    </button>
                                </div>
                                <input type="hidden" name="photo_base64" :value="capturedImage">
                                <div x-show="cameraActive && !capturedImage" class="relative bg-zinc-900 rounded-lg overflow-hidden flex flex-col items-center">
                                    <video x-ref="videoElement" autoplay playsinline class="w-full max-h-64 object-cover"></video>
                                    <div class="absolute bottom-4 left-0 right-0 flex justify-center gap-3">
                                        <button type="button" @click="cameraActive = false; stopCamera($refs.videoElement)" class="px-4 py-2 bg-red-600 text-white rounded-full shadow-md text-sm font-bold hover:bg-red-700">Cancel</button>
                                        <button type="button" @click="capturedImage = captureImage($refs.videoElement, $refs.canvasElement); stopCamera($refs.videoElement); cameraActive = false;" class="px-4 py-2 bg-green-500 text-white rounded-full shadow-md text-sm font-bold hover:bg-green-600">Take Photo</button>
                                    </div>
                                    <canvas x-ref="canvasElement" class="hidden"></canvas>
                                </div>
                                <div x-show="capturedImage" class="relative inline-block">
                                    <img :src="capturedImage" class="h-32 w-32 object-cover rounded-xl border border-zinc-300 dark:border-zinc-600 shadow-sm">
                                    <button type="button" @click="capturedImage = null" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center shadow hover:bg-red-600 text-xs font-bold">&times;</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="pt-4 flex justify-end gap-3 border-t border-zinc-200 dark:border-zinc-700">
                        <button type="button" @click="addModalOpen = false" class="px-4 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-300 bg-white dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-600 rounded-lg hover:bg-zinc-50 dark:hover:bg-zinc-700">Cancel</button>
                        <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Edit Modal --}}
    <div x-show="editModalOpen" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <div x-show="editModalOpen" class="fixed inset-0 transition-opacity bg-black/60" @click="editModalOpen = false"></div>
            <div class="relative inline-block w-full max-w-lg p-6 overflow-hidden text-left align-middle transition-all transform bg-white dark:bg-zinc-900 shadow-xl rounded-2xl border border-zinc-200 dark:border-zinc-700">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-lg font-bold text-zinc-900 dark:text-zinc-100">Edit Staff</h3>
                    <button @click="editModalOpen = false" class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <form :action="'{{ url('staff') }}/' + editStaff.id" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Full Name</label>
                            <input type="text" name="name" x-model="editStaff.name" required class="mt-1 block w-full rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800 dark:text-zinc-100 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Role</label>
                            <input type="text" name="role" x-model="editStaff.role" required class="mt-1 block w-full rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800 dark:text-zinc-100 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Salary ($)</label>
                            <input type="number" step="0.01" name="salary" x-model="editStaff.salary" required class="mt-1 block w-full rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800 dark:text-zinc-100 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Contact Number</label>
                            <input type="text" name="contact" x-model="editStaff.contact" class="mt-1 block w-full rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800 dark:text-zinc-100 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Joined Date</label>
                            <input type="date" name="joined_date" x-model="editStaff.joined_date ? editStaff.joined_date.substring(0,10) : ''" required class="mt-1 block w-full rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800 dark:text-zinc-100 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Photo</label>
                            <input type="file" name="photo" accept="image/*" class="mt-1 block w-full text-sm text-zinc-500 border border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800 rounded-md py-2 px-3 focus:outline-none">
                            <p class="text-xs text-zinc-500 mt-1">Leave empty to keep current photo.</p>
                        </div>
                    </div>
                    <div class="pt-4 flex justify-end gap-3 border-t border-zinc-200 dark:border-zinc-700">
                        <button type="button" @click="editModalOpen = false" class="px-4 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-300 bg-white dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-600 rounded-lg hover:bg-zinc-50 dark:hover:bg-zinc-700">Cancel</button>
                        <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Pay Modal --}}
    <div x-show="payModalOpen" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <div x-show="payModalOpen" class="fixed inset-0 transition-opacity bg-black/60" @click="payModalOpen = false"></div>
            <div class="relative inline-block w-full max-w-md p-6 overflow-hidden text-left align-middle transition-all transform bg-white dark:bg-zinc-900 shadow-xl rounded-2xl border border-zinc-200 dark:border-zinc-700">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-lg font-bold text-zinc-900 dark:text-zinc-100">Pay Staff Salary</h3>
                    <button @click="payModalOpen = false" class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <form :action="'{{ url('staff') }}/' + payStaff.id + '/pay'" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <p class="text-zinc-600 dark:text-zinc-400 mb-4">Record a salary payment for <span class="font-bold text-zinc-900 dark:text-zinc-100" x-text="payStaff.name"></span>.</p>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Amount ($) <span class="text-red-500">*</span></label>
                        <input type="number" step="0.01" name="amount" x-model="payStaff.salary" required class="mt-1 block w-full rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800 dark:text-zinc-100 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm">
                    </div>
                    <div class="pt-4 flex justify-end gap-3 border-t border-zinc-200 dark:border-zinc-700">
                        <button type="button" @click="payModalOpen = false" class="px-4 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-300 bg-white dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-600 rounded-lg hover:bg-zinc-50 dark:hover:bg-zinc-700">Cancel</button>
                        <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 shadow-sm">Confirm Payment</button>
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
            title: 'Delete Staff?',
            text: "This action cannot be undone.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete!'
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
        const size = Math.min(width, height);
        const startX = (width - size) / 2;
        const startY = (height - size) / 2;
        canvasElement.width = 400;
        canvasElement.height = 400;
        const context = canvasElement.getContext('2d');
        context.drawImage(videoElement, startX, startY, size, size, 0, 0, 400, 400);
        return canvasElement.toDataURL('image/png');
    }
</script>
@endpush
@endsection
