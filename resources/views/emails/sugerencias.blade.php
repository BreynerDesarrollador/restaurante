@component('mail::message')
# Introduction

@component('mail::panel')
Nombre: {{$nombre}}<br>
Email:{{$email}}<br>
Asunto:{{$asunto}}<br>

Mensaje:<br>
{{$mensaje}}
@endcomponent
@endcomponent
