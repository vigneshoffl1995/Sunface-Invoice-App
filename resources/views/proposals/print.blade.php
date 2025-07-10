@php
    preg_match('/(\d+)(?!.*\d)/', $proposal->proposal_number, $matches);
    $lastNumber = $matches[1] ?? '';
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Sunface_Technologies_Proposal_{{ $lastNumber }}</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <style>
    html, body {
      margin: 0;
      padding: 0;
      height: 100%;
      font-family: Helvetica, Arial, sans-serif;
      font-size: 12px;
      line-height: 1.5;
      color: #333;
    }
    .invoice-box {
      display: flex;
      flex-direction: column;
      min-height: 100vh;
      max-width: 800px;
      margin: auto;
      border: 1px solid #eee;
      box-sizing: border-box;
      padding: 15px; /* reduced margin */
    }
    .content {
      flex: 1;
    }
    .section {
      border-bottom: 1px solid #ddd;
      padding-bottom: 10px;
      margin-bottom: 15px;
    }
    .highlight {
      background-color: #f8f9fa;
      font-weight: bold;
      padding: 2px 4px;
      border-radius: 3px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
    }
    table td, table th {
      padding: 5px;
      vertical-align: top;
    }
    table th {
      background: #f0f0f0;
      border: 1px solid #ddd;
    }
    table tr.item td {
      border-bottom: 1px solid #eee;
    }
    .total { font-weight: bold; }
    .right { text-align: right; }
    .center { text-align: center; }
    .logo { max-height: 100px; }
    .footer {
      border-top: 1px solid #ddd;
      padding-top: 10px;
      text-align: center;
      font-size: 11px;
      margin-top: 10px;
    }
    .footer-table {
      border-top: 1px solid #ddd;
      margin-top: 15px;
      padding-top: 10px;
    }
    .signature {
      text-align: right;
      margin-top: 20px;
    }
    .greeting {
      text-align: center;
      margin-top: 10px;
      font-style: italic;
    }
    @media print {
      html, body { height: auto; }
      .invoice-box { border: none; box-shadow: none; }
    }
  </style>
