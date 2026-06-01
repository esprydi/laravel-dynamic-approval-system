<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard') }}
            </h2>
            @if(auth()->user()->hasRole('Staff'))
                <a href="{{ route('documents.create') }}" class="px-4 py-2 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700 shadow">+ Tambahkan Document</a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if(auth()->user()->hasRole(['Supervisor', 'Manager']))
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-bold">Antrean Persetujuan</h3>
                        </div>
                        
                        <table class="min-w-full divide-y divide-gray-200 mt-4">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Pemohon</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($pendingApprovals as $doc)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $doc->user->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $doc->title }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $doc->created_at->format('d M Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="{{ route('documents.show', $doc->id) }}" class="text-indigo-600 hover:text-indigo-900">Tinjau Dokumen</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-bold">Dokumen Saya</h3>
                        </div>
                        
                        <table class="min-w-full divide-y divide-gray-200 mt-4">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($myDocuments as $doc)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $doc->title }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $doc->status }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $doc->created_at->format('d M Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="{{ route('documents.show', $doc->id) }}" class="text-indigo-600 hover:text-indigo-900">Lihat</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
