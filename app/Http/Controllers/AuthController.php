<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Kata sandi wajib diisi.'
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended('/admin');
        }

        return back()->withErrors([
            'email' => 'Email atau kata sandi yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'Kami tidak dapat menemukan pengguna dengan alamat email tersebut.',
            ])->onlyInput('email');
        }

        // Generate Token
        $token = Str::random(60);

        // Simpan ke database
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'token' => Hash::make($token),
                'created_at' => now()
            ]
        );

        $resetUrl = route('password.reset', ['token' => $token, 'email' => $request->email]);

        try {
            \Illuminate\Support\Facades\Mail::send([], [], function ($message) use ($request, $resetUrl) {
                $message->to($request->email)
                    ->subject('Reset Kata Sandi Akun - TPA Baitur Ridwan')
                    ->html('
                        <div style="font-family: \'Plus Jakarta Sans\', \'Segoe UI\', sans-serif; max-width: 600px; margin: 0 auto; padding: 40px 20px; color: #1C1C18; background-color: #FCF9F2;">
                            <div style="text-align: center; margin-bottom: 32px;">
                                <h1 style="font-family: \'Epilogue\', sans-serif; font-size: 24px; color: #003227; margin: 0;">TPA Baitur Ridwan</h1>
                                <p style="font-size: 12px; color: #78716C; margin: 4px 0 0;">Taman Pendidikan Al-Qur\'an</p>
                            </div>
                            <div style="background: #FFFFFF; padding: 40px; border-radius: 24px; box-shadow: 0 4px 20px rgba(0,0,0,0.02); border: 1px solid rgba(191,201,196,0.3);">
                                <h2 style="font-family: \'Epilogue\', sans-serif; font-size: 20px; color: #003227; margin-top: 0; margin-bottom: 16px;">Halo,</h2>
                                <p style="font-size: 15px; line-height: 1.6; color: #404945; margin-bottom: 24px;">
                                    Anda menerima email ini karena kami menerima permintaan untuk mengatur ulang kata sandi akun Anda di sistem TPA Baitur Ridwan.
                                </p>
                                <div style="text-align: center; margin: 32px 0;">
                                    <a href="' . $resetUrl . '" style="background-color: #004B3C; color: #FFFFFF; padding: 16px 32px; font-weight: 700; font-size: 15px; text-decoration: none; border-radius: 9999px; display: inline-block;">
                                        Atur Ulang Kata Sandi
                                    </a>
                                </div>
                                <p style="font-size: 14px; line-height: 1.6; color: #78716C; margin-top: 32px;">
                                    Tautan ini hanya akan berlaku selama 60 menit. Jika Anda tidak meminta pengaturan ulang kata sandi, Anda dapat mengabaikan email ini.
                                </p>
                                <hr style="border: 0; border-top: 1px solid #EBE8E1; margin: 32px 0;">
                                <p style="font-size: 12px; color: #9CA3AF; line-height: 1.5; margin: 0;">
                                    Jika Anda mengalami kesulitan menekan tombol "Atur Ulang Kata Sandi", silakan salin dan tempel URL berikut ke peramban web Anda:<br>
                                    <a href="' . $resetUrl . '" style="color: #004B3C; word-break: break-all;">' . $resetUrl . '</a>
                                </p>
                            </div>
                            <div style="text-align: center; margin-top: 32px; font-size: 12px; color: #78716C;">
                                &copy; ' . date('Y') . ' TPA Baitur Ridwan. Semua hak dilindungi.
                            </div>
                        </div>
                    ');
            });
            $successMessage = 'Tautan pemulihan kata sandi telah dikirim ke email Anda. Silakan periksa kotak masuk (atau spam) email Anda.';
            return redirect()->back()->with('success', $successMessage);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Gagal mengirim email reset password: ' . $e->getMessage());
            
            if (config('app.env') === 'local') {
                return redirect()->back()->with('success', 'Tautan pemulihan berhasil dibuat!')
                    ->with('local_reset_url', $resetUrl);
            }

            return back()->withErrors([
                'email' => 'Gagal mengirim email reset password: ' . $e->getMessage() . '. Pastikan konfigurasi email di sistem sudah benar.',
            ])->onlyInput('email');
        }
    }

    public function showResetForm(string $token, Request $request)
    {
        $email = $request->query('email');
        
        $resetRecord = DB::table('password_reset_tokens')->where('email', $email)->first();

        if (!$resetRecord) {
            return redirect()->route('login')->withErrors(['email' => 'Permintaan reset password tidak valid atau sudah kadaluwarsa.']);
        }

        // Validasi masa berlaku token (60 menit)
        if (now()->diffInMinutes($resetRecord->created_at) > 60) {
            DB::table('password_reset_tokens')->where('email', $email)->delete();
            return redirect()->route('login')->withErrors(['email' => 'Token reset password sudah kadaluwarsa. Silakan ajukan permintaan baru.']);
        }

        return view('auth.reset-password', compact('token', 'email'));
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Kata sandi baru wajib diisi.',
            'password.min' => 'Kata sandi minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        $resetRecord = DB::table('password_reset_tokens')->where('email', $request->email)->first();

        if (!$resetRecord || !Hash::check($request->token, $resetRecord->token)) {
            return back()->withErrors(['email' => 'Token reset kata sandi tidak valid atau sudah kadaluwarsa.']);
        }

        // Validasi masa berlaku token (60 menit)
        if (now()->diffInMinutes($resetRecord->created_at) > 60) {
            DB::table('password_reset_tokens')->where('email', $request->email)->delete();
            return back()->withErrors(['email' => 'Token reset kata sandi sudah kadaluwarsa. Silakan ajukan permintaan baru.']);
        }

        // Update User Password
        $user = User::where('email', $request->email)->first();
        if ($user) {
            $user->password = Hash::make($request->password);
            $user->save();
        }

        // Hapus token
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('success', 'Kata sandi Anda berhasil diperbarui! Silakan masuk dengan kata sandi baru.');
    }
}
