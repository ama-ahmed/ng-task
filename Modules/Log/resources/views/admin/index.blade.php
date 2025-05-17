<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Activity Logs') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <p class="mb-2 bg-yellow-50 w-fit p-2 rounded-md">click on record to show the logs data</p>
                    <div class="overflow-x-auto relative">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="py-3 px-6">ID</th>
                                    <th scope="col" class="py-3 px-6">Description</th>
                                    <th scope="col" class="py-3 px-6">Event</th>
                                    <th scope="col" class="py-3 px-6">Model</th>
                                    <th scope="col" class="py-3 px-6">Model ID</th>
                                    <th scope="col" class="py-3 px-6">User</th>
                                    <th scope="col" class="py-3 px-6">User Type</th>
                                    <th scope="col" class="py-3 px-6">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($items as $item)
                                <tr class="bg-white border-b hover:bg-gray-50 cursor-pointer log-row transition duration-150 ease-in-out" data-properties="{{ $item->properties }}" data-id="{{ $item->id }}">
                                    <td class="py-4 px-6">{{ $item->id }}</td>
                                    <td class="py-4 px-6">{{ $item->description }}</td>
                                    <td class="py-4 px-6">
                                        @if($item->event == 'created')
                                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">{{ ucfirst($item->event) }}</span>
                                        @elseif($item->event == 'updated')
                                        <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-medium">{{ ucfirst($item->event) }}</span>
                                        @elseif($item->event == 'deleted')
                                        <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs font-medium">{{ ucfirst($item->event) }}</span>
                                        @else
                                        <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded-full text-xs font-medium">{{ ucfirst($item->event) }}</span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-6">{{ class_basename($item->subject_type) }}</td>
                                    <td class="py-4 px-6">{{ $item->subject_id }}</td>
                                    <td class="py-4 px-6">
                                        @if($item->causer_type)
                                        @if(class_basename($item->causer_type) == 'User')
                                        {{ $item->causer->name ?? 'Unknown User' }}
                                        @else
                                        {{ 'ID: ' . $item->causer_id }}
                                        @endif
                                        @else
                                        System
                                        @endif
                                    </td>
                                    <td class="py-4 px-6">
                                        @if($item->causer_type)
                                        <span class="px-2 py-1 bg-indigo-100 text-indigo-800 rounded-full text-xs font-medium">{{ class_basename($item->causer_type) }}</span>
                                        @else
                                        <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded-full text-xs font-medium">System</span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-6">{{ $item->created_at->format('d M Y') }}<br><span class="text-xs text-gray-500">{{ $item->created_at->format('H:i:s') }}</span></td>
                                </tr>
                                @empty
                                <tr class="bg-white border-b">
                                    <td colspan="8" class="py-4 px-6 text-center">No logs found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $items->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Improved Modal with animation and better styling -->
    <div id="propertiesModal" class="fixed inset-0 bg-gray-800 bg-opacity-75 hidden overflow-y-auto h-full w-full z-50 transition-opacity duration-300 ease-in-out opacity-0">
        <div class="relative top-20 mx-auto p-0 border-0 w-11/12 md:w-3/4 lg:w-1/2 shadow-2xl rounded-lg bg-white transform transition-transform duration-300 ease-in-out scale-95">
            <!-- Modal Header with gradient background -->
            <div class="bg-gradient-to-r from-blue-500 to-indigo-600 rounded-t-lg px-6 py-4">
                <div class="flex justify-between items-center">
                    <h3 class="text-xl font-bold text-white" id="modalTitle">Changes Details</h3>
                    <button id="closeModal" class="text-white hover:text-gray-200 transition duration-150 ease-in-out">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Modal Content with improved spacing and styling -->
            <div id="modalContent" class="p-6">
                <div id="oldValues" class="mb-6">
                    <h4 class="font-semibold text-gray-800 mb-3 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Previous Values:
                    </h4>
                    <div id="oldValuesContent" class="bg-gray-50 p-4 rounded-lg border border-gray-200 shadow-inner"></div>
                </div>
                <div id="newValues">
                    <h4 class="font-semibold text-gray-800 mb-3 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        New Values:
                    </h4>
                    <div id="newValuesContent" class="bg-gray-50 p-4 rounded-lg border border-gray-200 shadow-inner"></div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="bg-gray-50 px-6 py-3 rounded-b-lg border-t border-gray-200">
                <button id="closeModalBtn" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded transition duration-150 ease-in-out">
                    Close
                </button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('propertiesModal');
            const closeModal = document.getElementById('closeModal');
            const closeModalBtn = document.getElementById('closeModalBtn');
            const oldValuesContent = document.getElementById('oldValuesContent');
            const newValuesContent = document.getElementById('newValuesContent');
            const modalTitle = document.getElementById('modalTitle');

            function openModal() {
                modal.classList.remove('hidden');
                // Trigger a reflow before adding the opacity class
                void modal.offsetWidth;
                modal.classList.remove('opacity-0');
                modal.querySelector('.relative').classList.remove('scale-95');
                modal.querySelector('.relative').classList.add('scale-100');
            }

            function closeModalFunc() {
                modal.classList.add('opacity-0');
                modal.querySelector('.relative').classList.remove('scale-100');
                modal.querySelector('.relative').classList.add('scale-95');
                setTimeout(() => {
                    modal.classList.add('hidden');
                }, 300);
            }

            closeModal.addEventListener('click', closeModalFunc);
            closeModalBtn.addEventListener('click', closeModalFunc);

            window.addEventListener('click', function(event) {
                if (event.target === modal) {
                    closeModalFunc();
                }
            });

            // Format date helper function
            function formatDate(dateString) {
                if (!dateString) return '';

                const date = new Date(dateString);
                if (isNaN(date.getTime())) return dateString; // Return original if invalid

                const options = {
                    year: 'numeric',
                    month: 'short',
                    day: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit'
                };

                return new Intl.DateTimeFormat('en-US', options).format(date);
            }

            // Format value helper function
            function formatValue(value, key) {
                if (value === null || value === undefined) return '<span class="text-gray-400 italic">null</span>';

                // Check if it's a date field
                if (key.includes('_at') || key.includes('date')) {
                    return formatDate(value);
                }

                // Handle boolean values
                if (typeof value === 'boolean') {
                    return value ?
                        '<span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">Yes</span>' :
                        '<span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs">No</span>';
                }

                // Return as string for other types
                return String(value);
            }

            // Add click event to log rows
            document.querySelectorAll('.log-row').forEach(row => {
                row.addEventListener('click', function() {
                    const propertiesStr = this.getAttribute('data-properties');
                    const logId = this.getAttribute('data-id');

                    let properties;
                    try {
                        properties = JSON.parse(propertiesStr);
                    } catch (e) {
                        properties = {};
                        console.error('Failed to parse properties JSON:', e);
                    }

                    modalTitle.innerHTML = `<span class="text-white">Changes Details</span> <span class="text-white bg-white/20 px-2 py-1 rounded-full text-sm ml-2">Log #${logId}</span>`;

                    oldValuesContent.innerHTML = '';
                    newValuesContent.innerHTML = '';

                    if (properties && properties.old && Object.keys(properties.old).length > 0) {
                        let oldTable = '<table class="min-w-full divide-y divide-gray-200 table-fixed"><thead class="bg-gray-100"><tr><th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/3">Field</th><th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-2/3">Value</th></tr></thead><tbody class="divide-y divide-gray-200">';

                        for (const [key, value] of Object.entries(properties.old)) {
                            oldTable += `<tr class="hover:bg-gray-50"><td class="px-4 py-3 text-sm font-medium text-gray-900">${key}</td><td class="px-4 py-3 text-sm text-gray-700">${formatValue(value, key)}</td></tr>`;
                        }

                        oldTable += '</tbody></table>';
                        oldValuesContent.innerHTML = oldTable;
                    } else {
                        oldValuesContent.innerHTML = '<div class="flex items-center justify-center p-4 text-gray-500"><svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>No previous values available</div>';
                    }

                    if (properties && properties.attributes && Object.keys(properties.attributes).length > 0) {
                        let newTable = '<table class="min-w-full divide-y divide-gray-200 table-fixed"><thead class="bg-gray-100"><tr><th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/3">Field</th><th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-2/3">Value</th></tr></thead><tbody class="divide-y divide-gray-200">';

                        for (const [key, value] of Object.entries(properties.attributes)) {
                            newTable += `<tr class="hover:bg-gray-50"><td class="px-4 py-3 text-sm font-medium text-gray-900">${key}</td><td class="px-4 py-3 text-sm text-gray-700">${formatValue(value, key)}</td></tr>`;
                        }

                        newTable += '</tbody></table>';
                        newValuesContent.innerHTML = newTable;
                    } else {
                        newValuesContent.innerHTML = '<div class="flex items-center justify-center p-4 text-gray-500"><svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>No new values available</div>';
                    }

                    openModal();
                });
            });
        });
    </script>
</x-app-layout>