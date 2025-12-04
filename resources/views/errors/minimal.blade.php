

@php
   $status = $exception?->getStatusCode();
   $messages = [
      404 => 'Pagina niet gevonden.',
      403 => 'Toegang geweigerd.',
      500 => 'Interne serverfout.',
      419 => 'Sessie verlopen, probeer opnieuw.',
   ];
   $message = $messages[$status] ?? $exception?->getMessage() ?? 'Er is iets misgegaan.';
@endphp


<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
   <head>
      <title>@yield('code') |  @yield('message')</title>
      <script src="https://cdn.tailwindcss.com"></script>
   </head>
   <body class="min-h-screen overflow-y-auto text-gray-900">


      <div class="flex min-h-screen items-center justify-center py-12 text-gray-900">
         <div class="relative  ">
            <div class="flex w-full justify-center pb-4">
               <img src="/images/logo-color.png" alt="Logo" style = "height: 150px;" class=" mx-auto mb-4">
            </div>
            <h2 class="text-center text-2xl font-bold tracking-tight pb-4">
               {{$exception?->getStatusCode()}}
            </h2>
   
            <center> {{$message}}</center>

            <p class="text-center mt-5 font-medium">
               <button  onclick="window.history.back()" style = "background-color: #71b175" class="rounded-lg   text-white p-2  w-100 px-4  ">Ga Terug</button>
            </p>

            <div class="w-full text-stone-200  fixed bottom-0 pb-7" >
            <center> {{$message}}</center>
            </div>
         </div>
      </div>
   </body>
</html>
