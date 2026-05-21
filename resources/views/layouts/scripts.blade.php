<script src="{{ asset('ace/assets/js/jquery-2.1.4.min.js') }}"></script>
<script src="{{ asset('ace/assets/js/bootstrap.min.js') }}"></script>

<script src="{{ asset('ace/assets/js/bootstrap-tag.min.js') }}"></script>
<script src="{{ asset('ace/assets/js/jquery.hotkeys.index.min.js') }}"></script>
<script src="{{ asset('ace/assets/js/bootstrap-wysiwyg.min.js') }}"></script>

<script src="{{ asset('ace/assets/js/ace-elements.min.js') }}"></script>
<script src="{{ asset('ace/assets/js/ace.min.js') }}"></script>

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        function handleMasterCheckbox(masterId) {
            const master = document.getElementById(masterId);
            if (!master) return;
            master.addEventListener('change', function () {
                const checked = master.checked;
                document.querySelectorAll('input[name="permissions[]"]').forEach(cb => cb.checked = checked);
                document.querySelectorAll('.selectGroup').forEach(cb => cb.checked = checked);
            });
        }
        ['selectAllMaster', 'selectAllPermissions'].forEach(id => handleMasterCheckbox(id));

        document.querySelectorAll('.selectGroup').forEach(groupCheckbox => {
            groupCheckbox.addEventListener('change', function () {
                const group = groupCheckbox.id.replace('group-', '');
                const checked = groupCheckbox.checked;
                document.querySelectorAll('.group-' + group).forEach(cb => cb.checked = checked);
            });
        });
    });
