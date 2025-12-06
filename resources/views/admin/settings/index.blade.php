<form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
@csrf

<label>Hospital Name</label>
<input type="text" name="hospital_name" class="form-control"
       value="{{ $settings['hospital_name'] ?? '' }}">

<label>Hospital Logo</label>
<input type="file" name="hospital_logo" class="form-control">

@if(isset($settings['hospital_logo']))
    <img src="{{ asset('uploads/logo/'.$settings['hospital_logo']) }}" height="80">
@endif
