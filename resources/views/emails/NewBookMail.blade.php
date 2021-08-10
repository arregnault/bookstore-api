@extends('emails.Base')


@section('content')


    <table align="center" role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%"
        style="max-width:660px;">
        <tbody>
            <tr>
                <td align="center" valign="top" style="font-size:0; padding: 10px 0;">
                    <div style="display:inline-block; margin: 0 -2px; max-width:66.66%; min-width:320px; vertical-align:top;"
                        class="stack-column">
                        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                            <tbody>
                                <tr>
                                    <td dir="ltr"
                                        style="font-family: Helvetica, sans-serif; font-size: 15px; line-height: 20px; color: #555555; padding: 10px 10px 10px; text-align: left;"
                                        class="center-on-narrow">
                                        <h2
                                            style="margin: 0 0 10px 0; font-family: Helvetica, sans-serif; font-size: 18px; line-height: 22px; color: #333333; font-weight: bold;">
                                            Estimado lector:
                                        </h2>
                                        <p style="margin: 0 0 10px 0; text-align: justify;padding: 1em;">
                                            El escritor de <strong>{{ $data['author']->name }}</strong>, ha hecho pública
                                            una nueva obra titulada {{ $data['book']->title }}. ¿Qué esperas para
                                            reservarlo? ¡Vamos!
                                        </p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!--[if mso]>
                                                </td>
                                                </tr>
                                                </table>
                                                <![endif]-->
                </td>
            </tr>
        </tbody>
    </table>

@endsection
