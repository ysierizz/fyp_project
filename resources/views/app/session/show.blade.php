<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Sessions') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-2xl font-semibold mb-4">Sessions</h1>
                    <table class="table-auto w-full">
                        <thead>
                            <tr>
                                <th class="px-4 py-2">Session ID</th>
                                <th class="px-4 py-2">User ID</th>
                                <th class="px-4 py-2">IP Address</th>
                                <th class="px-4 py-2">Last Activity</th>
                                <th class="px-4 py-2">Session Remark</th>
                                <th class="px-4 py-2">Updated At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sessions as $session)
                            <tr>
                                <td class="border px-4 py-2">{{ $session->sess_id }}</td>
                                <td class="border px-4 py-2">{{ $session->user_id }}</td>
                                <td class="border px-4 py-2">{{ $session->ip_address }}</td>
                                <td class="border px-4 py-2">{{ $session->last_activity }}</td>
                                <td class="border px-4 py-2">{{ $session->sess_remark }}</td>
                                <td class="border px-4 py-2">{{ $session->updated_at }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