</head>
<body>
    <div class="invoice-box">
      <div class="content">
        <div class="section">
        <h2>CLIENT PROPOSAL</h2>
      </div>

      <div class="section">
        <table>
          <tr>
            <td style="width:50%">
              <img src="{{ asset('st_inv_logo.png') }}" class="logo" alt="Company Logo"/>
            </td>
            <td style="width:50%" class="right">
              <strong>Sunface Technologies</strong><br/>
              16/31, S and S Enclave, Kannapiran Colony<br/>
              Valipalayam Main Road, Tiruppur -<br/>
              <span class="highlight">Phone: +91-98940 37680</span><br/>
              <span class="highlight">GSTIN: 33BQHPM5372D1ZY</span><br/>
             info@sunface.in
            </td>
          </tr>
        </table>
      </div>

      <div class="section">
        <table>
          <tr>
            <td style="width:50%">
              <strong>Proposal to:</strong><br/>
              <span class="highlight">{{ $proposal->customer_name }}</span><br/>
              {{ $proposal->customer_address }}<br/>
              <span class="highlight">Phone: +91-{{ $proposal->customer_phone }}</span><br/>
            </td>
            <td style="width:50%" class="right">
              <table>
                <tr>
                  <td>Proposal No:</td>
                  <td><span class="highlight">{{ $proposal->proposal_number }}</span></td>
                </tr>
                <tr>
                  <td>Proposal Date:</td>
                  <td><span class="highlight">{{ $proposal->proposal_date->format('d-m-Y') }} / {{ $proposal->created_at->format('h:i A') }}</span></td>
                </tr>
                <tr>
                  <td>Total Amount:</td>
                  <td><span class="highlight">₹{{ number_format($proposal->round_total, 2) }}</span></td>
                </tr>
                <tr>
                  <td>Valid Until:</td>
                  <td><span class="highlight">{{ optional($proposal->valid_until)->format('d-m-Y') ?? 'N/A' }}</span></td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </div>

      <div class="section">
        <table>
          <thead>
            <tr>
              <th>S.No</th>
              <th>Activity (Services)</th>
              <th class="center">Qty</th>
              <th class="right">Rate (₹)</th>
              <th class="right">Amount (₹)</th>
            </tr>
          </thead>
          <tbody>
            @foreach($proposal->items as $key => $item)
                <tr class="item">
                    <td class="center">{{ $key+1 }}</td>
                    <td>{{ $item->activity }}</td>
                    <td class="center">{{ $item->quantity }}</td>
                    <td class="right">{{ number_format($item->rate, 2) }}</td>
                    <td class="right">{{ number_format($item->amount, 2) }}</td>
                </tr>
            @endforeach
            <tr>
              <td colspan="4" class="right">Subtotal (without GST)</td>
              <td class="right">₹{{ number_format($proposal->sub_total, 2)}}</td>
            </tr>
            <tr>
              <td colspan="4" class="right">CGST @ 9%</td>
              <td class="right">₹{{ number_format($proposal->cgst, 2)}}</td>
            </tr>
            <tr>
              <td colspan="4" class="right">SGST @ 9%</td>
              <td class="right">₹{{ number_format($proposal->sgst, 2) }}</td>
            </tr>
            <tr>
              <td colspan="4" class="right">Round-off</td>
              <td class="right">₹{{ number_format($proposal->round_value, 2) }}</td>
            </tr>
            <tr>
              <td colspan="4" class="right total">Total</td>
              <td class="right total">₹{{ number_format($proposal->round_total, 2) }}</td>
            </tr>
          </tbody>
        </table>
        <div style="width: 100%;">
    <p><span style="font-weight: bold;">Kind Note:</span> 50% Advance is mandatory to initiate the work.</p>
  </div>
      </div>

      <div class="section" style="display: flex; justify-content: space-between; align-items: flex-start;">
  <!-- Left: Other Services -->
  <div style="width: 45%;">
    <strong>Other Services:</strong><br/>
    • Website Development<br/>
    • Mobile App Development<br/>
    • Digital Marketing<br/>
    • SEO Optimization<br/>
  </div>

  <!-- Right: Authorized Signature -->
  <div class="signature" style="width: 45%; text-align: right;">
    <!-- <p><strong>Authorized Signature</strong></p>
    <img src="{{ asset('Signature.png') }}" alt="Signature" style="height:40px;"/><br/> -->
    <span class="highlight">Mr.Mohanraj Subramaniam</span>
  </div>
</div>
</div>

<div>
      <table style="width:100%; margin-top: 20px;">
  <tr>
    <td style="width:33%; text-align:left;">
      <strong>Bank Details:</strong><br/>
      <!-- PAN Number: BQHPM5372D<br/> -->
      A/C No: 921020050952867<br/>
      Account Name: Sunface Technologies<br/>
      IFSC: UTIB0000210<br/>
      Bank/Branch: Axis Bank, Tiruppur<br/>
      UPI: sunfacetechnologies@axisbank<br/>
    </td>
    <td style="width:33%; text-align:center;">
      <strong>Scan QR to Pay</strong><br/>
      <img src="{{ asset('gpayqr.png') }}" alt="QR" style="height:100px;"><br/>
      <small>UPI: 9894037680@okbizaxis</small>
    </td>
    <td style="width:33%; text-align:right;">
      <strong>Payment Methods:</strong><br/>
      Credit Card / Debit Card<br/>
      Net Banking / UPI<br/>
      Wallets & Other Modes<br/>
      <br/>
      <a href="https://pages.razorpay.com/sunfacein" target="_blank" style="display: inline-block; margin-top: 8px; padding: 6px 10px; background-color: #007bff; color: white; border-radius: 5px; text-decoration: none; font-size: 12px;">
        🔗 Pay Now
      </a>
    </td>
  </tr>
</table>
    </div>

     
      <div class="footer">
      <div class="greeting">
        This is an E-Generated Quatation, valid only for 5 Days.
      </div>
    </div>
    </div>
</body>
</html>
