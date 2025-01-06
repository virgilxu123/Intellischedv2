<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        .header {
            text-align: center;
            margin-top: 0;
            margin-bottom: 0;
        }
        .table-schedule {
            font-size: 10px;
        }
        .page-break {
            page-break-before: always; /* Ensures a new page starts before the section */
        }
    </style>
</head>
<body>
    
    @include('exports.partials.regular-load')
    <div class="page-break"></div>
    @include('exports.partials.over-load')
    <div class="page-break"></div>
    @include('exports.partials.emergency-load')
    <div class="page-break"></div>
    @include('exports.partials.praise-load')
</body>
</html>