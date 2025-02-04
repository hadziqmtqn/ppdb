<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/logo-si.ico') }}" />
    <title>Cetak Biodata PPDB - {{ $studentName }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .title {
            font-size: 12pt;
            font-weight: bold;
            text-align: center;
        }

        th {
            text-align: left;
        }

        .td-no {
            width: 4%;
        }

        .td-title {
            width: 30%;
        }

        .ttd {
            margin-top: 50px;
            text-align: center;
        }
        .td-ttd {
            width: 50%;
        }
    </style>
</head>
<body>
@if($letterhead)
    <img src="{{ $letterhead }}"  style="width: 100%" alt="kop surat">
@endif
<div class="title">
    <p style="margin: 10px 0; text-decoration: underline">FORMULIR PENDAFTARAN SISWA BARU</p>
    <p style="margin: 0; font-weight: normal">{{ $educationalInstitution }}</p>
    <p style="margin: 0; font-weight: normal">Tahun Ajaran {{ $schoolYear }}</p>
</div>
<table style="width: 100%">
    <tbody>
    <tr>
        <th colspan="3">A. Registrasi</th>
    </tr>
    @foreach($registrations as $key => $registration)
        <tr>
            <td class="td-no">{{ $loop->iteration }}.</td>
            <td class="td-title">{{ $key }}</td>
            <td>: {{ $registration }}</td>
        </tr>
    @endforeach

    <tr>
        <th colspan="3">B. Data Pribadi</th>
    </tr>
    @foreach($personalData as $key => $personal)
        <tr>
            <td class="td-no">{{ $loop->iteration }}.</td>
            <td class="td-title">{{ $key }}</td>
            <td>: {{ $personal }}</td>
        </tr>
    @endforeach

    <tr>
        <th colspan="3">C. Keluarga</th>
    </tr>
    @foreach($families as $key => $family)
        <tr>
            <td class="td-no">{{ $loop->iteration }}.</td>
            <td class="td-title">{{ str_replace('- ', '', $key) }}</td>
            <td>: {{ $family }}</td>
        </tr>
    @endforeach

    <tr>
        <th colspan="3">D. Tempat Tinggal</th>
    </tr>
    @foreach($residences as $key => $residence)
        <tr>
            <td class="td-no">{{ $loop->iteration }}.</td>
            <td class="td-title">{{ $key }}</td>
            <td>: {{ $residence }}</td>
        </tr>
    @endforeach

    <tr>
        <th colspan="3">E. Asal Sekolah</th>
    </tr>
    @foreach($previousSchools as $key => $previousSchool)
        <tr>
            <td class="td-no">{{ $loop->iteration }}.</td>
            <td class="td-title">{{ $key }}</td>
            <td>: {{ $previousSchool }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
<div class="ttd">
    <table style="width: 100%">
        <tr>
            <td></td>
            <td>{{ $city }}, {{ $date }}</td>
        </tr>
        <tr>
            <td class="td-ttd">Orang Tua/Wali</td>
            <td class="td-ttd">Panitia</td>
        </tr>
        <tr>
            <td></td>
            <td style="padding: 30px 30px 30px 5px"></td>
        </tr>
        <tr>
            <td class="td-ttd">{{ $parentName ?? '________________________' }}</td>
            <td class="td-ttd">________________________</td>
        </tr>
    </table>
</div>
</body>
</html>
