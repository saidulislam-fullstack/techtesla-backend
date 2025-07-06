<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Order</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            background-color: #f8f9fa;
            color: #000;
        }
        .page {
            background: white;
            width: 210mm;
            min-height: 297mm;
            display: block;
            margin: 20px auto;
            padding: 25px 40px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            box-sizing: border-box;
            position: relative;
        }
        .page-footer {
            position: relative;
            margin-top: 20px;
            text-align: center;
        }
        .page-footer .page-number {
            display: inline-block;
            background-color: #4A86E8;
            color: white;
            font-weight: bold;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            line-height: 24px;
            text-align: center;
        }
        .header {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            text-decoration: underline;
            margin: 20px 0;
        }
        .main-table, .terms-table {
            width: 100%;
            border-collapse: collapse;
        }
        .main-table th, .main-table td, .terms-table th, .terms-table td {
            border: 1px solid black;
            padding: 4px;
            vertical-align: top;
        }
        .main-table th {
            background-color: #e0e0e0;
        }
        .main-table td {
            text-align: center;
        }
        .main-table .description {
            text-align: left;
        }
        .main-table .amount, .main-table .rate {
            text-align: right;
        }
        .no-border-table td {
            border: none;
            padding: 1px 2px;
            vertical-align: top;
        }
        .border-table{
            border: 1px solid black;
            padding: 1px 2px;
            vertical-align: top;
        }
        .bold {
            font-weight: bold;
        }
        .underline {
            text-decoration: underline;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .w-50 {
            width: 50%;
        }
        .w-30 {
            width: 30%;
        }
        .w-70 {
            width: 70%;
        }
        .signature-section {
            margin-top: 40px;
        }
    </style>
</head>
<body>

    <div class="page">
        <h1 class="header">PURCHASE ORDER</h1>
        
        <table style="width:100%;" class="border-table">
            <tr>
                <td class="w-50" style="border-right: 1px solid black; padding-right: 10px;">
                    <span class="bold">Invoice To</span><br>
                    <span class="bold">Dellstar Overseas</span><br>
                    60/2, Garfa Main Road, Jadavpur, <br>
                    Kolkata - 700075, West Bengal, India<br>
                    GSTIN/UIN: 19AAIFD2879A1ZF / TAN No: CALD09401A<br>
                    IEC No: 0211025674<br>
                    E-Mail: accounts@dellstaroverseas.com
                    <hr>
                    <span class="bold">Dellstar Overseas</span><br>
                    60/2, Garfa Main Road, Jadavpur, <br>
                    Kolkata - 700075, West Bengal, India<br>
                    IEC No: 0211025674 / TAN No: CALD09401A<br>
                    e-mail: pritam@dellstaroverseas.com<br>
                    GSTIN/UIN : 19AAIFD2879A1ZF<br>
                    State Name : West Bengal, Code : 19
                    <hr>
                    <span class="bold">Baumer India Pvt. Ltd.</span><br>
                    Bellevue Building, Plot No.: 46 & 47, Survey No.:<br>
                    23/6A/2, Balewadi, Pune-411045, Maharashtra, India<br>
                    KA: Mr. Sandip Panda<br>
                    Mobile: 9831221827<br>
                    E-Mail: spanda@baumer.com<br>
                    GSTIN/UIN : 27AABCH7987F1Z6<br>
                    State Name : Maharashtra, Code : 27
                </td>
                <td class="w-50" style="vertical-align: top;">
                    <table style="width:100%; table-spacing: 0;">
                        <tr>
                            <td style="border: 1px solid black; padding: 5px;">
                                <span class="">Voucher No.</span><br>
                                <span class="bold">BIPL/TTL/LS/013/24-25</span>
                            </td>
                            <td style="border: 1px solid black; padding: 5px;">
                                <span class="">Dated</span><br>
                                <span class="bold">22-Apr-2024</span>
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid black; padding: 5px;"></td>
                            <td style="border: 1px solid black; padding: 5px;">
                                <span class="">Mode/Terms of Payment</span><br>
                                <span class="bold">100% Against PI Before Dispatch</span>
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid black; padding: 5px;">
                                <span class="">Dispatched through</span><br>
                                <span class="bold">DTDC / Shree Maruti Courier</span>
                            </td>
                            <td style="border: 1px solid black; padding: 5px;">
                                <span class="">Destination</span><br>
                                <span class="bold">Garfa-700075</span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="padding: 5px;">
                                <span class="">Despatch Information</span><br>
                                <span class="bold">Door Delivery Basis</span>
                                <span class="bold">Price Basis: DAP-Dellstar Office</span><br>
                                <span class="bold">P&F: Nil</span><br>=
                                <span class="bold">Freight: Included, Door-Delivery Basis</span><br>
                                <span class="bold">IGST: Extra @ 18%</span><br>
                                <span class="bold">Documentation: Factory Test / Calibration / Warranty Certificate</span>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        
        <br>
        
        <table class="main-table">
            <thead>
                <tr>
                    <th>SI No.</th>
                    <th>Description of Goods</th>
                    <th>HSN/SAC</th>
                    <th>Due on</th>
                    <th>Quantity</th>
                    <th>Rate</th>
                    <th>per</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td class="description">
                        <span class="bold">Level Sensor-11203057</span><br>
                        Baumer Make Level Sensor For Point Level Detection Housing: AISI 316L (1.4404), Electrical Connection: M12-A, 4-Pin, Process Connection: G 1/2 A Hygienic Output Type: PNP Ordering Key: LBFH-21. 010. A03020.1.0003.0 <br>Article No.: 11203057<br>Origin: Germany
                    </td>
                    <td>90328990</td>
                    <td>27-Apr-2024</td>
                    <td>1 Nos</td>
                    <td class="rate">14,553.00</td>
                    <td>Nos</td>
                    <td class="amount">14,553.00</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td class="description">
                        <span class="bold">Hygienic Adapter</span><br>
                        Baumer Make Hygienic Adapter ZPH3-3213<br>Article No: 11190720<br>Origin: Germany
                    </td>
                    <td>73072900</td>
                    <td>27-Apr-2024</td>
                    <td>1 Nos</td>
                    <td class="rate">7,659.00</td>
                    <td>Nos</td>
                    <td class="amount">7,659.00</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td class="description">
                        <span class="bold">Cable with Open-Ended Wire-CAM12.A4-11230460</span><br>
                        Baumer Make Cable With Open-Ended Wire.<br>Model: CAM12.A4-11230460<br>M12, Female, A-Coded; 4-Poles;<br>TPE-S, 500 Cm, Free Cable End
                    </td>
                    <td>85365000</td>
                    <td>27-Apr-2024</td>
                    <td>1 Nos</td>
                    <td class="rate">3,007.00</td>
                    <td>Nos</td>
                    <td class="amount">3,007.00</td>
                </tr>
                <tr>
                    <td>4</td>
                    <td class="description"><span class="bold">Material Certificate: Lot Certificate</span></td>
                    <td>9033</td>
                    <td>27-Apr-2024</td>
                    <td>1 Nos</td>
                    <td class="rate">3,850.00</td>
                    <td>Nos</td>
                    <td class="amount">3,850.00</td>
                </tr>
                <tr>
                    <td>5</td>
                    <td class="description"><span class="bold">Surface Finish Certificate: Lot Certificate</span></td>
                    <td>9033</td>
                    <td></td>
                    <td>1 Nos</td>
                    <td class="rate">3,850.00</td>
                    <td>Nos</td>
                    <td class="amount">3,850.00</td>
                </tr>
                <tr>
                    <td colspan="4" class="text-right bold">Total</td>
                    <td class="bold">5 Nos</td>
                    <td colspan="2"></td>
                    <td class="amount bold">₹ 32,919.00</td>
                </tr>
            </tbody>
        </table>
        
        <table style="width:100%; margin-top:10px;" class="no-border-table">
            <tr>
                <td class="w-70">
                    <span class="bold">Amount Chargeable (in words):</span><br>
                    INR Thirty Two Thousand Nine Hundred Nineteen Only
                </td>
                <td class="w-30 text-right">
                    E. & O.E
                </td>
            </tr>
        </table>
        
        <table style="width:100%; margin-top:20px;" class="no-border-table signature-section">
            <tr>
                <td><span class="bold">Company's PAN : AAIFD2879A</span></td>
                <td class="text-right"><span class="bold">for Dellstar Overseas</span></td>
            </tr>
            <tr>
                <td colspan="2" style="padding-top: 40px;" class="text-right bold">Authorised Signatory</td>
            </tr>
        </table>
        
        <p class="text-center" style="margin-top:20px;">This is a Computer Generated Document</p>
    </div>

    <div class="page">
        <h1 class="header">COMMERCIAL TERMS & CONDITIONS</h1>
        
        <p class="text-center bold" style="margin-bottom:15px;">YOU MUST DELIVER THE GOODS AS PER THE DELIVERY INSTRUCTIONS UNDER THE INVOICE / CHALLAN HAVING PO NO., MATERIAL CODE, RELEVANT REF.NO. ETC. NO GOODS WILL BE ACCEPTED WITHOUT PROPER INVOICE / CHALLAN HAVING THESE INFORMATIONS.</p>
        
        <table class="terms-table">
            <tr><td class="bold text-center" style="width:5%;">1.</td><td class="bold" style="width:25%;">SPECIAL CHECKS</td><td>FACTORY TEST / CALIBRATION CERTIFICATES / WARRANTY CERTIFICATES PAPERS OR ANY OTHER RELEVANT DOCUMENTS MUST BE CATERED ALONG WITH THE MATERIALS.</td></tr>
            <tr><td></td><td class="bold">DOCUMENTATION</td><td>DAP-DELLSTAR-OFFICE.</td></tr>
            <tr><td class="bold text-center">2.</td><td class="bold">PRICE</td><td>INCLUDED.</td></tr>
            <tr><td class="bold text-center">3.</td><td class="bold">PACKING & FORWARDING</td><td>ALL ITEMS SHOULD BE PACKED PROPERLY TO AVOID BREAKAGE OR THEFT OF THE ITEMS IN TRANSIT.</td></tr>
            <tr><td rowspan="3" class="bold text-center">4.</td><td class="bold">FREIGHT / INSURANCE</td><td>INCLUDED / PAID-DOOR DELIVERY BASIS.</td></tr>
            <tr><td class="bold">GST</td><td>IGST EXTRA @ 18.00%.</td></tr>
            <tr><td class="bold">TCS</td><td>TCS 0.1%, IF APPLICABLE.</td></tr>
            <tr><td rowspan="2" class="bold text-center">5.</td><td colspan="2">YOU ARE REQUIRED TO CHARGE GST CLEARLY ON THE INVOICE TO BE PREPARED AS PER THE GST LAW. PLEASE NOTE THAT DELLSTAR OVERSEAS SHALL GET THE INPUT CREDIT OF GST BASED ON RETURN TO BE FILED BY YOU. IN CASE DELLSTAR OVERSEAS SUFFERS ANY LOSS OF INPUT CREDIT DUE TO NON-FURNISHING OF INVOICES IN A TIMELY MANNER OR IN ACCORDANCE WITH THE PREVAILING LAW, THEN THE DELLSTAR OVERSEAS WOULD BE ENTITLED TO RECOVER THE SAID AMOUNT FROM YOU EITHER BY DEDUCTIONS FROM ANY BALANCE PAYMENT OR BY WAY OF RAISING A DEBIT NOTE.</td></tr>
            <tr><td class="bold">TERMS OF PAYMENT</td><td>100% AGAINST PROFORMA INVOICE BEFORE DISPATCH.</td></tr>
            <tr><td class="bold text-center">6.</td><td colspan="2">INVOICES, IN TRIPLICATE, ALONG WITH RECEIPTED CHALLANS HAVING FULL DETAILS WILL BE SUBMITTED AT OUR REGISTERED OFFICE FOR PAYMENT.</td></tr>
            <tr><td class="bold text-center">7.</td><td class="bold">DELIVERY</td><td>WITHIN 04-05 DAY/S FROM THE DATE OF PO. PART SHIPMENT IS NOT ALLOWED.</td></tr>
            <tr><td class="bold text-center">8.</td><td class="bold">DISCOUNT</td><td>NOT APPLICABLE.</td></tr>
            <tr><td class="bold text-center">9.</td><td class="bold">PENALTY</td><td>1/2 % PER WEEK, MAX 5%, LD WILL BE APPLICABLE AFTER 03 WEEKS FROM DATE OF PO.</td></tr>
            <tr><td class="bold text-center">10.</td><td class="bold">WARRANTY & GUARANTEE</td><td>PRODUCTS SUPPLIED BY YOU ARE WARRANTED AGAINST ANY MANUFACTURING DEFECTS FOR A PERIOD OF 18 MONTHS FROM THE DATE OF DESPATCH OR 12 MONTHS FROM THE DATE OF COMMISSIONING WHICH EVER IS EARLIER.</td></tr>
            <tr><td class="bold text-center">11.</td><td class="bold">DISPATCH INSTRUCTIONS</td><td>TO BE DELIVERED AT: DELLSTAR OVERSEAS, 60/2, GARFA MAIN ROAD, KOLKATA-700 075, WEST BENGAL, INDIA. NEAR GARFA LOKNATH MANDIR, CONTACT NO.: +91 90380 50072, +91 98300 85384, +91 98309 89827</td></tr>
            <tr><td class="bold text-center">12.</td><td class="bold">INSPECTION</td><td>DOOR DELIVERY, FREIGHT PAID BASIS BY ASSOCIATED ROAD CARRIERS/SAFEXPRESS/GATI/TCI-EXPRESS LTD./DTDC/SHREE MARUTI COURIER / ANY REPUTED TRANSPORTER / COURIER. <br>E-WAYBILL: IF APPLICABLE, E-WAYBILL WILL BE PROVIDED BY YOU AT THE TIME OF DISPATCH.<br>INSPECTION OF THE GOODS WILL BE FINALLY MADE BY US AT OUR OWN OFFICE AND OUR REPORT SHALL BE FINAL AND BINDING ON BOTH THE PARTIES (THE PURCHASER AND THE SELLER). THE MATERIALS DELIVER AT OUR CITY GODOWN/OFFICE WILL BE RECEIVED AS UNCHECKED.</td></tr>
            <tr><td class="bold text-center">13.</td><td class="bold">GOODS REJECTED</td><td>GOODS REJECTED FOR ANY REASONS WILL BE RETURNED TO YOU AT YOUR COST IN RESPECT OF PACKING, FREIGHT, INSURANCE ETC.<br>AND REJECTED ITEMS SHALL NOT TO BE REPLACED EXCEPT UPON RECEIPT OF OUR WRITTEN INSTRUCTIONS.<br>MATERIALS IF REJECTED SHOULD BE COLLECTED WITHIN 7 DAYS.</td></tr>
            <tr><td class="bold text-center">14.</td><td class="bold">LOSS / DAMAGE IN TRANSIT</td><td>IN THE EVENT OF LOSS OR DAMAGE, YOU SHALL BE SOLELY RESPONSIBLE TO LODGE THE CLAIMS AND SETTLE THE SAME. YOU SHALL PROCEED WITH REPAIR OR REPLACEMENT OF YOUR GOODS / WORKS THEREOF WITHOUT WAITING FOR SETTLEMENT OF THE CLAIM.<br>UNDER ANY CIRCUMSTANCES SHALL SUPPLIER BE LIABLE FOR LOSS / DAMAGE IN TRANSIT.</td></tr>
            <tr><td class="bold text-center">15.</td><td class="bold">VARIATION, SUSPENSION, CANCELLATION</td><td>VARIATION, SUSPENSION, CANCELLATION AND TERMINATION FOR DEFAULT<br>BUYER HAS THE RIGHT TO ISSUE A WRITTEN VARIATION, SUSPENSION, CANCELLATION OR TERMINATION ORDER.</td></tr>
            <tr><td class="bold text-center">16.</td><td class="bold">FORCE MAJEURE</td><td>LIABILITY SHALL BE ATTACHED TO SUPPLIER FOR NON-PERFORMANCE OR DELAYED EXECUTION OF THE ORDER AS A RESULT OF 'FORCE MAJEURE'.</td></tr>
            <tr><td class="bold text-center">17.</td><td class="bold">BLACKLISTING</td><td>THE COMPANY HAS ALL THE RIGHT TO CANCEL / TERMINATE THE CONTRACT ON AN IMMEDIATE BASIS AND WITHHELD THE BALANCE PAYMENT PAYABLE, IF THE SUPPLIER IS BLACKLISTED OR ITS RATING (AS PER THE RATING SYSTEM ANNOUNCED BY THE GOVERNMENT FOR GST COMPLIANCE) IS DOWNGRADED BELOW ACCEPTED LEVEL DUE TO NON-COMPLIANCE OR ITS ACTUAL OR ALLEGED ACT, FAILURE TO ACT, ERROR, OR OMISSION IN THE PERFORMANCE.</td></tr>
            <tr><td class="bold text-center">18.</td><td class="bold">DISPUTES/ CLAIMS</td><td>IF ANY, IN CONNECTION WITH THE PRODUCTS SUPPLIED / AMOUNT PAYABLE / RECEIVABLE IN CONNECTION WITH THIS PURCHASE ORDER OR INVOICE IF NOT RESOLVED BY AND BETWEEN THE PARTIES, WILL BE REFERRED TO ARBITRATION IN ACCORDANCE WITH THE ARBITRATION LAWS OF INDIA. THE JURISDICTION AND PLACE OF SITTING OF SUCH ARBITRATION WILL BE AT KOLKATA.</td></tr>
            <tr><td class="bold text-center">19.</td><td class="bold">ARBITRATION</td><td>ALL DISPUTES & DIFFERENCES ARISING OUT OF OR CONNECTED WITH THIS ORDER, FAILING AMICABLE</td></tr>
        </table>
        
        {{-- <div class="page-footer">
            <span class="page-number">1</span>
        </div> --}}
    </div>
    
    <div class="page">
        <table class="terms-table" style="border-top: none;">
            <tr style="border-top: none;">
                <td style="width:5%; border-top: none;"></td>
                <td style="width:25%; border-top: none;"></td>
                <td style="border-top: none;">
                    SETTLEMENT, SHALL BE REFERRED TO ARBITRATION UNDER THE INDIAN ARBITRATION ACT OR ANY STATUTORY MODIFICATION FOR THE TIME BEING IN FORCE & SUCH ARBITRATION SHALL TAKE IN JURISDICTION KOLKATA CITY ONLY.
                    <br>HON'BLE COURT OF KOLKATA SHALL HAVE SOLE JURISDICTION IN ALL MATTERS RELATING TO THE ARBITRATION PROCEEDINGS.
                </td>
            </tr>
            <tr>
                <td class="bold text-center">20.</td>
                <td class="bold">RISK PURCHASE</td>
                <td>IF THE SUPPLIER FAILS TO ADHERE TO THE QUALITY NORMS, DELIVERY SCHEDULES OR OTHER TERMS AND CONDITIONS CONTAINED IN THE CONTRACT FOR PURCHASE OF CONTRACTED MATERIAL OR SERVICE BUYER SHALL HAVE THE LIBERTY TO PROCURE THE MATERIAL FROM AN ALTERNATE SOURCE AT THE BIDDERS RISK AND COST, AND THE BIDDER SHALL BE LIABLE TO MAKE GOOD THE LOSS SUFFERED BY BUYER IN THIS REGARD. SIMILARLY, IF BUYER FAILS TO ADHERE TO THE TERMS AND CONDITIONS CONTAINED IN THE CONTRACT FOR PURCHASE OF COAL, SUPPLIER SHALL HAVE THE LIBERTY TO SELL THE MATERIAL TO AN ALTERNATE CUSTOMER AT BUYER'S RISK AND COST, AND THE BUYER SHALL BE LIABLE TO MAKE GOOD THE LOSS SUFFERED BY BIDDER IN THIS REGARD.</td>
            </tr>
            <tr>
                <td class="bold text-center">21.</td>
                <td class="bold">GST COMPLIANCE AND ANTI-PROFITEERING</td>
                <td>DUE TO IMPLEMENTATION OF GST, IF THERE ARE ANY BENEFITS / COST REDUCTION ACCRUING TO THE SUPPLIER, DUE TO REDUCTION IN TAX RATES AND / OR INCREASE IN THE ADMISSIBLE INPUT TAX CREDIT, THEN THE SAME SHOULD BE PASSED ON BY THE SUPPLIER TO THE COMPANY BY WAY OF REDUCTION IN THE SELLING PRICE. IN CASE OF VIOLATION / BREACH / NON-COMPLIANCE OF ANY OF THE GST PROVISIONS BY SUPPLIER WHICH WILL HAVE AN IMPACT ON THE BENEFITS ACCRUING TO THE COMPANY UNDER GST, THEN IN SUCH CASE THE COMPANY WILL HAVE ALL THE RIGHT TO RECOVER SUCH AMOUNT OF BENEFITS FROM THE SUPPLIER ALONG WITH APPLICABLE INTEREST AND PENALTY.</td>
            </tr>
            <tr>
                <td class="bold text-center">22.</td>
                <td class="bold">ORDER ACCEPTANCE</td>
                <td>PLEASE SEND US THE DUPLICATE COPY OF THIS ORDER DULY SIGNED AND STAMPED AS A TOKEN OF YOUR ACCEPTANCE.</td>
            </tr>
        </table>
        
        {{-- <div class="page-footer">
            <span class="page-number">2</span>
        </div> --}}
    </div>

</body>
</html>