@foreach ($biometrics as $biometric)
    <button class="btn biometric-data">
        <i class="fa-solid fa-fingerprint"></i>
        <p class="mb-0 mt-1">Biometric {{ $loop->iteration }}</p>
        <i class="fa fa-trash-alt biometric-delete-btn" data-id="{{ $biometric->id }}"></i>
    </button>
@endforeach