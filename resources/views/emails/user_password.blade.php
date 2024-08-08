<h4 style="color: green">Dear, {{$user}}</h4>
<div>
    {{$bodyMessage}} <br>
    @if (@$pss)
      <h3>Password: <span style="background:#E6FC5C; width:300px; height: 60px;">{{$pss}}</span> </h3>
    @endif
</div>

<p><strong>Send By:</strong> {{$fromName}}</p>
