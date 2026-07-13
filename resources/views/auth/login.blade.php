<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - EMS Portal</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        :root{
            --deep:#274472;
            --blue:#6ea8e0;
            --blue-light:#a9cdf0;
            --sky:#dceafb;
            --text:#3a4a63;
            --text-muted:#8296b3;
        }
        *{box-sizing:border-box;}
        html,body{height:100%;}
        body{
            margin:0;
            font-family:'Poppins',-apple-system,Segoe UI,Roboto,Helvetica,Arial,sans-serif;
            min-height:100vh;
            display:flex;
            align-items:center;
            justify-content:center;
            padding:24px;
            position:relative;
            overflow:hidden;
            background:linear-gradient(160deg,#eaf3fd 0%, #d3e6fa 55%, #c3daf5 100%);
        }
        /* soft ambient blobs, calm and airy */
        body::before, body::after{
            content:"";position:fixed;border-radius:50%;filter:blur(6px);z-index:0;
        }
        body::before{width:460px;height:460px;background:rgba(255,255,255,.55);top:-160px;left:-140px;}
        body::after{width:380px;height:380px;background:rgba(255,255,255,.45);bottom:-160px;right:-120px;}

        .stage{
            position:relative;
            z-index:1;
            width:100%;
            max-width:960px;
            min-height:520px;
            border-radius:28px;
            overflow:hidden;
            display:flex;
            align-items:center;
            justify-content:center;
            padding:40px 20px;
        }
        .stage svg.deco{position:absolute;inset:0;width:100%;height:100%;z-index:0;}

        .brand-top{position:absolute;top:30px;left:50%;transform:translateX(-50%);display:flex;align-items:center;gap:10px;z-index:4;}
        .brand-top .logo-mark{width:34px;height:34px;border-radius:10px;background:rgba(255,255,255,.55);border:1px solid rgba(255,255,255,.7);display:flex;align-items:center;justify-content:center;color:var(--deep);font-size:.95rem;}
        .brand-top span{color:var(--deep);font-weight:700;font-size:.85rem;letter-spacing:.02em;opacity:.85;}

        /* Centered, translucent (frosted glass) login card in calm light blue */
        .login-card{
            position:relative;
            z-index:4;
            width:340px;
            background:rgba(255,255,255,.4);
            backdrop-filter:blur(18px);
            -webkit-backdrop-filter:blur(18px);
            border:1px solid rgba(255,255,255,.65);
            border-radius:22px;
            padding:34px 30px 28px;
            box-shadow:0 25px 60px rgba(110,168,224,.28);
            margin-top:34px;
        }
        .logo-row{display:flex;align-items:center;justify-content:center;gap:9px;margin-bottom:20px;}
        .logo-row .logo-mark{
            width:34px;height:34px;border-radius:10px;
            background:linear-gradient(135deg,var(--blue-light),var(--blue));
            display:flex;align-items:center;justify-content:center;color:#fff;font-size:.9rem;flex-shrink:0;
            box-shadow:0 6px 14px rgba(110,168,224,.35);
        }
        .logo-row span{font-size:.82rem;font-weight:700;color:var(--text);letter-spacing:.02em;}

        .login-card h1{font-size:1.35rem;font-weight:800;margin:0 0 18px;color:var(--deep);text-align:center;}

        .role-toggle{display:flex;background:rgba(255,255,255,.5);border:1px solid rgba(255,255,255,.7);border-radius:10px;padding:3px;margin-bottom:16px;}
        .role-toggle input{display:none;}
        .role-toggle label{
            flex:1;text-align:center;padding:6px 4px;border-radius:8px;font-size:.74rem;font-weight:600;
            color:var(--text-muted);cursor:pointer;transition:.15s;
        }
        .role-toggle input:checked + label{background:linear-gradient(135deg,var(--blue-light),var(--blue));color:#fff;box-shadow:0 6px 14px rgba(110,168,224,.3);}

        .input-group-custom{position:relative;margin-bottom:12px;}
        .input-group-custom i{position:absolute;left:16px;top:50%;transform:translateY(-50%);color:#9db4cf;font-size:.85rem;}
        .form-control-custom{
            width:100%;border:1px solid rgba(255,255,255,.75);background:rgba(255,255,255,.55);color:var(--deep);border-radius:24px;
            padding:12px 16px 12px 40px;font-size:.83rem;font-family:inherit;
        }
        .form-control-custom::placeholder{color:#9db4cf;}
        .form-control-custom:focus{outline:none;border-color:var(--blue);background:rgba(255,255,255,.8);box-shadow:0 0 0 .15rem rgba(110,168,224,.18);}

        .row-opts{display:flex;align-items:center;justify-content:space-between;margin:10px 0 18px;}
        .row-opts label{font-size:.72rem;color:var(--text-muted);display:flex;align-items:center;}
        .row-opts input{margin-right:5px;}

        .btn-signin{
            width:100%;border:none;border-radius:24px;padding:12px;font-weight:700;font-size:.85rem;color:#fff;
            background:linear-gradient(135deg,var(--blue-light),var(--blue) 70%,#5f93cf);
            box-shadow:0 12px 26px rgba(110,168,224,.4);
        }
        .btn-signin:hover{filter:brightness(1.05);color:#fff;}

        .alert-custom{border-radius:10px;font-size:.76rem;padding:8px 12px;margin-bottom:12px;}

        .foot-note{margin-top:16px;text-align:center;font-size:.66rem;color:var(--text-muted);line-height:1.5;}
        .foot-note b{color:var(--text);}

        @media (max-width: 760px){
            .stage{padding:80px 16px 30px;min-height:auto;}
            .login-card{width:100%;max-width:340px;margin-top:20px;}
        }
    </style>
</head>
<body>
    <div class="stage">
        <!-- calm, minimal decoration: soft circles and gentle waves only, no lightning motif -->
        <svg class="deco" viewBox="0 0 960 520" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg">
            <circle cx="850" cy="70" r="150" fill="#ffffff" opacity="0.35"/>
            <circle cx="90" cy="460" r="120" fill="#ffffff" opacity="0.3"/>
            <circle cx="130" cy="90" r="60" fill="#ffffff" opacity="0.25"/>
            <circle cx="820" cy="440" r="70" fill="#ffffff" opacity="0.2"/>

            <path d="M0,180 C160,140 260,210 420,180 C600,148 700,210 960,170" stroke="#ffffff" stroke-width="2" fill="none" opacity="0.4"/>
            <path d="M0,340 C180,380 300,320 480,350 C660,380 780,320 960,350" stroke="#ffffff" stroke-width="2" fill="none" opacity="0.35"/>

            <!-- soft dot grid accents, echoes reference layout without the lightning mark -->
            <g opacity="0.45" fill="#ffffff">
                <circle cx="120" cy="420" r="3"/><circle cx="142" cy="433" r="3"/><circle cx="164" cy="420" r="3"/>
                <circle cx="120" cy="446" r="3"/><circle cx="142" cy="459" r="3"/><circle cx="164" cy="446" r="3"/>
            </g>
            <g opacity="0.45" fill="#ffffff">
                <circle cx="790" cy="120" r="3"/><circle cx="812" cy="133" r="3"/><circle cx="834" cy="120" r="3"/>
                <circle cx="790" cy="146" r="3"/><circle cx="812" cy="159" r="3"/><circle cx="834" cy="146" r="3"/>
            </g>
        </svg>

        <div class="brand-top">
            <div class="logo-mark"><img src="{{ asset('images/logo.svg') }}" alt="Logo" style="width:22px;height:22px;object-fit:contain;"></div>
            <span>EMS Portal</span>
        </div>

        <div class="login-card">
            <div class="logo-row">
                <div class="logo-mark"><img src="{{ asset('images/logo.svg') }}" alt="Logo" style="width:22px;height:22px;object-fit:contain;"></div>
                <span>Your logo</span>
            </div>
            <h1>Login</h1>

            @if (session('success'))
                <div class="alert alert-success alert-custom">{{ session('success') }}</div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger alert-custom">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            @php $roleSelected = old('role', session('role_selected', 'karyawan')); @endphp
            <form method="POST" action="{{ route('login') }}" id="login-form">
                @csrf

                <div class="role-toggle">
                    <input type="radio" name="role" id="role-karyawan" value="karyawan"
                        {{ $roleSelected !== 'admin' ? 'checked' : '' }}>
                    <label for="role-karyawan">Karyawan</label>

                    <input type="radio" name="role" id="role-admin" value="admin"
                        {{ $roleSelected === 'admin' ? 'checked' : '' }}>
                    <label for="role-admin">Admin</label>
                </div>

                {{-- Form Admin: Username + Password --}}
                <div id="fields-admin">
                    <div class="input-group-custom">
                        <i class="bi bi-person-fill"></i>
                        <input type="text" name="username" value="{{ old('username') }}" class="form-control-custom" placeholder="Username">
                    </div>
                    <div class="input-group-custom">
                        <i class="bi bi-lock-fill"></i>
                        <input type="password" name="password" class="form-control-custom" placeholder="Password">
                    </div>
                </div>

                {{-- Form Karyawan: Email + NIP --}}
                <div id="fields-karyawan">
                    <div class="input-group-custom">
                        <i class="bi bi-envelope-fill"></i>
                        <input type="email" name="email" value="{{ old('email') }}" class="form-control-custom" placeholder="Email karyawan">
                    </div>
                    <div class="input-group-custom">
                        <i class="bi bi-card-text"></i>
                        <input type="text" name="nip" value="{{ old('nip') }}" class="form-control-custom" placeholder="NIP">
                    </div>
                </div>

                <div class="row-opts">
                    <label><input type="checkbox" name="remember"> Ingat saya</label>
                </div>

                <button type="submit" class="btn-signin">Sign In</button>
            </form>

            <div class="foot-note" id="foot-note"></div>
        </div>
    </div>

    <script>
        (function () {
            var radios = document.querySelectorAll('input[name="role"]');
            var adminFields = document.getElementById('fields-admin');
            var karyawanFields = document.getElementById('fields-karyawan');
            var adminInputs = adminFields.querySelectorAll('input');
            var karyawanInputs = karyawanFields.querySelectorAll('input');
            var footNote = document.getElementById('foot-note');
            var firstAdminInput = adminFields.querySelector('input');
            var firstKaryawanInput = karyawanFields.querySelector('input');

            function applyRole(role) {
                var isAdmin = role === 'admin';

                adminFields.style.display = isAdmin ? 'block' : 'none';
                karyawanFields.style.display = isAdmin ? 'none' : 'block';

                adminInputs.forEach(function (el) { el.required = isAdmin; });
                karyawanInputs.forEach(function (el) { el.required = !isAdmin; });

                footNote.innerHTML = isAdmin
                    ? 'Login <b>Admin</b> Hanya untuk pengguna dengan hak akses administrator</b>.'
                    : 'Login <b>Karyawan</b> pakai <b>Email</b> &amp; <b>NIP</b> sesuai data yang diinput Admin.';

                if (isAdmin) { firstAdminInput.focus(); } else { firstKaryawanInput.focus(); }
            }

            radios.forEach(function (radio) {
                radio.addEventListener('change', function () { applyRole(this.value); });
            });

            var checked = document.querySelector('input[name="role"]:checked');
            applyRole(checked ? checked.value : 'karyawan');
        })();
    </script>
</body>
</html>
