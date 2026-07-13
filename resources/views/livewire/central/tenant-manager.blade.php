<div>
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Kelola Tenant</h1>

    @if (session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 text-sm rounded-lg p-3 mb-6">
            {{ session('success') }}
        </div>
    @endif

    {{-- Add Tenant Form --}}
    <div class="bg-white rounded-xl shadow p-6 mb-8">
        <h2 class="font-semibold text-gray-800 mb-4">Tambah Tenant Baru</h2>
        <form wire:submit="create" class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">ID Tenant</label>
                <input type="text" wire:model="newId" placeholder="mis. kampus-abc"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 @error('newId') border-red-400 @enderror">
                @error('newId')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Domain</label>
                <input type="text" wire:model="newDomain" placeholder="mis. prosiding.kampusabc.ac.id"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 @error('newDomain') border-red-400 @enderror">
                @error('newDomain')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="flex items-center gap-3">
                <label class="flex items-center gap-2 text-sm text-gray-600">
                    <input type="checkbox" wire:model="copyFromCentral" class="rounded">
                    Salin data dari central
                </label>
            </div>
            <div class="md:col-span-3">
                <button type="submit" wire:loading.attr="disabled" wire:target="create"
                    class="inline-flex items-center gap-2 px-6 py-2.5 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition disabled:opacity-50">
                    <span wire:loading.remove wire:target="create">Buat Tenant</span>
                    <span wire:loading wire:target="create">Memproses (bisa beberapa detik)...</span>
                </button>
            </div>
        </form>

        @if (!empty($lastLog))
            <div class="mt-5 bg-gray-900 text-gray-100 text-xs font-mono rounded-lg p-4 overflow-x-auto">
                @foreach ($lastLog as $line)
                    <div>{{ $line }}</div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Tenant List --}}
    <div class="bg-white rounded-xl shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-left text-gray-500 uppercase text-xs">
                <tr>
                    <th class="px-5 py-3">ID</th>
                    <th class="px-5 py-3">Domain</th>
                    <th class="px-5 py-3">Dibuat</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($tenants as $tenant)
                    <tr>
                        <td class="px-5 py-3 font-medium text-gray-800">{{ $tenant->id }}</td>
                        <td class="px-5 py-3">
                            @forelse ($tenant->domains as $domain)
                                <div class="flex items-center gap-2">
                                    <span>{{ $domain->domain }}</span>
                                    @if ($domain->verified_at)
                                        <span class="text-xs bg-green-100 text-green-700 px-2 py-0.5 rounded-full">verified</span>
                                    @else
                                        <span class="text-xs bg-yellow-100 text-yellow-700 px-2 py-0.5 rounded-full">pending</span>
                                    @endif
                                </div>
                            @empty
                                <span class="text-gray-400">—</span>
                            @endforelse
                        </td>
                        <td class="px-5 py-3 text-gray-500">{{ $tenant->created_at }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-5 py-8 text-center text-gray-400">Belum ada tenant.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
