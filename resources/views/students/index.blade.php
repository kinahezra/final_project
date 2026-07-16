<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Students') }}
                </h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    {{ __('Manage student records in one place.') }}
                </p>
            </div>

            <a
                href="{{ route('students.create') }}"
                class="inline-flex items-center justify-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150"
            >
                {{ __('Add Student') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div id="student-alert"></div>
            @if (session('status') === 'student-created')
                <div class="px-4 py-3 rounded-lg border border-green-200 dark:border-green-800 bg-green-50 dark:bg-green-900/30 text-sm text-green-700 dark:text-green-300">
                    {{ __('Student created successfully.') }}
                </div>
            @elseif (session('status') === 'student-updated')
                <div class="px-4 py-3 rounded-lg border border-green-200 dark:border-green-800 bg-green-50 dark:bg-green-900/30 text-sm text-green-700 dark:text-green-300">
                    {{ __('Student updated successfully.') }}
                </div>
            @elseif (session('status') === 'student-deleted')
                <div class="px-4 py-3 rounded-lg border border-green-200 dark:border-green-800 bg-green-50 dark:bg-green-900/30 text-sm text-green-700 dark:text-green-300">
                    {{ __('Student deleted successfully.') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between gap-4">
                    <div>
                        <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100">
                            {{ __('Student List') }}
                        </h3>
                        <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400" id="student-count-text">
                            {{ trans_choice('{0} No students yet|{1} :count student|[2,*] :count students', $students->total(), ['count' => $students->total()]) }}
                        </p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-left">
                        <thead class="bg-gray-50 dark:bg-gray-900/50">
                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                <th scope="col" class="px-6 py-3.5 font-semibold text-gray-600 dark:text-gray-300 whitespace-nowrap">{{ __('First Name') }}</th>
                                <th scope="col" class="px-6 py-3.5 font-semibold text-gray-600 dark:text-gray-300 whitespace-nowrap">{{ __('Last Name') }}</th>
                                <th scope="col" class="px-6 py-3.5 font-semibold text-gray-600 dark:text-gray-300 whitespace-nowrap">{{ __('Email') }}</th>
                                <th scope="col" class="px-6 py-3.5 font-semibold text-gray-600 dark:text-gray-300 whitespace-nowrap">{{ __('Student Number') }}</th>
                                <th scope="col" class="px-6 py-3.5 font-semibold text-gray-600 dark:text-gray-300 whitespace-nowrap">{{ __('Year Level') }}</th>
                                <th scope="col" class="px-6 py-3.5 font-semibold text-gray-600 dark:text-gray-300 whitespace-nowrap">{{ __('Course') }}</th>
                                <th scope="col" class="px-6 py-3.5 font-semibold text-gray-600 dark:text-gray-300 whitespace-nowrap text-right">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700/80" id="student-table">
                            @forelse ($students as $student)
                                <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700/40 transition-colors" data-student-id="{{ $student->id }}">
                                    <td class="px-6 py-4 text-gray-900 dark:text-gray-100 font-medium whitespace-nowrap">{{ $student->first_name }}</td>
                                    <td class="px-6 py-4 text-gray-900 dark:text-gray-100 font-medium whitespace-nowrap">{{ $student->last_name }}</td>
                                    <td class="px-6 py-4 text-gray-600 dark:text-gray-300 whitespace-nowrap">{{ $student->email }}</td>
                                    <td class="px-6 py-4 text-gray-600 dark:text-gray-300 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-md bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 font-mono text-xs">
                                            {{ $student->student_number }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full bg-indigo-50 dark:bg-indigo-900/40 text-indigo-700 dark:text-indigo-300 text-xs font-semibold">
                                            {{ __($student->year_level_label) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-gray-600 dark:text-gray-300 whitespace-nowrap">{{ $student->course }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <div class="inline-flex items-center gap-2">
                                            <a href="{{ route('students.edit', $student) }}" class="inline-flex items-center px-3 py-1.5 rounded-md border border-gray-300 dark:border-gray-600 text-xs font-semibold uppercase tracking-wide text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                                                {{ __('Edit') }}
                                            </a>
                                            <form method="POST" action="{{ route('students.destroy', $student) }}" onsubmit="return confirm('{{ __('Are you sure you want to delete this student?') }}');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center px-3 py-1.5 rounded-md border border-red-200 dark:border-red-800 text-xs font-semibold uppercase tracking-wide text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/30 transition">
                                                    {{ __('Delete') }}
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr data-empty-state>
                                    <td colspan="7" class="px-6 py-16 text-center">
                                        <div class="mx-auto max-w-sm">
                                            <p class="text-base font-medium text-gray-900 dark:text-gray-100">{{ __('No students yet') }}</p>
                                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ __('Add your first student to start building the list.') }}</p>
                                            <a href="{{ route('students.create') }}" class="mt-5 inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white transition">{{ __('Add Student') }}</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($students->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                        {{ $students->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Live WebSocket Channel Engine Integration -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (typeof Echo !== 'undefined') {
                const channel = Echo.channel('students');
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

                function formatYearLevel(level) {
                    if (!level) return '';
                    let lvlStr = level.toString().trim();
                    if (lvlStr === '1' || lvlStr.toLowerCase() === '1st year') return '1st Year';
                    if (lvlStr === '2' || lvlStr.toLowerCase() === '2nd year') return '2nd Year';
                    if (lvlStr === '3' || lvlStr.toLowerCase() === '3rd year') return '3rd Year';
                    if (lvlStr === '4' || lvlStr.toLowerCase() === '4th year') return '4th Year';
                    return level;
                }

                function adjustStudentCount(change) {
                    const countText = document.getElementById('student-count-text');
                    if (countText) {
                        const currentText = countText.textContent.trim();
                        const match = currentText.match(/\d+/);
                        let currentCount = match ? parseInt(match[0], 10) : 0;
                        
                        if (currentText.toLowerCase().includes('no students')) {
                            currentCount = 0;
                        }

                        const newCount = Math.max(0, currentCount + change);
                    
                        if (newCount === 0) {
                            countText.textContent = "No students yet";
                        } else if (newCount === 1) {
                            countText.textContent = "1 student";
                        } else {
                            countText.textContent = `${newCount} students`;
                        }
                        console.log(`[WS Live Counter] Adjusted count from ${currentCount} to ${newCount}`);
                    }
                }

                function generateRowInnerHtml(data) {
                    const rawLevel = data.year_level_label || data.year_level || '';
                    const yearLevel = formatYearLevel(rawLevel);
                    
                    return `
                        <td class="px-6 py-4 text-gray-900 dark:text-gray-100 font-medium whitespace-nowrap">${data.first_name || ''}</td>
                        <td class="px-6 py-4 text-gray-900 dark:text-gray-100 font-medium whitespace-nowrap">${data.last_name || ''}</td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300 whitespace-nowrap">${data.email || ''}</td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 font-mono text-xs">${data.student_number || ''}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full bg-indigo-50 dark:bg-indigo-900/40 text-indigo-700 dark:text-indigo-300 text-xs font-semibold">${yearLevel}</span>
                        </td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300 whitespace-nowrap">${data.course || ''}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <div class="inline-flex items-center gap-2">
                                <a href="/students/${data.id}/edit" class="inline-flex items-center px-3 py-1.5 rounded-md border border-gray-300 dark:border-gray-600 text-xs font-semibold uppercase tracking-wide text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition">Edit</a>
                                <form method="POST" action="/students/${data.id}" onsubmit="return confirm('Are you sure you want to delete this student?');">
                                    <input type="hidden" name="_token" value="${csrfToken}">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="inline-flex items-center px-3 py-1.5 rounded-md border border-red-200 dark:border-red-800 text-xs font-semibold uppercase tracking-wide text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/30 transition">Delete</button>
                                </form>
                            </div>
                        </td>
                    `;
                }

                function triggerAlert(msg, bgTheme = 'bg-blue-50 dark:bg-blue-900/30', borderTheme = 'border-blue-200 dark:border-blue-800', textTheme = 'text-blue-700 dark:text-blue-300') {
                    const box = document.getElementById('student-alert');
                    if (box) {
                        box.innerHTML = `<div class="px-4 py-3 rounded-lg border ${borderTheme} ${bgTheme} text-sm ${textTheme} transition-all">${msg}</div>`;
                        setTimeout(() => box.innerHTML = '', 5000);
                    }
                }

                // 1. LISTEN FOR CREATE
                channel.listen('.student.created', (payload) => {
                    try {
                        const data = payload.student ? payload.student : payload;
                        
                        const existingRow = document.querySelector(`tr[data-student-id="${data.id}"]`);
                        if (existingRow) {
                            existingRow.innerHTML = generateRowInnerHtml(data);
                            return;
                        }

                        document.querySelector('[data-empty-state]')?.remove();
                        const body = document.getElementById('student-table');
                        if (body) {
                            const tr = document.createElement('tr');
                            tr.setAttribute('data-student-id', data.id);
                            tr.className = "bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700/40 transition-colors border-b border-gray-100 dark:border-gray-700/80";
                            tr.innerHTML = generateRowInnerHtml(data);
                            body.insertBefore(tr, body.firstChild);
                            
                            adjustStudentCount(1);
                            
                            const name = (data.first_name || data.last_name) ? `${data.first_name || ''} ${data.last_name || ''}` : 'A new student';
                            triggerAlert(`Student <strong>${name}</strong> has been created dynamically!`);
                        }
                    } catch (err) {
                        console.error('Error on student.created:', err);
                    }
                });

                // 2. LISTEN FOR UPDATE
                channel.listen('.student.updated', (payload) => {
                    try {
                        const data = payload.student ? payload.student : payload;
                        const targetedRow = document.querySelector(`tr[data-student-id="${data.id}"]`);
                        if (targetedRow) {
                            targetedRow.innerHTML = generateRowInnerHtml(data);
                            targetedRow.classList.add('bg-amber-50', 'dark:bg-amber-900/20');
                            setTimeout(() => targetedRow.classList.remove('bg-amber-50', 'dark:bg-amber-900/20'), 2000);
                            
                            const name = (data.first_name || data.last_name) ? `${data.first_name || ''} ${data.last_name || ''}` : 'A student profile';
                            triggerAlert(`Student <strong>${name}</strong> was updated live!`, 'bg-amber-50 dark:bg-amber-900/30', 'border-amber-200 dark:border-amber-800', 'text-amber-700 dark:text-amber-300');
                        }
                    } catch (err) {
                        console.error('Error on student.updated:', err);
                    }
                });

                // 3. LISTEN FOR DELETE (NAITAMA ANG LOGIC DITO)
                channel.listen('.student.deleted', (payload) => {
                    try {
                        console.log("WS Received -> Deleted Event Payload:", payload);
                        
                        // Kukunin ang array mula sa studentData property, kung wala, gagamitin ang payload
                        const data = payload.studentData ? payload.studentData : payload;
                        const studentId = data.id || null;
                        
                        if (studentId) {
                            const targetedRow = document.querySelector(`tr[data-student-id="${studentId}"]`);
                            if (targetedRow) {
                                // Alisin ang row sa DOM
                                targetedRow.remove();
                                
                                // Bawasan ang counter ng -1
                                adjustStudentCount(-1);

                                // I-render ang Empty State kapag zero na ang natitira
                                const body = document.getElementById('student-table');
                                if (body && body.querySelectorAll('tr[data-student-id]').length === 0) {
                                    body.innerHTML = `
                                        <tr data-empty-state>
                                            <td colspan="7" class="px-6 py-16 text-center">
                                                <div class="mx-auto max-w-sm">
                                                    <p class="text-base font-medium text-gray-900 dark:text-gray-100">No students yet</p>
                                                </div>
                                            </td>
                                        </tr>
                                    `;
                                }
                                
                                // Gumawa ng dinamikong alert gamit ang pangalan mula sa payload
                                const fullName = (data.first_name || data.last_name) 
                                    ? `${data.first_name || ''} ${data.last_name || ''}`.trim() 
                                    : '';
                                    
                                const alertMsg = fullName 
                                    ? `Student <strong>${fullName}</strong> was deleted live.` 
                                    : 'A student profile has been removed live.';
                                    
                                triggerAlert(alertMsg, 'bg-red-50 dark:bg-red-900/30', 'border-red-200 dark:border-red-800', 'text-red-700 dark:text-red-400');
                            }
                        }
                    } catch (err) {
                        console.error('Error on student.deleted:', err);
                    }
                });
            }
        });
    </script>
</x-app-layout>