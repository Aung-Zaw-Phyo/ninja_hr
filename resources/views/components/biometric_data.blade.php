@foreach ($biometrics as $biometric)
    <button class="btn biometric-data">
        <i class="fa-solid fa-fingerprint"></i>
        <p class="mb-0 mt-1">Biometric {{ $loop->iteration }}</p>
    </button>
@endforeach