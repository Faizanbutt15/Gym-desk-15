@extends('layouts.gym')

@section('content')
<div class="space-y-4 md:space-y-6" x-data="{ addModalOpen: false, editModalOpen: false, editExpense: {} }">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
            <h1 class="text-xl md:text-2xl font-bold text-zinc-900 dark:text-zinc-100">Gym Expenses</h1>
            <p class="text-xs text-zinc-500 mt-0.5">Track and manage your gym's operational costs</p>
        </div>
        <button @click="addModalOpen = true"
                class="self-start sm:self-auto bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition whitespace-nowrap flex items-center gap-2">
            <i class="ph-bold ph-plus"></i> Add Expense
        </button>
    </div>

    {{-- Summary Cards --}}
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3 md:gap-4">
        @php
            $categoryIcons = [
                'Rent'        => ['icon' => 'ph-buildings',        'color' => 'text-blue-400',   'bg' => 'bg-blue-900/20',   'border' => 'border-blue-900/30'],
                'Utilities'   => ['icon' => 'ph-lightning',        'color' => 'text-yellow-400', 'bg' => 'bg-yellow-900/20', 'border' => 'border-yellow-900/30'],
                'Equipment'   => ['icon' => 'ph-barbell',          'color' => 'text-purple-400', 'bg' => 'bg-purple-900/20', 'border' => 'border-purple-900/30'],
                'Maintenance' => ['icon' => 'ph-wrench',           'color' => 'text-orange-400', 'bg' => 'bg-orange-900/20', 'border' => 'border-orange-900/30'],
                'Supplies'    => ['icon' => 'ph-package',          'color' => 'text-teal-400',   'bg' => 'bg-teal-900/20',   'border' => 'border-teal-900/30'],
                'Marketing'   => ['icon' => 'ph-megaphone',        'color' => 'text-pink-400',   'bg' => 'bg-pink-900/20',   'border' => 'border-pink-900/30'],
                'Cleaning'    => ['icon' => 'ph-broom',            'color' => 'text-cyan-400',   'bg' => 'bg-cyan-900/20',   'border' => 'border-cyan-900/30'],
                'Other'       => ['icon' => 'ph-dots-three-circle','color' => 'text-zinc-400',   'bg' => 'bg-zinc-800',      'border' => 'border-zinc-700'],
            ];
        @endphp

        @foreach($categoryTotals as $cat)
            @php $style = $categoryIcons[$cat->category] ?? $categoryIcons['Other']; @endphp
            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-4 flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl {{ $style['bg'] }} {{ $style['border'] }} border flex items-center justify-center shrink-0">
                    <i class="ph-fill {{ $style['icon'] }} {{ $style['color'] }}" style="font-size:20px;"></i>
                </div>
                <div class="min-w-0">
                    <p class="text-[11px] text-zinc-500 uppercase tracking-wide truncate">{{ $cat->category }}</p>
                    <p class="text-lg font-bold text-zinc-900 dark:text-zinc-100">${{ number_format($cat->total, 2) }}</p>
                </div>
            </div>
        @endforeach

        {{-- Grand Total --}}
        <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-900/40 rounded-xl p-4 flex items-center gap-3 col-span-2 sm:col-span-1">
            <div class="w-10 h-10 rounded-xl bg-red-100 dark:bg-red-900/30 border border-red-200 dark:border-red-900/50 flex items-center justify-center shrink-0">
                <i class="ph-fill ph-receipt text-red-400" style="font-size:20px;"></i>
            </div>
            <div class="min-w-0">
                <p class="text-[11px] text-zinc-500 uppercase tracking-wide">Total</p>
                <p class="text-lg font-bold text-red-600 dark:text-red-400">${{ number_format($grandTotal, 2) }}</p>
            </div>
        </div>
    </div>

    {{-- Filters --}}
    <form method="GET" action="{{ route('expenses.index') }}" class="flex flex-wrap gap-2">
        <select name="category" class="bg-white dark:bg-zinc-900 border border-zinc-300 dark:border-zinc-800 text-zinc-700 dark:text-zinc-300 rounded-lg text-sm px-3 py-2 focus:ring-red-500 focus:border-red-500" onchange="this.form.submit()">
            <option value="all">All Categories</option>
            @foreach($categories as $cat)
                <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
            @endforeach
        </select>
        <select name="month" class="bg-white dark:bg-zinc-900 border border-zinc-300 dark:border-zinc-800 text-zinc-700 dark:text-zinc-300 rounded-lg text-sm px-3 py-2 focus:ring-red-500 focus:border-red-500" onchange="this.form.submit()">
            <option value="">All Months</option>
            @foreach(range(1, 12) as $m)
                <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>{{ date('F', mktime(0,0,0,$m,1)) }}</option>
            @endforeach
        </select>
        <select name="year" class="bg-white dark:bg-zinc-900 border border-zinc-300 dark:border-zinc-800 text-zinc-700 dark:text-zinc-300 rounded-lg text-sm px-3 py-2 focus:ring-red-500 focus:border-red-500" onchange="this.form.submit()">
            @foreach($years as $yr)
                <option value="{{ $yr }}" {{ (request('year', now()->year)) == $yr ? 'selected' : '' }}>{{ $yr }}</option>
            @endforeach
        </select>
        @if(request()->hasAny(['category','month','year']))
            <a href="{{ route('expenses.index') }}" class="px-3 py-2 text-sm text-zinc-500 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white border border-zinc-300 dark:border-zinc-700 rounded-lg transition">Clear</a>
        @endif
    </form>

    {{-- Table --}}
    <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-zinc-50 dark:bg-zinc-800/50 text-zinc-500 dark:text-zinc-400 uppercase tracking-wider text-[11px] border-b border-zinc-200 dark:border-zinc-800">
                    <tr>
                        <th class="px-4 py-3 font-semibold">Title</th>
                        <th class="px-4 py-3 font-semibold">Category</th>
                        <th class="px-4 py-3 font-semibold">Amount</th>
                        <th class="px-4 py-3 font-semibold hidden md:table-cell">Date</th>
                        <th class="px-4 py-3 font-semibold hidden lg:table-cell">Notes</th>
                        <th class="px-4 py-3 font-semibold text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800/60">
                    @forelse($expenses as $expense)
                        @php $style = $categoryIcons[$expense->category] ?? $categoryIcons['Other']; @endphp
                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/30 transition">
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg {{ $style['bg'] }} {{ $style['border'] }} border flex items-center justify-center shrink-0">
                                        <i class="ph-fill {{ $style['icon'] }} {{ $style['color'] }}" style="font-size:15px;"></i>
                                    </div>
                                    <span class="text-zinc-900 dark:text-zinc-100 font-medium">{{ $expense->title }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold {{ $style['bg'] }} {{ $style['color'] }} border {{ $style['border'] }}">
                                    {{ $expense->category }}
                                </span>
                            </td>
                            <td class="px-4 py-3 font-bold text-red-400 whitespace-nowrap">
                                ${{ number_format($expense->amount, 2) }}
                            </td>
                            <td class="px-4 py-3 text-zinc-500 dark:text-zinc-400 whitespace-nowrap hidden md:table-cell">
                                {{ $expense->expense_date->format('M d, Y') }}
                            </td>
                            <td class="px-4 py-3 text-zinc-500 dark:text-zinc-400 text-xs hidden lg:table-cell max-w-xs truncate">
                                {{ $expense->notes ?? '—' }}
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-end gap-1.5">
                                    <button @click="editExpense = {{ json_encode($expense) }}; editExpense.expense_date = '{{ $expense->expense_date->format('Y-m-d') }}'; editModalOpen = true"
                                            class="text-white bg-gray-400 hover:bg-gray-500 p-1.5 rounded-lg transition  border-amber-900/30" title="Edit">
                                        <i class="ph-bold ph-pencil" style="font-size:14px;"></i>
                                    </button>
                                    <form method="POST" action="{{ route('expenses.destroy', $expense) }}" id="del-expense-{{ $expense->id }}" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="button" onclick="confirmExpenseDelete('{{ $expense->id }}')"
                                                class="text-white bg-red-500 hover:bg-red-700 p-1.5 rounded-lg transition border border-red-900/30" title="Delete">
                                            <i class="ph-bold ph-trash" style="font-size:14px;"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-14 text-center text-zinc-500">
                                <div class="flex flex-col items-center">
                                    <i class="ph-fill ph-receipt text-zinc-700 mb-3" style="font-size:48px;"></i>
                                    <span class="text-base font-medium text-zinc-400">No Expenses Found</span>
                                    <p class="text-sm text-zinc-600 mt-1">Add your first expense to start tracking costs.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($expenses->hasPages())
        <div class="px-4 py-4 border-t border-zinc-200 dark:border-zinc-800">{{ $expenses->links() }}</div>
        @endif
    </div>

    {{-- ── ADD MODAL ── --}}
    <div x-show="addModalOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4" x-cloak>
        <div class="fixed inset-0 bg-black/70" @click="addModalOpen = false"></div>
        <div class="relative bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-2xl w-full max-w-md shadow-2xl z-10">
            <div class="flex items-center justify-between px-6 py-4 border-b border-zinc-200 dark:border-zinc-800">
                <h2 class="text-base font-bold text-zinc-900 dark:text-zinc-100">Add Expense</h2>
                <button @click="addModalOpen = false" class="text-zinc-500 hover:text-zinc-200 transition">
                    <i class="ph-bold ph-x" style="font-size:18px;"></i>
                </button>
            </div>
            <form method="POST" action="{{ route('expenses.store') }}" class="p-6 space-y-4">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-semibold text-zinc-500 dark:text-zinc-400 mb-1.5 uppercase tracking-wide">Title *</label>
                        <input type="text" name="title" required placeholder="e.g. Monthly Rent"
                               class="w-full bg-zinc-50 dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 text-zinc-900 dark:text-zinc-100 rounded-lg px-3 py-2.5 text-sm focus:ring-red-500 focus:border-red-500 placeholder-zinc-400 dark:placeholder-zinc-600">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-zinc-500 dark:text-zinc-400 mb-1.5 uppercase tracking-wide">Category *</label>
                        <select name="category" required class="w-full bg-zinc-50 dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 text-zinc-900 dark:text-zinc-100 rounded-lg px-3 py-2.5 text-sm focus:ring-red-500 focus:border-red-500">
                            @foreach($categories as $cat)
                                <option value="{{ $cat }}">{{ $cat }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-zinc-500 dark:text-zinc-400 mb-1.5 uppercase tracking-wide">Amount *</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-3 flex items-center text-zinc-400 text-sm">$</span>
                            <input type="number" name="amount" step="0.01" min="0.01" required placeholder="0.00"
                                   class="w-full bg-zinc-50 dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 text-zinc-900 dark:text-zinc-100 rounded-lg pl-7 pr-3 py-2.5 text-sm focus:ring-red-500 focus:border-red-500">
                        </div>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-semibold text-zinc-500 dark:text-zinc-400 mb-1.5 uppercase tracking-wide">Date *</label>
                        <input type="date" name="expense_date" required value="{{ date('Y-m-d') }}"
                               class="w-full bg-zinc-50 dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 text-zinc-900 dark:text-zinc-100 rounded-lg px-3 py-2.5 text-sm focus:ring-red-500 focus:border-red-500">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-semibold text-zinc-500 dark:text-zinc-400 mb-1.5 uppercase tracking-wide">Notes</label>
                        <textarea name="notes" rows="2" placeholder="Optional description..."
                                  class="w-full bg-zinc-50 dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 text-zinc-900 dark:text-zinc-100 rounded-lg px-3 py-2.5 text-sm focus:ring-red-500 focus:border-red-500 placeholder-zinc-400 dark:placeholder-zinc-600 resize-none"></textarea>
                    </div>
                </div>
                <div class="flex gap-3 pt-2">
                    <button type="button" @click="addModalOpen = false" class="flex-1 px-4 py-2.5 rounded-lg border border-zinc-300 dark:border-zinc-700 text-zinc-500 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white hover:border-zinc-400 dark:hover:border-zinc-500 text-sm font-semibold transition">Cancel</button>
                    <button type="submit" class="flex-1 px-4 py-2.5 rounded-lg bg-red-600 hover:bg-red-700 text-white text-sm font-semibold transition">Add Expense</button>
                </div>
            </form>
        </div>
    </div>

    {{-- ── EDIT MODAL ── --}}
    <div x-show="editModalOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4" x-cloak>
        <div class="fixed inset-0 bg-black/70" @click="editModalOpen = false"></div>
        <div class="relative bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-2xl w-full max-w-md shadow-2xl z-10">
            <div class="flex items-center justify-between px-6 py-4 border-b border-zinc-200 dark:border-zinc-800">
                <h2 class="text-base font-bold text-zinc-900 dark:text-zinc-100">Edit Expense</h2>
                <button @click="editModalOpen = false" class="text-zinc-500 hover:text-zinc-200 transition">
                    <i class="ph-bold ph-x" style="font-size:18px;"></i>
                </button>
            </div>
            <template x-if="editModalOpen">
                <form method="POST" :action="`/expenses/${editExpense.id}`" class="p-6 space-y-4">
                    @csrf @method('PUT')
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-semibold text-zinc-500 dark:text-zinc-400 mb-1.5 uppercase tracking-wide">Title *</label>
                            <input type="text" name="title" :value="editExpense.title" required
                                   class="w-full bg-zinc-50 dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 text-zinc-900 dark:text-zinc-100 rounded-lg px-3 py-2.5 text-sm focus:ring-red-500 focus:border-red-500">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-zinc-500 dark:text-zinc-400 mb-1.5 uppercase tracking-wide">Category *</label>
                            <select name="category" required class="w-full bg-zinc-50 dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 text-zinc-900 dark:text-zinc-100 rounded-lg px-3 py-2.5 text-sm focus:ring-red-500 focus:border-red-500">
                                @foreach($categories as $cat)
                                    <option value="{{ $cat }}" :selected="editExpense.category === '{{ $cat }}'">{{ $cat }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-zinc-500 dark:text-zinc-400 mb-1.5 uppercase tracking-wide">Amount *</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-3 flex items-center text-zinc-400 text-sm">$</span>
                                <input type="number" name="amount" step="0.01" min="0.01" :value="editExpense.amount" required
                                       class="w-full bg-zinc-50 dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 text-zinc-900 dark:text-zinc-100 rounded-lg pl-7 pr-3 py-2.5 text-sm focus:ring-red-500 focus:border-red-500">
                            </div>
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-semibold text-zinc-500 dark:text-zinc-400 mb-1.5 uppercase tracking-wide">Date *</label>
                            <input type="date" name="expense_date" :value="editExpense.expense_date" required
                                   class="w-full bg-zinc-50 dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 text-zinc-900 dark:text-zinc-100 rounded-lg px-3 py-2.5 text-sm focus:ring-red-500 focus:border-red-500">
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-semibold text-zinc-500 dark:text-zinc-400 mb-1.5 uppercase tracking-wide">Notes</label>
                            <textarea name="notes" rows="2" :value="editExpense.notes ?? ''"
                                      class="w-full bg-zinc-50 dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 text-zinc-900 dark:text-zinc-100 rounded-lg px-3 py-2.5 text-sm focus:ring-red-500 focus:border-red-500 resize-none"></textarea>
                        </div>
                    </div>
                    <div class="flex gap-3 pt-2">
                        <button type="button" @click="editModalOpen = false" class="flex-1 px-4 py-2.5 rounded-lg border border-zinc-300 dark:border-zinc-700 text-zinc-500 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white hover:border-zinc-400 dark:hover:border-zinc-500 text-sm font-semibold transition">Cancel</button>
                        <button type="submit" class="flex-1 px-4 py-2.5 rounded-lg bg-red-600 hover:bg-red-700 text-white text-sm font-semibold transition">Save Changes</button>
                    </div>
                </form>
            </template>
        </div>
    </div>

</div>

@push('scripts')
<script>
function confirmExpenseDelete(id) {
    Swal.fire({
        title: 'Delete Expense?',
        text: 'This action cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#52525b',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('del-expense-' + id).submit();
        }
    });
}
</script>
@endpush
@endsection
