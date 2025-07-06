<!DOCTYPE html>
<html lang="bn">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>কর চালানপত্র</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Tiro+Bangla&family=Roboto:wght@400;700&display=swap');

        body {
            font-family: 'Tiro Bangla', 'Roboto', sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #000;
            background-color: #fff;
            margin: 20px;
        }

        .container {
            max-width: 800px;
            margin: auto;
            border: 1px solid #000;
            padding: 15px;
            background: #2ABCE9;
        }

        .header,
        .footer {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .header .title-section {
            text-align: center;
        }

        .header .title-section h2 {
            margin: 0;
            font-size: 16px;
            font-weight: bold;
        }

        .header .title-section h3 {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
            border: 1px solid #000;
            padding: 2px 5px;
            margin-top: 5px;
        }

        .header .title-section p {
            margin: 5px 0 0 0;
            font-size: 11px;
        }

        .header .copy-info {
            text-align: right;
        }

        .logo {
            width: 60px;
            height: 60px;
            /* Using a placeholder dummy logo */
            background-image: url('data:image/svg+xml;charset=UTF-8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><path fill="%23006a4e" d="M50,3.8c-25.5,0-46.2,20.7-46.2,46.2s20.7,46.2,46.2,46.2s46.2-20.7,46.2-46.2S75.5,3.8,50,3.8z M50,90.2 C27.8,90.2,9.8,72.2,9.8,50S27.8,9.8,50,9.8s40.2,18,40.2,40.2S72.2,90.2,50,90.2z"/><path fill="%23f42a41" d="M50,12.5c-20.7,0-37.5,16.8-37.5,37.5s16.8,37.5,37.5,37.5s37.5-16.8,37.5-37.5S70.7,12.5,50,12.5z"/></svg>');
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
        }

        .info-section {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
            border-top: 1px solid #000;
            padding-top: 10px;
        }

        .info-box {
            width: 48%;
        }

        .info-box p,
        .transport-info p {
            margin: 0 0 5px 0;
        }

        .transport-info {
            margin-top: 10px;
            padding-top: 5px;
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;
        }

        .main-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
        }

        .main-table th,
        .main-table td {
            border: 1px solid #000;
            padding: 4px;
            text-align: center;
        }

        .main-table th {
            font-weight: bold;
            font-size: 10px;
        }

        .main-table td {
            font-size: 11px;
        }

        .text-left {
            text-align: left !important;
        }

        .text-right {
            text-align: right !important;
        }

        .totals-section {
            margin-top: 0px;
        }

        .totals-section p {
            margin: 5px 0;
            font-weight: bold;
        }

        .footer {
            margin-top: 200px;
            padding-top: 10px;
            /* border-top: 1px solid #000; */
        }

        .signature-section {
            width: 70%;
        }

        .signature-section p {
            margin: 2px 0;
        }

        .stamp-section {
            width: 30%;
            display: flex;
            justify-content: flex-end;
            align-items: flex-end;
        }

        .stamp {
            border: 2px solid #000;
            border-radius: 50%;
            width: 100px;
            height: 100px;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            font-weight: bold;
            font-size: 14px;
            transform: rotate(-15deg);
        }

        .final-note {
            margin-top: 10px;
            font-size: 10px;
            font-style: italic;
        }

        .print-info {
            font-size: 9px;
            margin-top: 20px;
        }

        .bengali {
            font-family: 'Tiro Bangla', serif;
        }

        .english {
            font-family: 'Roboto', sans-serif;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="header">
            <div class="logo"></div>
            <div class="title-section">
                <h2 class="bengali">গণপ্রজাতন্ত্রী বাংলাদেশ সরকার</h2>
                <h2 class="bengali">জাতীয় রাজস্ব বোর্ড</h2>
                <h3 class="bengali">কর চালানপত্র</h3>
                <p class="bengali">[বিধি ৪০ এর উপ-বিধি (১) এর দফা (গ) ও দফা (চ) দ্রষ্টব্য]</p>
            </div>
            <div class="copy-info">
                <p class="bengali">প্রথম অপি/দ্বিতীয় কপি</p>
                <p class="bengali">মুশক-৬.৩</p>
            </div>
        </div>

        <div class="info-section">
            <div class="info-box">
                <p><span class="bengali">নিবন্ধিত ব্যক্তির নাম:</span> <span class="english">ABB LIMITED</span></p>
                <p><span class="bengali">নিবন্ধিত ব্যক্তির বিআইএন:</span> <span class="english">001090653-0103</span>
                </p>
                <p><span class="bengali">প্রাঙ্গণের ঠিকানার ঠিকানা:</span> <span
                        class="english">Kolomesor,Gasa,Joydevpur, 1015,Gazipur Sadar-Gazipur.</span></p>
            </div>
        </div>

        <div class="info-section" style="border-top: none; padding-top: 0;">
            <div class="info-box" style="width: 55%;">
                <p><span class="bengali">ক্রেতার নাম:</span> <span class="english">YOUTH POWER SOLUTION</span></p>
                <p><span class="bengali">ক্রেতার বিআইএন (প্রযোজ্যক্ষেত্রে):</span> <span
                        class="english">003497218-0101</span></p>
                <p><span class="bengali">ক্রেতার ঠিকানা:</span> <span class="english">Ka - 27/2-C, Rasulbagh, Mohakhali,
                        Dhaka, Bangladesh</span></p>
                <p><span class="bengali">সরবরাহের গন্তব্যস্থল:</span> <span class="english">Khilkhet, Dhaka,
                        Bangladesh.</span></p>
            </div>
            <div class="info-box" style="width: 45%;">
                <p><span class="bengali">চালানপত্র নম্বর:</span> <span class="english">ABB-CHL-24-25-0000247</span></p>
                <p><span class="bengali">ইস্যুর তারিখ:</span> <span class="english">20/03/2025</span></p>
                <p><span class="bengali">ইস্যুর সময়:</span> <span class="english">11:34:38 AM</span></p>
            </div>
        </div>

        <div class="transport-info">
            <p><span class="bengali">যানবাহনের প্রকৃতি ও নম্বর:</span> <span class="english">Hand carry</span></p>
        </div>

        <table class="main-table">
            <thead>
                <tr>
                    <th class="bengali">ক্রমিক নং</th>
                    <th class="bengali" style="width: 25%;">পণ্য/সেবার বর্ণনা<br>(প্রযোজ্যক্ষেত্রে ব্র্যান্ড নামসহ)</th>
                    <th class="bengali">সরবরাহের পরিমাণ<br>একক</th>
                    <th class="bengali">একক মূল্য<br>( টাকায়)</th>
                    <th class="bengali">মোট মূল্য<br>(টাকায়)</th>
                    <th class="bengali">সম্পূরক<br>শুল্কের<br>হার</th>
                    <th class="bengali">সম্পূরক<br>শুল্কের পরিমাণ<br>(টাকায়)</th>
                    <th class="bengali">মূল্য সংযোজন<br>করের হার/<br>সুনির্দিষ্ট কর</th>
                    <th class="bengali">মূসক/<br>টার্নওভার<br>করের পরিমাণ<br>(টাকায়)</th>
                    <th class="bengali">সকল প্রকার শুল্ক<br>ও করসহ বিক্রয়<br>মূল্য</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td class="text-left english">MCB S201M-C3</td>
                    <td class="english">PC</td>
                    <td class="text-right english">7,513.04</td>
                    <td class="text-right english">7,513.04</td>
                    <td class="text-right english">0.00</td>
                    <td class="text-right english"></td>
                    <td class="text-right english">15%</td>
                    <td class="text-right english">1,126.96</td>
                    <td class="text-right english">8,640.00</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td class="text-left english">XT1C 160 TMG 160-1600 3p F F</td>
                    <td class="english">PC</td>
                    <td class="text-right english">69,391.28</td>
                    <td class="text-right english">69,391.28</td>
                    <td class="text-right english">0.00</td>
                    <td class="text-right english"></td>
                    <td class="text-right english">15%</td>
                    <td class="text-right english">10,408.69</td>
                    <td class="text-right english">79,799.97</td>
                </tr>
                <tr>
                    <td colspan="2" class="bengali text-left">সর্বমোট</td>
                    <td class="text-right english">2.00</td>
                    <td></td>
                    <td class="text-right english">77,304.32</td>
                    <td></td>
                    <td class="text-right english">0.00</td>
                    <td></td>
                    <td class="text-right english">11,535.65</td>
                    <td class="text-right english">88,839.97</td>
                </tr>
            </tbody>
        </table>

        <div class="totals-section">
            <p class="english">TOTAL QTY: EIGHT UNITS ONLY</p>
            <p class="english">TAKA EIGHTY-EIGHT THOUSAND EIGHT HUNDRED THIRTY-NINE AND PAISE NINETY-SEVEN ONLY.</p>
        </div>

        <div class="footer">
            <div class="signature-section">
                <p><span class="bengali">প্রতিষ্ঠানের দায়িত্বপ্রাপ্ত ব্যক্তির</span></p>
                <p><span class="bengali">নাম:</span> <span class="english">Md. Rashed Hossain</span></p>
                <p><span class="bengali">পদবী:</span> <span class="english">Senior Executive - VAT</span></p>
                <p style="margin-top: 25px;"><span class="bengali">স্বাক্ষর:</span> _________________________</p>
                <p class="final-note bengali">*"এই চালানটি কর চালানপত্র হিসাবে গণ্য হবে"</p>
            </div>
            <div class="stamp-section">
                <div class="stamp">
                    <span>ABB LIMITED<br>Dhaka<br>Bangladesh</span>
                </div>
            </div>
        </div>
        <p class="print-info english">Printed on: MAR-20-25 11:45 AM</p>
    </div>

</body>

</html>