<html>
    <body>
        <div style="margin-top:15px;margin-bottom:15px;">
            <img src="{{ $message->embed(public_path().'/img/logo-email.png') }}" alt="Core-ES" />
        </div>
        <hr>
        <div>
            <p>{!! $body !!}</p>
        </div>
        <hr>
        <div>
            <p>Mensagem enviada pelo <a href="{{ route('site.home') }}">site oficial</a> do Core-ES.</p>
        </div>
    </body>
</html>