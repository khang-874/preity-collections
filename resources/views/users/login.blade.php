<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')

</head>
<body class="bg-gray-100">
    <form action="/authenticate" method="post" class="flex flex-col items-center py-8 justify-center">
        @csrf
        <div class="bg-white p-8 rounded-md drop-shadow-sm flex flex-col gap-4">
            <div class="font-semibold text-2xl">Sign in to your account</div>
            <div class="flex flex-col">
                <label for="email" class="font-medium">Email</label>
                <input type="text" name="email" class="border-2 rounded-md p-1 focus:border-gray-200" value="{{old('email')}}">
                @error('email')
                    <p class="text-red-500 mt-1">{{$message}}</p>
                @enderror
            </div>
            <div class="flex flex-col">
                <label for="password" class="font-medium">Password</label>
                <input type="password" name="password" class="border-2 rounded-md p-1" value="{{old('password')}}">
                @error('password')
                    <p class="text-red-500 mt-1">{{$message}}</p>
                @enderror
            </div>
            <button class="bg-blue-500 w-full rounded-md text-white py-2">Sign in</button>
            <a href="/" class="bg-blue-500 w-full rounded-md text-white py-2 flex justify-center hover:cursor-pointer" @click="$event.target.eventDefault()">Return to mainpage</button></a>

        </div>
    </form>
</body>
</html>