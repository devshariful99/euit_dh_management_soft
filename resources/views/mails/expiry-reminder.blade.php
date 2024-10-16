<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Renewal Reminde</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 16px;
        }

        .email-body {
            max-width: 700px;
            margin: 0 auto;
        }

        .email-container {
            width: 100%;
            padding: 40px;
            background-color: #f8f9fa;
            border-radius: 8px;
        }

        .email-header h2 {
            margin: 20px 0;
            font-size: 25px;
            font-weight: 700;
        }

        .table-custom {
            margin: 0;
        }

        .table_border {
            overflow: hidden;
            background-color: #fff;
            border: 1px solid #cccccc;
            border-radius: 5px;
        }

        .small-text {
            color: #6c757d;
            font-size: 14px;
            margin-top: 10px;
        }

        .table th,
        .table td {
            padding: 20px 12px;
            vertical-align: middle;
        }

        .email_signature {
            margin-top: 20px;
            padding: 0 20px;
        }

        @media only screen and (max-width: 768px) {
            body {
                font-size: 15px;
            }

            .email-header h2 {
                font-size: 22px;
            }

            .table th,
            .table td {
                padding: 15px 10px;
            }
        }

        @media only screen and (max-width: 576px) {

            /* For mobile phones */
            body {
                font-size: 14px;
            }

            .email-header h2 {
                font-size: 20px;
            }

            .table th,
            .table td {
                padding: 12px 8px;
            }

            .email-container {
                padding: 10px;
            }

            .email_signature small {
                font-size: 13px;
            }

            .email_signature a {
                font-size: 14px;
            }

            img {
                height: 40px;
            }

            /* Transform table into a stacked list on mobile */
            .table_border {
                display: block;
                width: 100%;
            }

            .table-custom {
                display: block;
                width: 100%;
            }

            .table-custom thead {
                display: none;
            }

            .table-custom tbody {
                display: block;
                width: 100%;
            }

            .table-custom tr {
                display: block;
                width: 100%;
            }

            .table-custom td {
                display: block;
                text-align: right;
                font-size: 14px;
                padding-left: 50%;
                position: relative;
            }

            .table-custom td::before {
                content: attr(data-label);
                position: absolute;
                left: 0;
                top: 50%;
                transform: translateY(-50%);
                padding-left: 10px;
                font-weight: bold;
                text-align: left;
            }
        }
    </style>
</head>

<body>
    <div class="email-body">
        <div class="email-container">
            <h4 class="text-muted">Euitsols.com</h4>
            <div class="card">
                <div class="card-body px-2 px-sm-4">
                    <div class="email-header">
                        <h2>Renew your {{ $mailData['email_for'] }} before it expires.</h2>
                    </div>
                    <div class="table_border">
                        <table class="table table-custom">
                            <thead>
                                <tr>
                                    <th>Your {{ Str::ucfirst($mailData['email_for']) }}</th>
                                    <th>Expiry Date</th>
                                    <th>Days Left</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td data-label="Your Domain" class="text-muted">
                                        @if ($mailData['email_for'] == 'domain')
                                            <a href="https://{{ $mailData['name'] }}" target="_blank">
                                                <b>{{ $mailData['name'] }}</b>
                                            </a>
                                            <br />
                                            <small class="mt-3 ms-3 d-block">{{ Str::ucfirst($mailData['email_for']) }}
                                                Renewal</small>
                                        @else
                                            <span>{{ $mailData['name'] }}</span><br>
                                            <span>Storage: {{ $mailData['storage'] }}</span>
                                        @endif


                                    </td>
                                    <td data-label="Expiry Date" class="text-muted text-nowrap">
                                        {{ date('F j, Y', strtotime($mailData['expire_date'])) }}<br />
                                    </td>
                                    <td data-label="Days Left" class="text-muted text-nowrap">
                                        <small style="color: #dc3545">Expiring in {{ $mailData['day'] }} days</small>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center small-text">
                        <p>
                            Need Help?<br />Feel free to contact us using the details below.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="email_signature mt-3">
            <small class="text-muted">Sandeep Chowdhury</small><br>
            <small class="text-muted">European IT Solutions</small><br>
            <a href="https://www.euitsols.com"><b>www.euitsols.com</b></a><br>
            <small class="text-muted">Tel: +353 86 8219885</small> <br>
            <small><b><span class="text-muted">Please rate our service: </span><a
                        href="https://www.trustpilot.com/evaluate/www.euitsols.com">https://www.trustpilot.com/evaluate/www.euitsols.com</a></b></small><br>
            <img style="height: 50px" src="{{ asset('admin/image/logo.png') }}" alt="">
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
