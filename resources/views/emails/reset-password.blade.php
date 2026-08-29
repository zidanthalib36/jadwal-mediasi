<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Reset Password</title>
</head>

<body style="
    margin: 0;
    padding: 0;
    background-color: #f5f3ee;
    font-family: Arial, Helvetica, sans-serif;
">

<table width="100%"
       cellpadding="0"
       cellspacing="0"
       border="0"
       style="background-color: #f5f3ee; padding: 40px 15px;">

    <tr>
        <td align="center">

            <!-- MAIN CONTAINER -->

            <table width="600"
                   cellpadding="0"
                   cellspacing="0"
                   border="0"
                   style="
                       width: 100%;
                       max-width: 600px;
                       background-color: #ffffff;
                       border-radius: 12px;
                       overflow: hidden;
                       box-shadow: 0 8px 30px rgba(0,0,0,0.08);
                   ">

                <!-- HEADER -->

                <tr>

                    <td align="center"
                        style="
                            background: linear-gradient(
                                180deg,
                                #c8a75e,
                                #a8873f
                            );
                            padding: 35px 30px;
                        ">

                        <img
                            src="{{ asset('images/KlarifMediasiLogo-removebg.png') }}"
                            alt="Logo Klarifikasi Mediasi"
                            width="180"
                            style="
                                display: block;
                                max-width: 180px;
                                height: auto;
                                margin-bottom: 20px;
                            "
                        >

                        <div style="
                            color: #ffffff;
                            font-size: 18px;
                            font-weight: bold;
                            letter-spacing: 0.5px;
                        ">
                            SISTEM PENJADWALAN
                        </div>

                        <div style="
                            color: #ffffff;
                            font-size: 18px;
                            font-weight: bold;
                            letter-spacing: 0.5px;
                        ">
                            KLARIFIKASI & MEDIASI
                        </div>

                        <div style="
                            color: #fff8e8;
                            font-size: 15px;
                            margin-top: 6px;
                        ">
                            P3MI
                        </div>

                    </td>

                </tr>


                <!-- CONTENT -->

                <tr>

                    <td style="
                        padding: 40px 45px;
                        color: #444444;
                    ">

                        <h2 style="
                            margin: 0 0 10px 0;
                            color: #333333;
                            font-size: 24px;
                        ">
                            Reset Password
                        </h2>


                        <p style="
                            margin: 0 0 25px 0;
                            color: #777777;
                            font-size: 14px;
                            line-height: 1.7;
                        ">

                            Halo,

                        </p>


                        <p style="
                            margin: 0 0 20px 0;
                            color: #555555;
                            font-size: 15px;
                            line-height: 1.7;
                        ">

                            Kami menerima permintaan untuk mengatur ulang
                            password akun Anda pada
                            <strong>
                                Sistem Penjadwalan Klarifikasi & Mediasi P3MI
                            </strong>.

                        </p>


                        <p style="
                            margin: 0 0 30px 0;
                            color: #555555;
                            font-size: 15px;
                            line-height: 1.7;
                        ">

                            Silakan klik tombol di bawah ini untuk membuat
                            password baru Anda.

                        </p>


                        <!-- BUTTON -->

                        <table width="100%"
                               cellpadding="0"
                               cellspacing="0"
                               border="0">

                            <tr>

                                <td align="center">

                                    <a href="{{ $url }}"
                                       style="
                                           display: inline-block;
                                           background-color: #b8944f;
                                           color: #ffffff;
                                           text-decoration: none;
                                           padding: 14px 30px;
                                           border-radius: 7px;
                                           font-size: 14px;
                                           font-weight: bold;
                                       ">

                                        RESET PASSWORD

                                    </a>

                                </td>

                            </tr>

                        </table>


                        <!-- EXPIRATION -->

                        <div style="
                            margin-top: 30px;
                            padding: 15px;
                            background-color: #faf8f2;
                            border-left: 4px solid #b8944f;
                            border-radius: 5px;
                        ">

                            <p style="
                                margin: 0;
                                color: #666666;
                                font-size: 13px;
                                line-height: 1.6;
                            ">

                                <strong>Perhatian:</strong><br>

                                Link reset password ini akan
                                kedaluwarsa dalam
                                <strong>60 menit</strong>.

                            </p>

                        </div>


                        <p style="
                            margin-top: 25px;
                            margin-bottom: 0;
                            color: #777777;
                            font-size: 13px;
                            line-height: 1.6;
                        ">

                            Jika Anda tidak meminta reset password,
                            Anda dapat mengabaikan email ini.
                            Tidak ada tindakan lebih lanjut yang diperlukan.

                        </p>


                        <!-- FALLBACK URL -->

                        <hr style="
                            margin: 30px 0;
                            border: 0;
                            border-top: 1px solid #eeeeee;
                        ">


                        <p style="
                            margin: 0 0 8px 0;
                            color: #888888;
                            font-size: 12px;
                        ">

                            Jika tombol di atas tidak dapat digunakan,
                            salin dan buka link berikut pada browser:

                        </p>

                        <p style="
                            margin: 0;
                            word-break: break-all;
                            font-size: 12px;
                        ">

                            <a href="{{ $url }}"
                               style="
                                   color: #a07f3e;
                                   text-decoration: underline;
                               ">

                                {{ $url }}

                            </a>

                        </p>

                    </td>

                </tr>


                <!-- FOOTER -->

                <tr>

                    <td align="center"
                        style="
                            background-color: #f8f7f4;
                            padding: 25px 30px;
                            border-top: 1px solid #eeeeee;
                        ">

                        <p style="
                            margin: 0 0 5px 0;
                            color: #777777;
                            font-size: 12px;
                        ">

                            Sistem Penjadwalan Klarifikasi & Mediasi P3MI

                        </p>

                        <p style="
                            margin: 0;
                            color: #aaaaaa;
                            font-size: 11px;
                        ">

                            Email ini dikirim secara otomatis.
                            Mohon tidak membalas email ini.

                        </p>

                    </td>

                </tr>

            </table>

        </td>
    </tr>

</table>

</body>

</html>
