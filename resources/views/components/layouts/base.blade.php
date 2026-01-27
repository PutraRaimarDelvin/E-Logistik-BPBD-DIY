<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ $title ?? 'E-Logistik BPBD DIY' }}</title>

  {{-- Tailwind via CDN --}}
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="//unpkg.com/alpinejs" defer></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


  <link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

      <style>
      /* Disable browser built-in password reveal icon */
      input[type="password"]::-ms-reveal,
      input[type="password"]::-ms-clear {
        display: none;
      }

      input[type="password"]::-webkit-credentials-auto-fill-button,
      input[type="password"]::-webkit-textfield-decoration-container {
        display: none !important;
      }
    </style>


  <style>
    :root{
      --brand1:#BE7B34; /* orange */
      --brand2:#7A4A24; /* brown */
    }
    /* HANYA dipakai jika butuh, jangan dipasang di <body> */
    .bg-brand{
      background:
        radial-gradient(1200px 600px at 30% 20%, rgba(255,255,255,.10), transparent 60%),
        linear-gradient(135deg, var(--brand2) 0%, var(--brand1) 45%, #F39C3D 100%);
    }
  </style>
</head>
<body class="min-h-screen overflow-hidden text-[#2A1B0F] antialiased font-sans"
      style="background: radial-gradient(140% 80% at 10% 10%, #E5E7EB 0%, #e7e8eaff 45%, #d0d2d6ff 100%);">
  {{ $slot }}
</body>
</html>
