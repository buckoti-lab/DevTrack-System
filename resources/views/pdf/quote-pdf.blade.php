<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Price Quote</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            margin: 0;
            padding: 0;
            background: #ffffff;
            font-size: 14px;
        }

        .page-border {
            border-left: 20px solid #f5e246;
            border-right: 20px solid #f5e246;
            padding: 35px 40px;
            min-height: 100vh;
        }

        h1 {
            text-align: center;
            margin-bottom: 0px;
            font-size: 26px;
            letter-spacing: 1px;
        }

        .subtitle {
            text-align: center;
            margin-top: 3px;
            font-size: 13px;
            color: #555;
        }

        .section-title {
            background: #f0f0f0;
            padding: 7px 10px;
            font-weight: bold;
            margin-top: 25px;
            border-left: 4px solid #f5e246;
            font-size: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 6px;
        }

        td, th {
            padding: 7px;
            vertical-align: top;
            font-size: 13px;
        }

        .bordered td {
            border: 1px solid #bbb;
        }

        .items-table th {
            background: #f7f7f7;
            border: 1px solid #bbb;
            text-align: left;
            font-size: 13px;
        }

        .items-table td {
            border: 1px solid #bbb;
        }

        .right {
            text-align: right;
        }

        .totals-table td {
            border: 1px solid #bbb;
        }

        .signature {
            text-align: left;
            margin-top: 40px;
            font-size: 14px;
        }

        .terms {
            text-align: left;
            margin-top: 35px;
            font-size: 12.5px;
            line-height: 1.5em;
        }

        .terms strong {
            font-size: 14px;
        }
    </style>
</head>
<body>

<div class="page-border">

    <h1>SOFTWARE DEVELOPMENT PRICE QUOTE</h1>
    <p class="subtitle">(Company Details)</p>

    <!-- Company Info -->
    <div class="section-title">COMPANY INFORMATION</div>
    <table class="bordered">
        <tr>
            <td><strong>Company Name:</strong></td>
            <td>{{ $quote->company_name }}</td>
        </tr>
        <tr>
            <td><strong>Address:</strong></td>
            <td>{{ $quote->company_address }}</td>
        </tr>
        <tr>
            <td><strong>Email:</strong></td>
            <td>{{ $quote->company_email }}</td>
        </tr>
        <tr>
            <td><strong>Contact:</strong></td>
            <td>{{ $quote->company_contact }}</td>
        </tr>
        <tr>
            <td><strong>Date:</strong></td>
            <td>{{ $quote->company_date }}</td>
        </tr>
        <tr>
            <td><strong>Website:</strong></td>
            <td>{{ $quote->company_website }}</td>
        </tr>
    </table>

    <!-- Client Info -->
    <div class="section-title">CLIENT INFORMATION</div>
    <table class="bordered">
        <tr>
            <td><strong>Client Name:</strong></td>
            <td>{{ $quote->client_name }}</td>
        </tr>
        <tr>
            <td><strong>Address:</strong></td>
            <td>{{ $quote->client_address }}</td>
        </tr>
        <tr>
            <td><strong>Email:</strong></td>
            <td>{{ $quote->client_email }}</td>
        </tr>
        <tr>
            <td><strong>Contact:</strong></td>
            <td>{{ $quote->client_contact }}</td>
        </tr>
        <tr>
            <td><strong>Quote Number:</strong></td>
            <td>{{ $quote->quote_number }}</td>
        </tr>
        <tr>
            <td><strong>Valid Until:</strong></td>
            <td>{{ $quote->quote_valid_date }}</td>
        </tr>
    </table>

    <!-- Items -->
    <div class="section-title">ITEMS</div>

    <table class="items-table">
        <thead>
        <tr>
            <th>ITEM</th>
            <th class="right">QUANTITY</th>
            <th class="right">PRICE</th>
            <th class="right">TOTAL</th>
        </tr>
        </thead>

        <tbody>
        @foreach ($quote->items as $item)
            <tr>
                <td>{{ $item['item'] }}</td>
                <td class="right">{{ $item['qty'] }}</td>
                <td class="right">{{ number_format($item['price'], 2) }}</td>
                <td class="right">{{ number_format($item['total'], 2) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <!-- Totals -->
    <div class="section-title">TOTALS</div>
    <table class="totals-table">
        <tr>
            <td><strong>Sub Total</strong></td>
            <td class="right">{{ number_format($quote->sub_total, 2) }}</td>
        </tr>
        <tr>
            <td><strong>Tax</strong></td>
            <td class="right">{{ number_format($quote->tax, 2) }}</td>
        </tr>
        <tr>
            <td><strong>Discount</strong></td>
            <td class="right">{{ number_format($quote->discount, 2) }}</td>
        </tr>
        <tr>
            <td><strong>Grand Total</strong></td>
            <td class="right"><strong>{{ number_format($quote->grand_total, 2) }}</strong></td>
        </tr>
    </table>

    <!-- Signature -->
    <p class="signature"><strong>Authorized Signature:</strong> ________________________</p>

    <!-- Terms -->
    <div class="terms">
        <p><strong>TERMS AND CONDITIONS</strong></p>
<!--         <p>• Customer must approve and pay according to agreement.</p>
        <p>• A digital copy of this quotation will be emailed to the customer.</p>
        <p>• This quotation is valid for <strong>30 days</strong> unless otherwise stated.</p> -->
        <ul>
            <li>Customer must approve and pay according to agreement.</li>
            <li>A digital copy of this quotation will be emailed to the customer.</li>
            <li>This quotation is valid for <strong>30 days</strong> unless otherwise stated.</li>
        </ul>
    </div>

</div>

</body>
</html>
