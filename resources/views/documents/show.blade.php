<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Dokumen') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900">
                <h3 class="text-lg font-bold">{{ $document->title }}</h3>
                <p class="text-sm text-gray-500 mb-4">Pemohon: {{ $document->user->name }} | Status: <span class="font-semibold">{{ $document->status }}</span></p>
                
                <div class="mb-4">
                    <h4 class="font-semibold">Isi / Keterangan:</h4>
                    <p class="whitespace-pre-wrap bg-gray-50 p-4 rounded">{{ $document->content }}</p>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900">
                <h4 class="font-semibold mb-4">Riwayat Persetujuan</h4>
                @if($document->approvals->isEmpty())
                    <p class="text-sm text-gray-500">Belum ada riwayat persetujuan.</p>
                @else
                    <ul class="space-y-4">
                        @foreach($document->approvals as $approval)
                            <li class="border-l-4 {{ $approval->status === 'Approved' ? 'border-green-500' : 'border-red-500' }} pl-4">
                                <p class="text-sm font-semibold">{{ $approval->user->name }} ({{ $approval->status }})</p>
                                <p class="text-sm text-gray-600">Catatan: {{ $approval->notes ?? '-' }}</p>
                                <p class="text-xs text-gray-400">{{ $approval->created_at->format('d M Y H:i') }}</p>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

            @if($document->currentStep && auth()->user()->hasRole($document->currentStep->role->name) && $document->status === 'Pending')
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900">
                <h4 class="font-semibold mb-4">Form Persetujuan</h4>
                <form method="POST" id="approval-form">
                    @csrf
                    <div class="mb-4">
                        <label for="notes" class="block text-sm font-medium text-gray-700">Catatan</label>
                        <textarea name="notes" id="notes" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required></textarea>
                    </div>
                    <div class="flex space-x-4">
                        <button type="submit" formaction="{{ route('documents.approve', $document->id) }}" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Setujui</button>
                        <button type="submit" formaction="{{ route('documents.reject', $document->id) }}" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Tolak</button>
                    </div>
                </form>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