</script>

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        $('.datatable').each(function () {
            let disableLastColumn = $(this).data('disable-last-column') ?? true;
            let options = {
                responsive: true,
                pageLength: $(this).data('page-length') ?? 10
            };
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

<script>
    function initPermissionSelector({ containerId, searchInputId, masterCheckboxId }) {
        const container = document.getElementById(containerId);
        const searchInput = document.getElementById(searchInputId);
        const masterCheckbox = document.getElementById(masterCheckboxId);

        if (!container || !searchInput || !masterCheckbox) return;

        masterCheckbox.addEventListener('change', function () {
            container.querySelectorAll('input[name="permissions[]"]').forEach(cb => cb.checked = masterCheckbox.checked);
            container.querySelectorAll('.selectGroup').forEach(g => g.checked = masterCheckbox.checked);
        });

        container.querySelectorAll('.selectGroup').forEach(groupCheckbox => {
            groupCheckbox.addEventListener('change', function () {
                const groupClass = 'group-' + groupCheckbox.id.replace('group-', '');
                container.querySelectorAll('.' + groupClass).forEach(cb => cb.checked = groupCheckbox.checked);
            });
        });

        searchInput.addEventListener('input', function () {
            const filter = searchInput.value.toLowerCase();
            const groups = container.querySelectorAll('.permission-group-card');

            groups.forEach(group => {
                let hasMatch = false;
                const permissions = group.querySelectorAll('.permission-item');

                permissions.forEach(item => {
                    const label = item.querySelector('label').textContent.toLowerCase();
                    item.style.display = label.includes(filter) ? '' : 'none';
                    if (label.includes(filter)) hasMatch = true;
                });

                group.style.display = hasMatch ? '' : 'none';
                const groupHeader = group.querySelector('.card-header');
                groupHeader.style.display = filter.length > 0 ? 'none' : '';
            });

            const masterContainer = masterCheckbox.closest('.mb-3');
            masterContainer.style.display = filter.length > 0 ? 'none' : '';
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        initPermissionSelector({
            containerId: 'permissionContainer',
            searchInputId: 'permissionSearch',
            masterCheckboxId: 'selectAllMaster'
        });
    });
</script>

<script>
    $(document).ready(function () {
        $('#specialtySelect').change(function () {
            let selectedSpecialty = $(this).val().trim();
            let doctorDropdown = $('#doctorSelect');
            doctorDropdown.val("");
            $('#appointment_time').html('<option value="">-- Select Time Slot --</option>');
            doctorDropdown.find('option').hide();
            doctorDropdown.find('option[value=""]').show();

            if (selectedSpecialty === "__ALL__" || selectedSpecialty === "") {
                doctorDropdown.find('option').show();
                return;
            }

            doctorDropdown.find('option').each(function () {
                let sp = $(this).data('specialty');
                if (sp == selectedSpecialty || $(this).val() === "") {
                    $(this).show();
                }
            });
        });

        $('#doctorSelect').change(function () {
            let departmentId = $('#doctorSelect option:selected').data('department');
            $('#departmentSelect').val(departmentId || "").trigger('change');
            loadSlots();
        });

        function loadSlots() {
            let doctor_id = $('#doctorSelect').val();
            let date = $('input[name="appointment_date"]').val();

            if (!doctor_id || !date) return;

            $('#appointment_time').html('<option>Loading...</option>');

            $.ajax({
                url: '{{ route("appointments.slots") }}',
                type: 'GET',
                data: { doctor_id: doctor_id, appointment_date: date },
                success: function (res) {
                    $('#appointment_time').empty().append('<option value="">-- Select --</option>');
                    if (res.slots.length > 0) {
                        $.each(res.slots, function (i, slot) {
                            $('#appointment_time').append('<option value="' + slot + '">' + slot + '</option>');
                        });
                    } else {
                        $('#appointment_time').append('<option value="">No Slots Available</option>');
                    }
                }
            });
        }

        $('input[name="appointment_date"]').change(loadSlots);
    });
</script>

<script>
    $(document).on('submit', '#addUserForm', function (e) {
        e.preventDefault();
        let formData = new FormData(this);
        $.ajax({
            url: "{{ route('users.store') }}",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function () {
                location.reload();
            }
        });
    });

    $(document).on('submit', '#editUserForm', function (e) {
        e.preventDefault();
        let id = $(this).data('id');
        let formData = new FormData(this);

        $.ajax({
            url: "/users/" + id + "/update",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function () {
                location.reload();
            }
        });
    });

    $(document).on('submit', '#rolesForm', function (e) {
        e.preventDefault();
        let id = $(this).data('id');
        $.post("/users/modal/roles/" + id, $(this).serialize(), function () {
            location.reload();
        });
    });

    $(document).on('submit', '#permissionsForm', function (e) {
        e.preventDefault();
        let id = $(this).data('id');
        $.post("/users/modal/permissions/" + id, $(this).serialize(), function () {
            location.reload();
        });
    });

    $(document).on('submit', '#photoForm', function (e) {
        e.preventDefault();
        let id = $(this).data('id');
        let fd = new FormData(this);

        $.ajax({
            url: "/users/modal/photo/" + id,
            type: "POST",
            data: fd,
            processData: false,
            contentType: false,
            success: () => location.reload()
        });
    });

    $(document).on('submit', '#blockForm', function (e) {
        e.preventDefault();
        let id = $(this).data('id');
        $.post("/users/modal/block/" + id, $(this).serialize(), () => location.reload());
    });

    $(document).on('submit', '#resetPasswordForm', function (e) {
        e.preventDefault();
        let id = $(this).data('id');
        $.post("/users/modal/reset-password/" + id, $(this).serialize(), function (res) {
            alert("Password: " + res.password);
            location.reload();
        });
    });
</script>

<script>
    $(document).ready(function () {
        $('#wardSelect').change(function () {
            let ward_id = $(this).val();
            let roomSelect = $('#roomSelect');
            let bedSelect = $('#bedSelect');

            roomSelect.html('<option value="">Loading...</option>');
            bedSelect.html('<option value="">-- Select Bed --</option>');

            if (ward_id === "") {
                roomSelect.html('<option value="">-- Select Room --</option>');
                return;
            }

            $.ajax({
                url: "/ipd/get-rooms/" + ward_id,
                type: "GET",
                success: function (rooms) {
                    roomSelect.html('<option value="">-- Select Room --</option>');
                    rooms.forEach(room => {
                        roomSelect.append(`<option value="${room.id}">${room.room_no}</option>`);
                    });
                }
            });
        });

        $('#roomSelect').change(function () {
            let room_id = $(this).val();
            let bedSelect = $('#bedSelect');

            bedSelect.html('<option value="">Loading...</option>');

            if (room_id === "") {
                bedSelect.html('<option value="">-- Select Bed --</option>');
                return;
            }

            $.ajax({
                url: "/ipd/get-beds/" + room_id,
                type: "GET",
                success: function (beds) {
                    bedSelect.html('<option value="">-- Select Bed --</option>');
                    if (beds.length === 0) {
                        bedSelect.append('<option value="">No Beds Available</option>');
                        return;
                    }
                    beds.forEach(bed => {
                        bedSelect.append(`<option value="${bed.id}">${bed.bed_no}</option>`);
                    });
                }
            });
        });
    });
</script>

<script>
    $(document).ready(function () {
        $('#doctorSelect').change(function () {
            let departmentId = $(this).find(':selected').data('department');
            $('#departmentSelect').val(departmentId || "");
        });
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        let now = new Date();
        let year = now.getFullYear();
        let month = String(now.getMonth() + 1).padStart(2, '0');
        let day = String(now.getDate()).padStart(2, '0');
        let hour = String(now.getHours()).padStart(2, '0');
        let minute = String(now.getMinutes()).padStart(2, '0');
        let formatted = `${year}-${month}-${day}T${hour}:${minute}`;
        if (document.getElementById("admissionDateTime")) {
            document.getElementById("admissionDateTime").value = formatted;
        }
    });
</script>

<script>
    $(document).ready(function () {
        let selected = "{{ isset($selectedPatient) && !empty(optional($selectedPatient)->id) ? optional($selectedPatient)->id : '' }}";
        if (selected !== "") {
            $('#patientSelect').val(selected).trigger('change');
        }
    });
</script>




<!-- <script>
    $(document).ready(function () {

        // Add new prescription row
        $('#btn-add-row').on('click', function () {
            var row = `
            <tr>
                <td><input name="drug_name[]" class="form-control"></td>
                <td><input name="strength[]" class="form-control"></td>
                <td><input name="dose[]" class="form-control"></td>
                <td><input name="route[]" class="form-control"></td>
                <td><input name="frequency[]" class="form-control"></td>
                <td><input name="duration[]" class="form-control"></td>
                <td><input name="instructions[]" class="form-control"></td>
                <td><button type="button" class="btn btn-danger btn-xs btn-remove-row">
                    <i class="fa fa-trash"></i></button>
                </td>
            </tr>
        `;
            $('#prescription-table tbody').append(row);
        });

        // Remove prescription row
        $(document).on('click', '.btn-remove-row', function () {
            if ($('#prescription-table tbody tr').length > 1) {
                $(this).closest('tr').remove();
            }
        });

        // Load history when selecting patient
        $('#consult_patient_id').change(function () {
            var patientId = $(this).val();
            if (!patientId) {
                $('#historyBox').html('<p class="text-muted">Select a patient to load history.</p>');
                return;
            }

            $('#historyBox').html('<p class="text-muted">Loading...</p>');

            $.get('/consultations/patient/' + patientId + '/history', function (res) {
                $('#historyBox').html(res);
            });
        });

    });

</script> -->