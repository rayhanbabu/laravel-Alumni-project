@component('mail::message')
# {{$details['title']}}


{{$details['body']}}

@component('mail::panel')
{{$details['otp_code']}}
@endcomponent

Thanks,<br>
{{$details['name']}}
@endcomponent
