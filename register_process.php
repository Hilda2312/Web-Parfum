<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Berhasil</title>
    <style>
        /* Reset gaya dasar */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Gaya keseluruhan halaman dengan gambar latar belakang */
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            font-family: 'Arial', sans-serif;
            background: url('https://i.pinimg.com/736x/a9/4f/af/a94faf3b2efab737a52d370d3136294b.jpg') no-repeat center center fixed;
            background-size: cover;
            color: #333;
        }

        /* Container untuk pesan sukses */
        .container {
            background: rgba(255, 255, 255, 0.9); /* Transparansi putih agar teks mudah dibaca */
            padding: 2.5rem;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
            text-align: center;
            max-width: 400px;
            width: 100%;
            animation: fadeIn 1s ease-in-out;
        }

        /* Animasi fade-in */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Gaya judul */
        .container h1 {
            font-size: 2.2rem;
            color: #e53935;
            margin-bottom: 1rem;
        }

        /* Gaya teks deskripsi */
        .container p {
            font-size: 1.1rem;
            color: #666;
            margin-bottom: 1.5rem;
        }

        /* Gaya tombol */
        .btn {
            display: inline-block;
            padding: 0.8rem 2rem;
            border-radius: 50px;
            background: linear-gradient(135deg, #e53935, #ff5252);
            color: #fff;
            font-weight: bold;
            text-decoration: none;
            font-size: 1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(229, 57, 53, 0.3);
        }

        /* Efek hover tombol */
        .btn:hover {
            background: linear-gradient(135deg, #ff5252, #e53935);
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(229, 57, 53, 0.5);
        }

        /* Efek hover teks */
        .btn:hover span {
            margin-right: 5px;
        }

        /* Efek anak panah pada teks */
        .btn span {
            display: inline-block;
            transition: margin 0.3s;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Registrasi Berhasil!</h1>
        <p>Akun Anda telah berhasil dibuat. Silakan login untuk melanjutkan.</p>
        <a href="login.html" class="btn"><span>Login Sekarang</span> ➔</a>
    </div>
</body>
</html>
