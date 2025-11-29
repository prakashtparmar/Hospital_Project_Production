<script src="{{ asset('ace/assets/js/jquery-2.1.4.min.js') }}"></script>
<script src="{{ asset('ace/assets/js/bootstrap.min.js') }}"></script>

{{-- Page Specific --}}
<script src="{{ asset('ace/assets/js/bootstrap-tag.min.js') }}"></script>
<script src="{{ asset('ace/assets/js/jquery.hotkeys.index.min.js') }}"></script>
<script src="{{ asset('ace/assets/js/bootstrap-wysiwyg.min.js') }}"></script>

{{-- Ace Scripts --}}
<script src="{{ asset('ace/assets/js/ace-elements.min.js') }}"></script>
<script src="{{ asset('ace/assets/js/ace.min.js') }}"></script>

<!-- Table View Script -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap.min.js"></script>




<!-- Multiple Permissions Selection Checkbox -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    /**
     * Master Checkbox: Selects/Deselects all permissions and all groups
     * Supports multiple master checkboxes with different IDs (optional)
     */
    function handleMasterCheckbox(masterId) {
        const master = document.getElementById(masterId);
        if (!master) return;

        master.addEventListener('change', function () {
            const checked = master.checked;

            // All permissions
            document.querySelectorAll('input[name="permissions[]"]').forEach(cb => cb.checked = checked);

            // All group-level checkboxes
            document.querySelectorAll('.selectGroup').forEach(cb => cb.checked = checked);
        });
    }

    // Initialize master checkboxes (add IDs of your master checkboxes here)
    ['selectAllMaster', 'selectAllPermissions'].forEach(id => handleMasterCheckbox(id));

    /**
     * Group Checkbox: Selects/Deselects all permissions within the group
     * Works for any checkbox with class 'selectGroup' and ID starting with 'group-'
     */
    document.querySelectorAll('.selectGroup').forEach(groupCheckbox => {
        groupCheckbox.addEventListener('change', function () {
            const group = groupCheckbox.id.replace('group-', '');
            const checked = groupCheckbox.checked;
            document.querySelectorAll('.group-' + group).forEach(cb => cb.checked = checked);
        });
    });
});
</script>


<!-- DataTable For Users Roles

Include DataTables CSS & JS -->
<!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
$(document).ready(function() {
    // Initialize all tables with class 'datatable'
    $('.datatable').each(function() {
        $(this).DataTable({
            responsive: true,
            pageLength: 10,
            // Find the last column and disable ordering for it (assumed to be Actions)
            columnDefs: [
                { orderable: false, targets: -1 }
            ]
        });
    });
});
</script> -->

<!-- DataTable JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<!-- Reusable HMS DataTable Script -->
<script>
document.addEventListener("DOMContentLoaded", function () {

    // Initialize all tables with .datatable class
    $('.datatable').each(function() {

        let disableLastColumn = $(this).data('disable-last-column') ?? true;

        let options = {
            responsive: true,
            pageLength: $(this).data('page-length') ?? 10
        };

        // Disable the last column if marked (Actions)
        if (disableLastColumn) {
            options.columnDefs = [
                { orderable: false, targets: -1 }
            ];
        }

        $(this).DataTable(options);
    });

});
</script>

@stack('scripts')





<!-- Roles Search Script -->
<script>
/**
 * Reusable Permission Selector with Search
 */
function initPermissionSelector({ containerId, searchInputId, masterCheckboxId }) {
    const container = document.getElementById(containerId);
    const searchInput = document.getElementById(searchInputId);
    const masterCheckbox = document.getElementById(masterCheckboxId);

    if (!container || !searchInput || !masterCheckbox) return;

    // Master Select All
    masterCheckbox.addEventListener('change', function () {
        container.querySelectorAll('input[name="permissions[]"]').forEach(cb => cb.checked = masterCheckbox.checked);
        container.querySelectorAll('.selectGroup').forEach(g => g.checked = masterCheckbox.checked);
    });

    // Group Select All
    container.querySelectorAll('.selectGroup').forEach(groupCheckbox => {
        groupCheckbox.addEventListener('change', function () {
            const groupClass = 'group-' + groupCheckbox.id.replace('group-', '');
            container.querySelectorAll('.' + groupClass).forEach(cb => cb.checked = groupCheckbox.checked);
        });
    });

    // Permission Search
    searchInput.addEventListener('input', function() {
        const filter = searchInput.value.toLowerCase();
        const groups = container.querySelectorAll('.permission-group-card');

        groups.forEach(group => {
            let hasMatch = false;
            const permissions = group.querySelectorAll('.permission-item');

            permissions.forEach(item => {
                const label = item.querySelector('label').textContent.toLowerCase();
                item.style.display = label.includes(filter) ? '' : 'none';
                if(label.includes(filter)) hasMatch = true;
            });

            group.style.display = hasMatch ? '' : 'none';
            const groupHeader = group.querySelector('.card-header');
            groupHeader.style.display = filter.length > 0 ? 'none' : '';
        });

        // Hide master select all while searching
        const masterContainer = masterCheckbox.closest('.mb-3');
        masterContainer.style.display = filter.length > 0 ? 'none' : '';
    });
}

document.addEventListener('DOMContentLoaded', function() {
    initPermissionSelector({
        containerId: 'permissionContainer',
        searchInputId: 'permissionSearch',
        masterCheckboxId: 'selectAllMaster'
    });
});
</script>


<script>
$(document).ready(function () {

    function loadSlots() {
        let doctor_id = $('select[name="doctor_id"]').val();
        let date = $('input[name="appointment_date"]').val();

        if (!doctor_id || !date) return;

        $('#appointment_time').html('<option>Loading...</option>');

        $.ajax({
            url: '{{ route("appointments.slots") }}',
            type: 'GET',
            data: { doctor_id: doctor_id, appointment_date: date },
            success: function(res) {
                $('#appointment_time').empty().append('<option value="">-- Select --</option>');

                if (res.slots.length > 0) {
                    $.each(res.slots, function(i, slot) {
                        $('#appointment_time').append('<option value="' + slot + '">' + slot + '</option>');
                    });
                } else {
                    $('#appointment_time').append('<option value="">No Slots Available</option>');
                }
            }
        });
    }

    $('select[name="doctor_id"]').change(loadSlots);
    $('input[name="appointment_date"]').change(loadSlots);

});
</script>
