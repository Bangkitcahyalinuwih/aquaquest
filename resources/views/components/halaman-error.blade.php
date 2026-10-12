@props(['kode', 'judul', 'pesan'])
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $kode }} - {{ $judul }}</title>
    <style>
        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #F0FDFA;
            color: #0F172A;
            font-family: system-ui, -apple-system, Segoe UI, Roboto, sans-serif;
        }

        main {
            text-align: center;
            padding: 24px;
            max-width: 480px;
        }

        .emoji {
            font-size: 56px;
            margin: 0;
        }

        .kode {
            font-size: 64px;
            font-weight: 800;
            color: #0E7490;
            margin: 0;
            line-height: 1.1;
        }

        h1 {
            font-size: 22px;
            margin: 8px 0;
        }

        p {
            color: #475569;
            line-height: 1.6;
        }

        a {
            display: inline-block;
            margin-top: 16px;
            padding: 10px 20px;
            background: #0E7490;
            color: #fff;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
        }

        a:hover {
            background: #155E75;
        }
    </style>
</head>

<body>
    <main>
        <p class="emoji">🌊</p>
        <p class="kode">{{ $kode }}</p>
        <h1>{{ $judul }}</h1>
        <p>{{ $pesan }}</p>
        <a href="{{ url('/') }}">Kembali ke Beranda</a>
    </main>
</body>

</html>