@extends('layouts.gym')

@section('content')
<div class="space-y-4 md:space-y-6" x-data="{ addModalOpen: false, editModalOpen: false, payModalOpen: false, editStaff: {}, payStaff: {} }">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
            <h1 class="text-xl md:text-2xl font-bold text-zinc-100">Staff Management</h1>
            <p class="text-xs text-zinc-500 mt-0.5">Manage your gym team members</p>
        </div>
        <button @click="addModalOpen = true" class="self-start sm:self-auto bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition shadow-sm whitespace-nowrap flex items-center gap-2">
            <i class="ph-bold ph-plus text-base"></i> Add Staff
        </button>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead class="bg-gray-50 text-gray-500 uppercase tracking-wider border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4 font-medium">Staff Member</th>
                        <th class="px-6 py-4 font-medium">Role</th>
                        <th class="px-6 py-4 font-medium">Base Salary</th>
                        <th class="px-6 py-4 font-medium text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($staff as $member)
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
                                    <div class="text-gray-500 text-xs font-normal">{{ $member->contact ?? 'No contact' }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                <span class="bg-gray-100 text-gray-800 px-2.5 py-1 rounded-full text-xs font-medium">{{ $member->role }}</span>
                            </td>
                            <td class="px-6 py-4 font-bold text-gray-900">
                                ${{ number_format($member->salary, 2) }}
                            </td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <button @click="payStaff = {{ json_encode($member) }}; payModalOpen = true" class="text-white bg-green-500 hover:bg-green-600 px-3 py-1.5 rounded text-xs font-bold transition shadow-sm">Pay Salary</button>
                                <button @click="editStaff = {{ json_encode($member) }}; editModalOpen = true" class="text-blue-600 hover:text-blue-900 font-medium px-2">Edit</button>
                                <form method="POST" action="{{ route('staff.destroy', $member) }}" class="inline" id="delete-form-{{ $member->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" onclick="confirmDelete('{{ $member->id }}')" class="text-red-500 hover:text-red-700 font-medium px-2 border-l border-gray-200">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                No staff found. Add a staff member to start managing your team.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($staff->hasPages())
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $staff->links() }}
        </div>
        @endif
    </div>

    <!-- Add Modal -->
    <div x-show="addModalOpen" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <div x-show="addModalOpen" class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" @click="addModalOpen = false"></div>
            <div class="relative inline-block w-full max-w-lg p-6 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-2xl">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-lg font-bold text-gray-900">Add Staff</h3>
                    <button @click="addModalOpen = false" class="text-gray-400 hover:text-gray-500 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <form action="{{ route('staff.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Full Name <span class="text-red-500">*</span></label>
                            <input type="text" name="name" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Role <span class="text-red-500">*</span></label>
                            <input type="text" name="role" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm" placeholder="e.g. Trainer, Receptionist">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Monthly Salary ($) <span class="text-red-500">*</span></label>
                            <input type="number" step="0.01" name="salary" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Contact Number</label>
                            <input type="text" name="contact" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Joined Date <span class="text-red-500">*</span></label>
                            <input type="date" name="joined_date" value="{{ date('Y-m-d') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
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
                        <button type="button" @click="addModalOpen = false" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">Cancel</button>
                        <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-primary rounded-lg hover:bg-blue-800">Save</button>
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
                    <h3 class="text-lg font-bold text-gray-900">Edit Staff</h3>
                    <button @click="editModalOpen = false" class="text-gray-400 hover:text-gray-500 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <form :action="'{{ url('staff') }}/' + editStaff.id" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Full Name</label>
                            <input type="text" name="name" x-model="editStaff.name" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Role</label>
                            <input type="text" name="role" x-model="editStaff.role" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Salary ($)</label>
                            <input type="number" step="0.01" name="salary" x-model="editStaff.salary" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Contact Number</label>
                            <input type="text" name="contact" x-model="editStaff.contact" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Joined Date</label>
                            <input type="date" name="joined_date" x-model="editStaff.joined_date ? editStaff.joined_date.substring(0,10) : ''" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Photo</label>
                            <input type="file" name="photo" accept="image/*" class="mt-1 block w-full text-sm text-gray-500 border border-gray-300 rounded-md py-2 px-3 focus:outline-none">
                            <p class="text-xs text-gray-500 mt-1">Leave empty to keep current photo.</p>
                        </div>
                    </div>
                    <div class="pt-4 flex justify-end gap-3 border-t border-gray-100">
                        <button type="button" @click="editModalOpen = false" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">Cancel</button>
                        <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-primary rounded-lg hover:bg-blue-800">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Pay Modal -->
    <div x-show="payModalOpen" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <div x-show="payModalOpen" class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" @click="payModalOpen = false"></div>
            <div class="relative inline-block w-full max-w-md p-6 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-2xl">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-lg font-bold text-gray-900">Pay Staff Salary</h3>
                    <button @click="payModalOpen = false" class="text-gray-400 hover:text-gray-500 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <form :action="'{{ url('staff') }}/' + payStaff.id + '/pay'" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <p class="text-gray-600 mb-4">Record a salary payment for <span class="font-bold text-gray-900" x-text="payStaff.name"></span>.</p>
                        <label class="block text-sm font-medium text-gray-700">Amount ($) <span class="text-red-500">*</span></label>
                        <input type="number" step="0.01" name="amount" x-model="payStaff.salary" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
                    </div>
                    <div class="pt-4 flex justify-end gap-3 border-t border-gray-100">
                        <button type="button" @click="payModalOpen = false" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">Cancel</button>
                        <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-green-500 rounded-lg hover:bg-green-600 shadow-sm">Confirm Payment</button>
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
