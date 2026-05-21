@extends('layouts.app')

@section('content')
<h4>Add Parameters for {{ $lab_test->name }}</h4>

<form method="POST" action="{{ route('lab.parameters.store', $lab_test->id) }}">
    @csrf

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <table class="table" id="parameterTable">
        <thead>
            <tr>
                <th>Name</th>
                <th>Unit</th>
                <th>Reference Range</th>
                <th width="60">
                    <button type="button" class="btn btn-success btn-xs" id="addParameterRow">
                        <i class="fa fa-plus"></i>
                    </button>
                </th>
            </tr>
        </thead>
        <tbody>
            @php
                $names = old('name', []);
                $units = old('unit', []);
                $refs = old('ref', []);
            @endphp

            @if(count($names) > 0)
                @foreach($names as $index => $name)
                    <tr>
                        <td>
                            <input type="text"
                                   name="name[]"
                                   class="form-control"
                                   value="{{ $name }}">
                        </td>
                        <td>
                            <input type="text"
                                   name="unit[]"
                                   class="form-control"
                                   value="{{ $units[$index] ?? '' }}">
                        </td>
                        <td>
                            <input type="text"
                                   name="ref[]"
                                   class="form-control"
                                   value="{{ $refs[$index] ?? '' }}">
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger btn-xs removeParameterRow">
                                <i class="fa fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td><input type="text" name="name[]" class="form-control"></td>
                    <td><input type="text" name="unit[]" class="form-control"></td>
                    <td><input type="text" name="ref[]" class="form-control"></td>
                    <td>
                        <button type="button" class="btn btn-danger btn-xs removeParameterRow">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
            @endif
        </tbody>
    </table>

    <button class="btn btn-success">Save</button>
    <a href="{{ route('lab.parameters.index', $lab_test->id) }}" class="btn btn-secondary">Back</a>

</form>
@endsection

@push('scripts')
<script>
$(function() {
    function parameterRow() {
        return `
            <tr>
                <td><input type="text" name="name[]" class="form-control"></td>
                <td><input type="text" name="unit[]" class="form-control"></td>
                <td><input type="text" name="ref[]" class="form-control"></td>
                <td>
                    <button type="button" class="btn btn-danger btn-xs removeParameterRow">
                        <i class="fa fa-trash"></i>
                    </button>
                </td>
            </tr>
        `;
    }

    $('#addParameterRow').on('click', function() {
        $('#parameterTable tbody').append(parameterRow());
    });

    $(document).on('click', '.removeParameterRow', function() {
        if ($('#parameterTable tbody tr').length > 1) {
            $(this).closest('tr').remove();
        }
    });
});
</script>
@endpush
