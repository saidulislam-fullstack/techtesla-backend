<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Challan</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Arial:wght@400;700&display=swap');

        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
            box-sizing: border-box;
        }

        .challan-container {
            background: white;
            width: 8.5in;
            min-height: 11in;
            padding: 0.5in;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            box-sizing: border-box;
        }

        .image-head img {
            margin: 20px 0;
            width: 100%;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 24px;
            font-weight: bold;
            text-decoration: underline;
            margin: 0;
            padding: 0;
        }

        .sub-header {
            margin-bottom: 20px;
            font-size: 14px;
        }

        .delivery-date {
            text-align: right;
            margin-bottom: 10px;
            font-size: 14px;
        }

        .details-section {
            display: flex;
            justify-content: space-between;
            border-top: 2px solid black;
            border-bottom: 2px solid black;
            padding: 10px 0;
        }

        .delivery-to {
            width: 50%;
        }

        .delivery-to p {
            margin: 0;
            font-size: 14px;
        }

        .delivery-info {
            width: 50%;
        }

        .info-table {
            width: 100%;
            font-size: 14px;
        }

        .info-table td {
            padding: 2px 5px;
        }

        .info-table td:first-child {
            font-weight: bold;
            width: 130px;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 14px;
        }

        .items-table th,
        .items-table td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }

        .items-table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .items-table .item-description {
            text-align: left;
        }

        .signature-section {
            display: flex;
            justify-content: space-between;
            margin-top: 200px;
        }

        .signature {
            width: 45%;
            text-align: center;
            font-size: 14px;
        }

        .signature-line {
            border-top: 2px dashed #000;
            margin-bottom: 5px;
        }
    </style>
</head>

<body>
    <div class="challan-container">
        <div class="image-head">
            <img src="{{asset('logo/invoice-head.png')}}" alt="">
        </div>
        <div class="header">
            <h1>DELIVERY CHALLAN</h1>
        </div>
        <p class="sub-header">We are pleased to deliver the following described product as per the reference purchase
            order:</p>
        <div class="delivery-date">
            <strong>Delivery Date:</strong> 05.01.2023
        </div>
        <div class="details-section">
            <div class="delivery-to">
                <p><strong>Delivery To:</strong></p>
                <p><strong>National Cement Mills Limited.</strong></p>
                <p>Issanagar, Karnafully, Chattogram.</p>
            </div>
            <div class="delivery-info">
                <table class="info-table">
                    <tr>
                        <td colspan="2"><strong>Delivery Information:</strong></td>
                    </tr>
                    <tr>
                        <td>Delivery Challan No</td>
                        <td>: DC2023041258</td>
                    </tr>
                    <tr>
                        <td>Reference PO No</td>
                        <td>: NCMLREQ-0922-000039</td>
                    </tr>
                    <tr>
                        <td>PO Date</td>
                        <td>: 25/10/2022</td>
                    </tr>
                </table>
            </div>
        </div>
        <table class="items-table">
            <thead>
                <tr>
                    <th style="width: 5%;">SL.</th>
                    <th style="width: 75%;">ITEM DESCRIPTION</th>
                    <th style="width: 10%;">UNIT</th>
                    <th style="width: 10%;">QUANTITY</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>01</td>
                    <td class="item-description">Counter Meter<br>(120x315mm,1 count input and 1 reset input must be
                        present)</td>
                    <td>PCS.</td>
                    <td>05</td>
                </tr>
            </tbody>
        </table>

        <div class="signature-section">
            <div class="signature">
                <div class="signature-line"></div>
                Authorized Signature
            </div>
            <div class="signature">
                <div class="signature-line"></div>
                Receiver Signature with Designation, Seal & date.
            </div>
        </div>
    </div>
</body>

</html>