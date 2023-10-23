@component('mail::message')
# {{$details['title']}}


{{$details['body']}}

@component('mail::panel')

   <a href="{{$details['link']}}">{{$details['link']}}</a><br>
   
@endcomponent

{{$details['body1']}}

Thanks,<br>
{{$details['name']}}
@endcomponent
