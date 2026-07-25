<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>419 - หน้าเว็บหมดอายุ | DDPHONE ดีดีโฟน</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Prompt', sans-serif;
            background: radial-gradient(circle at top, #1E293B 0%, #0F172A 70%, #020617 100%);
            min-height: 100vh;
        }
    </style>
</head>
<body class="flex items-center justify-center text-slate-100 p-4">
    <div class="max-w-md w-full text-center bg-slate-800/90 backdrop-blur-xl border border-slate-700/80 shadow-2xl rounded-3xl p-8">
        <div class="w-20 h-20 mx-auto mb-4 bg-amber-500/10 text-amber-400 rounded-3xl flex items-center justify-center border border-amber-500/20 text-3xl shadow-lg shadow-amber-500/10">
            <i class="fa-solid fa-clock-rotate-left"></i>
        </div>
        <h1 class="text-3xl font-extrabold text-white mb-2">419 - หน้าเว็บหมดอายุ</h1>
        <p class="text-sm text-slate-300 mb-6 leading-relaxed">
            หน้าเว็บหรือเซสชันของคุณหมดอายุลงเนื่องจากเปิดทิ้งไว้นานเกินไป กรุณากดรีเฟรชหน้าเว็บแล้วทำรายการอีกครั้งครับ
        </p>
        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <button onclick="window.location.reload()" class="w-full sm:w-auto px-6 py-3 bg-gradient-to-r from-indigo-600 to-blue-600 hover:from-indigo-500 hover:to-blue-500 text-white font-bold rounded-xl shadow-lg shadow-indigo-600/30 transition text-sm flex items-center justify-center gap-2">
                <i class="fa-solid fa-rotate-right"></i> รีเฟรชหน้าเว็บ
            </button>
            <a href="{{ url('/') }}" class="w-full sm:w-auto px-6 py-3 bg-slate-700 hover:bg-slate-600 text-slate-200 font-bold rounded-xl transition text-sm flex items-center justify-center gap-2">
                <i class="fa-solid fa-house"></i> กลับหน้าหลัก
            </a>
        </div>
    </div>
</body>
</html>
