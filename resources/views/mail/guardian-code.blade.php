@component('mail::message')
# Dear {{$name}},
Here is your 6 digits confirmation code {{$guardian_code}}

Thanks, <br>
{{config('app.name')}}
@endcomponent