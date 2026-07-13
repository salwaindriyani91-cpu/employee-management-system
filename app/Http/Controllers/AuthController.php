<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * Password tetap yang wajib dipakai untuk role Admin.
     */
    const ADMIN_PASSWORD = 'admin123';

    /**
     * Tampilkan form login.
     */
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    /**
     * Proses login.
     *
     * Aturan (role menentukan cara login, TIDAK bisa dicampur):
     * - Role "admin"    : login pakai Username bebas + Password WAJIB "admin123".
     * - Role "karyawan" : login pakai Email + NIP, dan keduanya HARUS cocok
     *                     dengan satu data karyawan yang sudah terdaftar di
     *                     menu Karyawan (dibuat oleh Admin). Kalau tidak
     *                     cocok, login ditolak — tidak ada akun otomatis
     *                     dibuat asal-asalan.
     */
    public function login(Request $request)
    {
        $role = $request->input('role');
        $remember = $request->boolean('remember');

        if (! in_array($role, ['admin', 'karyawan'], true)) {
            return back()
                ->withErrors(['role' => 'Silakan pilih jenis akun terlebih dahulu.'])
                ->withInput();
        }

        return $role === 'admin'
            ? $this->loginAsAdmin($request, $remember)
            : $this->loginAsKaryawan($request, $remember);
    }

    /**
     * Login khusus Admin: Username bebas, Password wajib "admin123".
     */
    private function loginAsAdmin(Request $request, bool $remember)
    {
        $data = $request->validate([
            'username' => ['required', 'string', 'max:100'],
            'password' => ['required', 'string'],
        ], [
            'username.required' => 'Username wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        if ($data['password'] !== self::ADMIN_PASSWORD) {
            return back()
                ->withErrors(['password' => 'Password admin salah. Gunakan password "admin123".'])
                ->onlyInput('username')
                ->with('role_selected', 'admin');
        }

        $username = trim($data['username']);

        $user = User::updateOrCreate(
            ['email' => $this->accountKey($username, 'admin')],
            [
                'name' => $username,
                'role' => 'admin',
                'password' => Hash::make(self::ADMIN_PASSWORD),
            ]
        );

        return $this->finishLogin($request, $user, $remember);
    }

    /**
     * Login khusus Karyawan: Email + NIP wajib cocok dengan data
     * karyawan yang sudah ada (diinput Admin lewat menu Karyawan).
     * Tidak ada pembuatan akun otomatis dari input sembarangan.
     */
    private function loginAsKaryawan(Request $request, bool $remember)
    {
        $data = $request->validate([
            'email' => ['required', 'string', 'email', 'max:100'],
            'nip' => ['required', 'string', 'max:20'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'nip.required' => 'NIP wajib diisi.',
        ]);

        $email = strtolower(trim($data['email']));
        $nip = trim($data['nip']);

        $karyawan = Karyawan::whereRaw('LOWER(email) = ?', [$email])
            ->where('nip', $nip)
            ->first();

        if (! $karyawan) {
            return back()
                ->withErrors(['email' => 'Email atau NIP tidak sesuai dengan data karyawan yang terdaftar. Hubungi Admin jika data Anda belum diinput.'])
                ->onlyInput('email')
                ->with('role_selected', 'karyawan');
        }

        if ($karyawan->status !== 'Aktif') {
            return back()
                ->withErrors(['email' => "Akun karyawan ini berstatus \"{$karyawan->status}\" dan tidak dapat login."])
                ->onlyInput('email')
                ->with('role_selected', 'karyawan');
        }

        // Satu data karyawan = satu akun login. Kalau belum ada, buatkan;
        // kalau sudah ada, pakai yang itu (bukan bikin akun baru tiap login).
        $user = User::firstOrNew(['karyawan_id' => $karyawan->id]);
        $user->fill([
            'name' => $karyawan->nama,
            'email' => $this->accountKey($karyawan->nip, 'karyawan'),
            'role' => 'karyawan',
            'karyawan_id' => $karyawan->id,
        ]);
        if (! $user->exists) {
            // Password internal saja (tidak dipakai untuk login karyawan,
            // karena login karyawan selalu lewat Email + NIP di atas).
            $user->password = Hash::make(Str::random(40));
        }
        $user->save();

        return $this->finishLogin($request, $user, $remember);
    }

    private function finishLogin(Request $request, User $user, bool $remember)
    {
        Auth::login($user, $remember);
        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'))
            ->with('success', 'Selamat datang, ' . $user->name . '!');
    }

    /**
     * Logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah keluar.');
    }

    /**
     * Bikin identitas unik (disimpan di kolom email) berdasarkan
     * username/NIP + role, supaya akun admin & karyawan tidak bentrok
     * walau nilainya sama.
     */
    private function accountKey(string $key, string $role): string
    {
        return strtolower(str_replace(' ', '_', $key)) . '@' . $role . '.local';
    }
}
