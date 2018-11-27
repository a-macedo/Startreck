<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.2/css/bulma.min.css">
    <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
    <style>
        .is-complete{
            text-decoration: line-through;
        }
        .v-space{
            margin: 1em 0;
        }
        .h-space{
            margin: 0 1em;
        }
    </style>
    <title>Document</title>
</head>
<body>
    <div class="container" style="padding:2em">
        @yield('content')
    </div>

</body>
</html>