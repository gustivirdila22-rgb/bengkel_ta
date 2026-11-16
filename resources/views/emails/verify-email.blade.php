<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Email - Bengkelin</title>
</head>
<body style="margin:0; padding:0; background-color:#f4f6f8; font-family: 'Inter', 'Segoe UI', Arial, sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f6f8; padding: 40px 16px;">
        <tr>
            <td align="center">
                <table width="100%" cellpadding="0" cellspacing="0" style="max-width: 520px; background-color:#ffffff; border-radius: 16px; overflow: hidden; border: 1px solid #e2e8f0;">
                    <!-- Header Gelap dengan Logo & Tulisan persis seperti gambar -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #102a24 0%, #0d1b1e 100%); padding: 28px 32px; text-align: center;">
                            <table cellpadding="0" cellspacing="0" style="margin: 0 auto;">
                                <tr>
                                    <!-- Kotak Hijau Ikon Kunci Pas -->
                                    <td style="background-color: #00b875; width: 42px; height: 42px; border-radius: 12px; text-align: center; vertical-align: middle;">
                                        <img
                                            src="https://img.icons8.com/ios/50/ffffff/wrench--v1.png"
                                            alt="Icon"
                                            width="22"
                                            height="22"
                                            style="display: block; margin: 0 auto;"
                                        >
                                    </td>
                                    <!-- Jarak -->
                                    <td style="width: 12px;"></td>
                                    <!-- Tulisan Bengkelin -->
                                    <td style="vertical-align: middle;">
                                        <span style="font-size: 24px; font-weight: 800; letter-spacing: -0.5px; color: #ffffff;">
                                            Bengkel<span style="color: #00b875;">in</span>
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Isi Pesan -->
                    <tr>
                        <td style="padding: 32px;">
                            <h2 style="margin: 0 0 12px; color: #0f172a; font-size: 20px; font-weight: 700;">
                                Halo, {{ $user->name }}!
                            </h2>
                            <p style="margin: 0 0 20px; color: #475569; font-size: 14px; line-height: 1.6;">
                                Terima kasih telah mendaftarkan bengkel Anda di <strong>Bengkelin</strong>. Klik tombol di bawah ini untuk mengaktifkan akun dan mulai mengelola operasional bengkel Anda:
                            </p>

                            <!-- Tombol Verifikasi -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="margin: 28px 0;">
                                <tr>
                                    <td align="center">
                                        <a href="{{ $url }}" target="_blank" style="display: inline-block; background-color: #00b875; color: #ffffff; font-size: 14px; font-weight: 700; text-decoration: none; padding: 14px 32px; border-radius: 10px;">
                                            Verifikasi Alamat Email
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin: 0 0 16px; color: #64748b; font-size: 13px; line-height: 1.5;">
                                Tautan verifikasi ini hanya berlaku selama 60 menit. Jika Anda tidak merasa mendaftar di Bengkelin, abaikan saja email ini.
                            </p>

                            <hr style="border: none; border-top: 1px solid #f1f5f9; margin: 24px 0;">

                            <p style="margin: 0; color: #94a3b8; font-size: 11px; line-height: 1.5; word-break: break-all;">
                                Jika tombol di atas tidak berfungsi, salin dan tempel tautan berikut ke browser Anda:<br>
                                <a href="{{ $url }}" style="color: #00b875;">{{ $url }}</a>
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f8fafc; padding: 18px 32px; text-align: center; border-top: 1px solid #f1f5f9;">
                            <p style="margin: 0; color: #94a3b8; font-size: 12px;">
                                © {{ date('Y') }} Bengkelin. Semua hak dilindungi.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>