<!DOCTYPE html>
<html lang="th">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>DDPHONE ดีดีโฟน - เข้าสู่ระบบ / สมัครสมาชิก</title>

        <!-- Fonts & Icons -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            html, body {
                font-family: 'Prompt', sans-serif;
                background-color: #E2E8F0;
                min-height: 100vh;
                margin: 0;
                padding: 0;
            }

            /* Fix input text visibility and browser autofill */
            .auth-input-field {
                width: 100%;
                padding: 12px 16px;
                background-color: #FFFFFF !important;
                color: #0F172A !important;
                -webkit-text-fill-color: #0F172A !important;
                border: 2px solid #CBD5E1 !important;
                border-radius: 14px;
                font-size: 0.92rem;
                font-weight: 500;
                outline: none;
                transition: all 0.2s ease;
                box-shadow: inset 0 1px 2px rgba(0,0,0,0.03);
                box-sizing: border-box;
            }

            .auth-input-field:focus {
                border-color: #1B2A47 !important;
                box-shadow: 0 0 0 4px rgba(27, 42, 71, 0.15) !important;
            }

            .auth-input-field::placeholder {
                color: #94A3B8 !important;
                -webkit-text-fill-color: #94A3B8 !important;
                opacity: 1 !important;
            }

            /* Webkit Autofill Override */
            input:-webkit-autofill,
            input:-webkit-autofill:hover, 
            input:-webkit-autofill:focus, 
            input:-webkit-autofill:active {
                -webkit-box-shadow: 0 0 0 1000px #FFFFFF inset !important;
                -webkit-text-fill-color: #0F172A !important;
                color: #0F172A !important;
                caret-color: #0F172A !important;
                transition: background-color 5000s ease-in-out 0s;
            }

            .btn-primary-navy {
                width: 100%;
                padding: 13px 20px;
                background: linear-gradient(135deg, #1B2A47 0%, #121C30 100%);
                color: #FFFFFF;
                font-weight: 700;
                font-size: 0.95rem;
                border: none;
                border-radius: 14px;
                cursor: pointer;
                box-shadow: 0 8px 20px rgba(27, 42, 71, 0.3);
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 8px;
                text-decoration: none;
                transition: all 0.2s ease;
                box-sizing: border-box;
            }

            .btn-primary-navy:hover {
                background: linear-gradient(135deg, #2A3B5C 0%, #1B2A47 100%);
                transform: translateY(-1px);
                box-shadow: 0 12px 24px rgba(27, 42, 71, 0.4);
            }

            .btn-secondary-gold {
                width: 100%;
                padding: 13px 20px;
                background: #F59E0B;
                color: #0F172A;
                font-weight: 800;
                font-size: 0.95rem;
                border: none;
                border-radius: 14px;
                cursor: pointer;
                box-shadow: 0 6px 16px rgba(245, 158, 11, 0.35);
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 8px;
                text-decoration: none;
                transition: all 0.2s ease;
                box-sizing: border-box;
            }

            .btn-secondary-gold:hover {
                background: #D97706;
                color: #FFFFFF;
                transform: translateY(-1px);
                box-shadow: 0 10px 20px rgba(245, 158, 11, 0.45);
            }
        </style>
    </head>
    <body style="background-color: #E2E8F0; margin: 0; padding: 0; min-height: 100vh; display: flex; flex-direction: column; justify-content: space-between;">
        <!-- Top Navy Blue Banner Section -->
        <div style="background: linear-gradient(135deg, #0F172A 0%, #1B2A47 60%, #121C30 100%); padding-top: 1.5rem; padding-bottom: 7rem; border-bottom-left-radius: 36px; border-bottom-right-radius: 36px; box-shadow: 0 10px 25px rgba(15, 23, 42, 0.25); position: relative;">
            <div style="max-width: 1100px; margin: 0 auto; padding: 0 1.5rem;">
                <a href="{{ url('/') }}" style="color: #FFFFFF; text-decoration: none; font-size: 0.95rem; font-weight: 600; display: inline-flex; align-items: center; gap: 8px; opacity: 0.9; transition: opacity 0.2s;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.9'">
                    <i class="fa-solid fa-chevron-left" style="font-size: 0.8rem;"></i> กลับหน้าหลัก
                </a>
            </div>
        </div>

        <!-- Main Card Container (Floating cleanly over the blue banner boundary) -->
        <div style="width: 100%; max-width: 440px; margin: -5.5rem auto 2.5rem; padding: 0 1rem; position: relative; z-index: 10; box-sizing: border-box;">
            <!-- White Card -->
            <div style="background: #FFFFFF; border-radius: 28px; border-top: 5px solid #F59E0B; padding: 2.25rem 2rem 2.5rem; box-shadow: 0 20px 45px rgba(15, 23, 42, 0.25), 0 0 0 1px rgba(0, 0, 0, 0.05); position: relative;">
                <!-- Logo Badge Wrapper -->
                <div style="width: 88px; height: 88px; margin: -68px auto 1rem; background: #070D1B; border-radius: 50%; padding: 4px; box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2); border: 4px solid #FFE600; display: flex; align-items: center; justify-content: center; position: relative; z-index: 20;">
                    <img src="{{ asset('images/logoddphone.png') }}" alt="DDPHONE Logo" style="width: 100%; height: 100%; object-fit: contain; border-radius: 50%;" onerror="this.src='{{ asset('logoddphone.png') }}'">
                </div>

                {{ $slot }}
            </div>
        </div>

        <!-- Footer Copyright -->
        <div style="text-align: center; padding: 1.25rem; font-size: 0.82rem; color: #475569; font-weight: 700; margin-top: auto;">
            © {{ date('Y') }} DDPHONE ดีดีโฟน — ศูนย์รวมสมาร์ทโฟนมือสองคัดเกรด A+ รับประกัน 30 วัน
        </div>
    </body>
</html>
