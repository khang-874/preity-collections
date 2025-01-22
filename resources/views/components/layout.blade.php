@props(['categories'])

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="icon" href="{{url('/')}}/images/logo_white.png" />
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer"
    />
    <style>
    [x-cloak] { display: none !important; }
    </style>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>    
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <title>Preity Collection</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')    
    @livewireStyles
</head>
<body class="bg-[#f8f8fc] text-[#2c2c2c] flex flex-col min-h-screen">
    <x-header :categories="$categories"></x-header>
    <main class="flex-grow pt-12">
        {{$slot}} 
    </main>
    <x-flash-message></x-flash-message>
    @livewireScripts
    <x-footer></x-footer>
</body>
</html>