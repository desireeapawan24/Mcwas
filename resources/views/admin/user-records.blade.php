@extends('layouts.app')

@section('content')
<!-- SweetAlert2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

<div class="max-w-7xl mx-auto px-4 py-6">
	<h1 class="text-2xl font-bold mb-4 capitalize">{{ $role }} Records</h1>

	@if(session('created_user'))
		@php($cu = session('created_user'))
		<div class="mb-4 bg-green-50 border border-green-200 rounded p-4">
			<div class="flex items-start justify-between">
				<div>
					<p class="text-green-800 font-semibold">New {{ ucfirst($cu['role']) }} created</p>
					<p class="text-sm text-green-700">Provide these temporary credentials to the user.</p>
				</div>
				<button onclick="window.printCredentials()" class="px-3 py-1 text-sm bg-green-600 text-white rounded hover:bg-green-700">Print</button>
			</div>
			<div id="printableCredentials" class="mt-3 bg-white border rounded p-4">
				<h2 class="text-lg font-bold mb-2">Temporary Account</h2>
				<div class="text-sm space-y-1">
					<p><span class="font-medium">Name:</span> {{ $cu['name'] }}</p>
					<p><span class="font-medium">Role:</span> {{ ucfirst($cu['role']) }}</p>
					<p><span class="font-medium">Email:</span> {{ $cu['email'] }}</p>
					<p><span class="font-medium">Temporary Password:</span> {{ $cu['password'] }}</p>
					<p class="text-xs text-gray-500">Advise the user to log in and change the password immediately.</p>
				</div>
			</div>
		</div>
	@endif

	<div class="flex justify-between items-center mb-4">
		<a href="{{ route('admin.create-user') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Create {{ ucfirst($role) }}</a>
		
		<!-- Search Bar -->
		<div class="flex items-center space-x-2">
			<div class="relative">
				<input type="text" 
					   id="searchInput" 
					   placeholder="Search {{ ucfirst($role) }}s..." 
					   class="w-64 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
				<div class="absolute inset-y-0 right-0 flex items-center pr-3">
					<svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
					</svg>
				</div>
			</div>
			<button id="clearSearch" 
					class="px-3 py-2 text-gray-500 hover:text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50"
					style="display: none;">
				Clear
			</button>
			<div id="searchResults" class="text-sm text-gray-500" style="display: none;">
				<span id="resultCount">0</span> results found
			</div>
		</div>
	</div>

	<div class="bg-white rounded shadow">
		<table class="min-w-full divide-y divide-gray-200">
			<thead class="bg-gray-50">
				<tr>
					<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer #</th>
					<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
					<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
					<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Address</th>
					<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Phone</th>
					<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Temp Password</th>
					<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
					<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
				</tr>
			</thead>
			<tbody id="usersTableBody" class="bg-white divide-y divide-gray-200">
				@forelse($users as $u)
				<tr class="user-row" data-name="{{ strtolower($u->full_name) }}" data-email="{{ strtolower($u->email) }}" data-phone="{{ strtolower($u->phone_number) }}" data-address="{{ strtolower($u->address) }}" data-customer-number="{{ strtolower($u->customer_number) }}">
					<td class="px-6 py-4">
						<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
							{{ $u->customer_number }}
						</span>
					</td>
					<td class="px-6 py-4">{{ $u->full_name }}</td>
					<td class="px-6 py-4">{{ $u->email }}</td>
					<td class="px-6 py-4">{{ $u->address }}</td>
					<td class="px-6 py-4">{{ $u->phone_number }}</td>
					<td class="px-6 py-4">
						<span class="font-mono text-sm bg-gray-100 px-2 py-1 rounded">{{ $u->plain_password }}</span>
					</td>
					<td class="px-6 py-4">
						<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
							{{ $u->status === 'active' ? 'bg-green-100 text-green-800' : 
							   ($u->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
							{{ ucfirst($u->status) }}
						</span>
					</td>
					<td class="px-6 py-4">
						<div class="flex space-x-2">
							<button onclick="editUser({{ $u->id }})" 
								class="text-blue-600 hover:text-blue-800 text-sm font-medium">
								Edit
							</button>
							<button onclick="deleteUser({{ $u->id }}, '{{ $u->full_name }}')" 
								class="text-red-600 hover:text-red-800 text-sm font-medium">
								Delete
							</button>
						</div>
					</td>
				</tr>
				@empty
				<tr><td colspan="8" class="px-6 py-4 text-gray-500">No records</td></tr>
				@endforelse
			</tbody>
		</table>
	</div>
</div>

<!-- Edit User Modal -->
<div id="editUserModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">Edit User</h3>
                <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <form id="editUserForm" method="POST">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
                        <input type="text" name="first_name" id="edit_first_name" required class="w-full border px-3 py-2 rounded">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
                        <input type="text" name="last_name" id="edit_last_name" required class="w-full border px-3 py-2 rounded">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" id="edit_email" required class="w-full border px-3 py-2 rounded">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                        <input type="text" name="phone_number" id="edit_phone_number" required class="w-full border px-3 py-2 rounded">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                        <textarea name="address" id="edit_address" rows="3" required class="w-full border px-3 py-2 rounded"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select name="status" id="edit_status" class="w-full border px-3 py-2 rounded">
                            <option value="active">Active</option>
                            <option value="pending">Pending</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">New Password (optional)</label>
                        <input type="text" name="password" id="edit_password" class="w-full border px-3 py-2 rounded" placeholder="Leave empty to keep current password">
                    </div>
                </div>
                <div class="mt-6 flex justify-end space-x-2">
                    <button type="button" onclick="closeEditModal()" class="px-4 py-2 text-sm bg-gray-200 rounded">Cancel</button>
                    <button type="submit" class="px-4 py-2 text-sm text-white bg-blue-600 rounded hover:bg-blue-700">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
// Make functions globally available
window.printCredentials = function() {
    const content = document.getElementById('printableCredentials');
    if (!content) return;
    const w = window.open('', '', 'height=600,width=420');
    w.document.write('<html><head><title>Temporary Account</title>');
    w.document.write('</head><body>');
    w.document.write(content.outerHTML);
    w.document.write('</body></html>');
    w.document.close();
    w.focus();
    w.print();
    w.close();
}

window.editUser = function(userId) {
    console.log('Edit user clicked for ID:', userId);
    
    if (!userId) {
        console.error('No user ID provided');
        Swal.fire('Error', 'No user ID provided', 'error');
        return;
    }
    
    // Show loading state
    Swal.fire({
        title: 'Loading...',
        text: 'Please wait while we load user data',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });
    
    // Fetch user data
    fetch(`/admin/users/${userId}`, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    })
    .then(response => {
        console.log('Response status:', response.status);
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        console.log('User data received:', data);
        Swal.close();
        
        if (data.success) {
            const user = data.user;
            document.getElementById('edit_first_name').value = user.first_name || '';
            document.getElementById('edit_last_name').value = user.last_name || '';
            document.getElementById('edit_email').value = user.email || '';
            document.getElementById('edit_phone_number').value = user.phone_number || '';
            document.getElementById('edit_address').value = user.address || '';
            document.getElementById('edit_status').value = user.status || 'active';
            document.getElementById('edit_password').value = '';
            
            document.getElementById('editUserForm').action = `/admin/users/${userId}`;
            document.getElementById('editUserModal').classList.remove('hidden');
        } else {
            Swal.fire('Error', data.message || 'Failed to load user data', 'error');
        }
    })
    .catch(error => {
        console.error('Error fetching user data:', error);
        Swal.close();
        Swal.fire('Error', 'Failed to load user data: ' + error.message, 'error');
    });
}

window.closeEditModal = function() {
    document.getElementById('editUserModal').classList.add('hidden');
}

window.deleteUser = function(userId, userName) {
    console.log('Delete user clicked for ID:', userId, 'Name:', userName);
    
    if (!userId) {
        console.error('No user ID provided');
        Swal.fire('Error', 'No user ID provided', 'error');
        return;
    }
    
    Swal.fire({
        title: 'Are you sure?',
        text: `You are about to delete user "${userName}". This action cannot be undone!`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            console.log('User confirmed deletion, proceeding...');
            
            // Show loading state
            Swal.fire({
                title: 'Deleting...',
                text: 'Please wait while we delete the user',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            // Create form and submit
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/admin/users/${userId}`;
            
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            
            const methodField = document.createElement('input');
            methodField.type = 'hidden';
            methodField.name = '_method';
            methodField.value = 'DELETE';
            
            form.appendChild(csrfToken);
            form.appendChild(methodField);
            document.body.appendChild(form);
            
            console.log('Submitting delete form to:', form.action);
            form.submit();
        } else {
            console.log('User cancelled deletion');
        }
    });
}

// Handle form submission with SweetAlert
document.getElementById('editUserForm').addEventListener('submit', function(e) {
    e.preventDefault();
    console.log('Edit form submitted');
    
    const formData = new FormData(this);
    formData.append('_method', 'PUT');
    const url = this.action;
    
    console.log('Submitting to URL:', url);
    console.log('Form data:', Object.fromEntries(formData));
    
    // Show loading state
    Swal.fire({
        title: 'Updating...',
        text: 'Please wait while we update the user',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });
    
    fetch(url, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(async response => {
        console.log('Update response status:', response.status);
        const isJson = response.headers.get('content-type')?.includes('application/json');
        if (response.status === 422 && isJson) {
            const errorData = await response.json();
            const messages = errorData.errors ? Object.values(errorData.errors).flat() : [errorData.message || 'Validation failed'];
            throw new Error(messages.join('\n'));
        }
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return isJson ? response.json() : {};
    })
    .then(data => {
        console.log('Update response data:', data);
        Swal.close();
        
        if (!data || data.success) {
            Swal.fire('Success', data.message, 'success').then(() => {
                location.reload();
            });
        } else {
            Swal.fire('Error', data.message || 'Failed to update user', 'error');
        }
    })
    .catch(error => {
        console.error('Update error:', error);
        Swal.close();
        Swal.fire('Error', (error && error.message) ? error.message : 'Failed to update user', 'error');
    });
});

// Search functionality
document.getElementById('searchInput').addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase().trim();
    const userRows = document.querySelectorAll('.user-row');
    const clearButton = document.getElementById('clearSearch');
    const searchResults = document.getElementById('searchResults');
    const resultCount = document.getElementById('resultCount');
    
    let visibleCount = 0;
    
    userRows.forEach(row => {
        const name = row.getAttribute('data-name') || '';
        const email = row.getAttribute('data-email') || '';
        const phone = row.getAttribute('data-phone') || '';
        const address = row.getAttribute('data-address') || '';
        const customerNumber = row.getAttribute('data-customer-number') || '';
        
        // Check if any field contains the search term
        const matches = name.includes(searchTerm) || 
                       email.includes(searchTerm) || 
                       phone.includes(searchTerm) || 
                       address.includes(searchTerm) || 
                       customerNumber.includes(searchTerm);
        
        if (matches || searchTerm === '') {
            row.style.display = '';
            if (searchTerm !== '') visibleCount++;
        } else {
            row.style.display = 'none';
        }
    });
    
    // Show/hide clear button and results
    if (searchTerm !== '') {
        clearButton.style.display = 'block';
        searchResults.style.display = 'block';
        resultCount.textContent = visibleCount;
    } else {
        clearButton.style.display = 'none';
        searchResults.style.display = 'none';
    }
    
    // Update "No records" message visibility
    updateNoRecordsMessage(visibleCount, searchTerm);
});

// Clear search functionality
document.getElementById('clearSearch').addEventListener('click', function() {
    document.getElementById('searchInput').value = '';
    document.getElementById('searchInput').dispatchEvent(new Event('input'));
});

function updateNoRecordsMessage(visibleCount, searchTerm) {
    const noRecordsRow = document.querySelector('tr td[colspan="8"]');
    
    if (visibleCount === 0 && searchTerm !== '') {
        if (noRecordsRow) {
            noRecordsRow.style.display = '';
            noRecordsRow.textContent = 'No matching records found';
        }
    } else if (noRecordsRow) {
        noRecordsRow.style.display = 'none';
    }
}
</script>
@endpush



