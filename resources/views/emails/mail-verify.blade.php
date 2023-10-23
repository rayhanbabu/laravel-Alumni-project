@component('mail::message')
# {{$details['title']}}


{!!$details['body']!!}

@component('mail::panel')
   {!!$details['link']!!}
@endcomponent



Thanks,<br>
{!!$details['name']!!}
@endcomponent
