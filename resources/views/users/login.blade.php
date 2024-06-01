<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')

</head>
<body>
    <form action="/authenticate" method="post">
        @csrf
        <div class="">Login Form</div>
        <div class="">
            <label for="email">email</label>
            <input type="text" name="email" class="border-2 rounded-sm">
            @error('email')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
            @enderror
        </div>
        <div class="mt-2">
            <label for="password">password</label>
            <input type="password" name="password" class="border-2 rounded-sm">
            @error('password')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
            @enderror
        </div>
        <button class="bg-blue-600 p-4 text-white font-medium mt-2 rounded-md">Sign in</button>
    </form>
</body>
</html>