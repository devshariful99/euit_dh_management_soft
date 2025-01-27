@extends('admin.layouts.app', ['pageSlug' => 'admin'])
@push('css')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Cedarville+Cursive&family=Patrick+Hand&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">
@endpush
@section('title', 'Create Invoive')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="invoice-box" id="print_invoice"
                style="position: relative;margin: 100px auto; font-family: 'Roboto', sans-serif; max-width: 800px; padding: 30px; background: #fff; box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);">
                <div class="invoice_head px-4 mt-5 pt-3">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <div class="logo">
                                <img src="{{ asset('admin/image/logo.png') }}" alt="">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="info"
                                style="font-family: 'Patrick Hand', cursive; font-weight: 600; font-size: 16px; color: #000000;">
                                <ul
                                    style="list-style: none; padding: 0; float: inline-end; line-height: 25px; word-spacing: 5px;">
                                    <li>3 Caragh Meodows, Naas, Co. Kildare,</li>
                                    <li>Republic of Ireland</li>
                                    <li>Tel: +353 86 821 9885</li>
                                    <li>Email: schwdhry.gmail.com</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="invoice_body" style="margin-top: 100px;">
                    <div class="row">
                        <div class="col-6">
                            <table class="survice_table_1 mb-4" style="width: 100%;">
                                <tr style="border: 1px solid #000; border-right: 0;">
                                    <td style="padding-left: 5px;">
                                        <p><strong>SERVICE FOR:</strong></p>
                                    </td>
                                </tr>
                                <tr style="border: 1px solid #000; border-right: 0;">
                                    <td style="padding-left: 5px;">Wedsite Hosting</td>
                                </tr>
                                <tr style="border: 1px solid #000; border-right: 0;">
                                    <td style="padding-left: 5px;">Domain eutisols.com</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-6">
                            <table class="survice_table_2 w-100">
                                <tr>
                                    <td class="text-center">
                                        <p class="me-5 mb-5 pb-5"><strong>INVOICE NUMBER:</strong> <span> 202401-15</span>
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-end me-4">
                                        <p class="me-5"><strong>DATE:</strong> <span> January 15, 2024</span></p>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-6">
                            <table class="client_table" style="width: 100%;">
                                <tr style="border: 1px solid #000; border-right: 0;">
                                    <td style="padding-left: 5px;">
                                        <strong>BILL TO:</strong>
                                        <p class="mb-0">Mr. Nicky Hannigan</p>
                                    </td>
                                </tr>
                                <tr style="border: 1px solid #000; border-right: 0;">
                                    <td style="padding-left: 5px;">Custom Carpets</td>
                                </tr>
                                <tr style="border: 1px solid #000; border-right: 0;">
                                    <td style="padding-left: 5px;">Caragh</td>
                                </tr>
                                <tr style="border: 1px solid #000; border-right: 0;">
                                    <td style="padding-left: 5px;">Naas, Co. Kildare W91D92H</td>
                                </tr>
                                <tr style="border: 1px solid #000; border-right: 0;">
                                    <td style="padding-left: 5px;">Ireland</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-12 mt-5">
                            <table class="service_detials_table" style="width: 100%;">
                                <tr>
                                    <td class="text-center" style="border-bottom: 10px solid #000;">
                                        <strong>DATE</strong>
                                    </td>
                                    <td colspan="4" style="border-bottom: 10px solid #000;" class="text-center"
                                        style="border-bottom: 10px solid #000;">
                                        <strong>SERVICE DESCRIPTION</strong>
                                    </td>
                                    <td class="text-center" style="border-bottom: 10px solid #000;">
                                        <strong>RATE</strong>
                                    </td>
                                    <td class="text-center" style="border-bottom: 10px solid #000;">
                                        <strong>TIME</strong>
                                    </td>
                                    <td class="text-center" style="border-bottom: 10px solid #000;">
                                        <strong>AMOUNT</strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="pt-4"
                                        style="padding-left: 5px; border-left: 1px solid #000; border-right: 1px solid #000;">
                                        15.01.2024</td>
                                    <td class="pt-4"
                                        style="padding-left: 5px;border-left: 1px solid #000;  border-right: 1px solid #000;"
                                        colspan="4">Hosting space
                                        from 25/11/2023 - 24/11/2024</td>
                                    <td class="pt-4 text-center"
                                        style="border-left: 1px solid #000;  border-right: 1px solid #000;">
                                    </td>
                                    <td class="pt-4 text-center"
                                        style="border-left: 1px solid #000;  border-right: 1px solid #000;">
                                    </td>
                                    <td class="pt-4 text-end"
                                        style="border-left: 1px solid #000;  border-right: 1px solid #000; padding-right: 5px;">
                                        €100.00</td>
                                </tr>
                                <tr>
                                    <td class="py-4"
                                        style="padding-left: 5px;border-left: 1px solid #000;  border-right: 1px solid #000;">
                                        05.11.2023</td>
                                    <td class="py-4"
                                        style="padding-left: 5px;border-left: 1px solid #000;  border-right: 1px solid #000;"
                                        colspan="4">Website update on
                                        Home page.</td>
                                    <td class="py-4 text-center"
                                        style="border-left: 1px solid #000;  border-right: 1px solid #000;">
                                        €22ph</td>
                                    <td class="py-4 text-center"
                                        style="border-left: 1px solid #000;  border-right: 1px solid #000;">
                                        0.5 hrs</td>
                                    <td class="py-4 text-end"
                                        style="border-left: 1px solid #000;  border-right: 1px solid #000; padding-right: 5px;">
                                        €11.00</td>
                                </tr>
                                <tr style="border-top: 1px solid #000;">
                                    <td colspan="7" class="text-end">EUR Total:</td>
                                    <td class=" text-end" style="border: 1px solid #000; padding-right: 5px;">
                                        € 111.00</td>
                                </tr>
                                <tr>
                                    <td colspan="7" class="text-end">Total:</td>
                                    <td class=" text-end" style="border: 1px solid #000; padding-right: 5px;">
                                        € 111.00</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="invoice_footer my-5 pb-3">
                    <div class="row">
                        <div class="col">
                            <ul class="list-unstyled">
                                <li>Please make direct debit (Euro) transfer to the following beneficiary:</li>
                                <li>Name: Sandeep Chowdhury</li>
                                <li>Bank: Citibank</li>
                                <li><strong>BIC: CITIIE2X</strong></li>
                                <li><strong>IBAN: IE11CITI99005170066859</strong></li>
                                <li class="mt-4"><strong>Or Revolut (+353 86 8219885)</strong></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <button onclick="printT('print_invoice', 'Invoice')"> Print</button>
@endsection
@push('js')
    <script>
        function printT(el, title = '', footerTitle = '') {
            var rp = document.body.innerHTML;
            var pc = document.getElementById(el).innerHTML;
            var footer = `<div class="copyright text-center"
                    style="position: absolute; bottom: 0; left: 0; right: 0; text-align: center; font-size: 14px; ">
                    <small>
                        <span class="mr-4">www.euitsols.com ®2009 - 2024 </span> <span> Company registered in Ireland -
                            449657</span>
                    </small>
                </div>`;
            document.body.innerHTML = pc + footer;
            document.title = title ? title : '';
            window.print();
            document.body.innerHTML = rp;
        }
    </script>
@endpush
