<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Sanofi</title>
        <style>
            .texto {
                text-align: center;
                color: #3d3d3d;
                font-family: Arial;
                font-size: 20px;
            }
        </style>
    </head>

    <body style="text-align: center">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td style="text-align: center">
                    <center>
                        <table
                            width="600"
                            border="0"
                            cellpadding="0"
                            cellspacing="0"
                            style="text-align: center"
                            align="center"
                        >
                            <tbody>
                                <tr>
                                    <td>
                                        <img
                                            src="/img/wisio_logo_web.png"
                                            style="display: block; margin:auto;"
                                            border="0"
                                            align="top"
                                            alt="Sanofi"
                                        />
                                    </td>
                                </tr>
                                <tr>
                                    <td height="8"></td>
                                </tr>
                                <tr>
                                    <td>
                                        <img
                                            src="{{ url('storage/emails/images_aviso_plataforma/BANNER.jpg') }}"
                                            width="600"
                                            height="180"
                                            style="display: block;"
                                            border="0"
                                            align="top"
                                            alt="Sanofi"
                                        />
                                    </td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td class="texto">
                                        {{ $adminName }}, le damos las gracias por registrarse en wisiolms<br />
                                        <p style="text-align: right; font-size: 0.7em;">WisioLMS es desarrollado por Subitus.</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td class="texto">
                                        Ahora usted está registrado en WisioLMS. <br>
                                        
                                    </td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>
                                        <p class="texto" >
                                            Siga el siguiente enlace para entrar a su sección de WisioLMS <br> 
                                            <a href="{{ $route }}"target="_blank">{{$route}}</a><br>
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td height="137" bgcolor="#ecedef" class="texto">
                                        A partir de este momento, usted podrá probar la plataforma con los siguientes usuarios:
                                        @foreach($users as $user)
                                            <p class="texto"><a target="_blank" href="{{ route('demo-login', $user) }}" >{{$user}}</a></p>
                                        @endforeach
                                        Todos estos usuarios son usuarios de prueba, para probar el área administrativa utilice el siguiente usuarios
                                        <br> 
                                        Usuario: {{ $adminEmail }}
                                        <br>
                                        Contraseña: {{ $password }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <img
                                            src="{{ url('storage/emails/images_aviso_plataforma/imgs_02.jpg') }}"
                                            width="600"
                                            height="12"
                                            style="display: block;"
                                            border="0"
                                            align="top"
                                            alt="Sanofi"
                                        />
                                    </td>
                                </tr>
                                <tr>
                                    <td
                                        height="108"
                                        style="text-align: center; color: #090909; font-family: Arial; font-size: 20px;"
                                    >
                                        <strong>¡Entre ya a WisioLMS!</strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <img
                                            src="{{ url('storage/emails/images_aviso_plataforma/imgs_04.jpg') }}"
                                            width="600"
                                            height="9"
                                            style="display: block;"
                                            border="0"
                                            align="top"
                                            alt="Sanofi"
                                        />
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <table width="600" border="0" cellspacing="0" cellpadding="0">
                                            <tbody>
                                                <tr>
                                                    <td width="20" bgcolor="#ecedef">&nbsp;</td>
                                                    <td
                                                        width="560"
                                                        height="308"
                                                        bgcolor="#ecedef"
                                                        style="text-align:justify; color: #3D3D3D; font-family: Arial; font-size: 10px; word-spacing: 1.2px; line-height: 1.3;"
                                                    >
                                                        Por favor no responda a este correo. Sanofi no recibirá el
                                                        mensaje de respuesta. Si usted tiene alguna duda con respecto al
                                                        correo o Sanofi México, por favor contáctenos en cualquiera de
                                                        los siguientes contactos. Sanofi-Aventis Av. Universidad 1738-
                                                        Col Coyoacán, México DF, 04000. Tel. 55 54 84 44 00
                                                        www.sanofi.com.mx Este material ha sido enviado por Sanofi.
                                                        Usted puede cancelar a suscripción dando clic aquí 2018
                                                        Sanofi-Aventis. Todos los derechos reservados. Material para uso
                                                        exclusivo del profesional de la salud<br /><br />Estimado
                                                        Profesional de la Salud: Sanofi es una empresa preocupada por la
                                                        Educación Médica Continua del Profesional de la Salud por lo que
                                                        ha diseñado la presente herramienta digital de capacitación en
                                                        temas de salud, eventos médicos en línea, webcasts que
                                                        contribuyen a su desarrollo y crecimiento profesional. Al
                                                        ingresar a nuestra plataforma y capacitarse por este medio,
                                                        usted está consciente de que su participación cumple plenamente
                                                        con las leyes anticorrupción aplicables, tanto nacionales como
                                                        extranjeras, como la Ley de Prácticas Corruptas en el Extranjero
                                                        (US Foreign Corrupt Practices Act), el Sistema Anticorrupción de
                                                        México, la Ley General de Responsabilidades Administrativas, así
                                                        como al Código de Ética de la Cámara de la Industria
                                                        Farmacéutica y cualquier Código de Conducta médica aplicable. La
                                                        invitación que Sanofi le extiende para participar en este
                                                        entrenamiento, de ninguna manera ha influido, ni lo hará, en
                                                        cualquier decisión o acción, en relación con cualquier negocio
                                                        actual o futuro que tuviere con Sanofi. Su participación tampoco
                                                        implica ningún compromiso para prescribir, recetar o recomendar
                                                        ningún producto de Sanofi. La prescripción de cualquier
                                                        tratamiento quedará bajo su criterio profesional con base a la
                                                        evaluación de su paciente. Hacemos de su conocimiento que usted
                                                        no recibirá ningún beneficio de Sanofi en caso de prescribir
                                                        algún producto de Sanofi, ni ningún detrimento en caso de no
                                                        hacerlo. Finalmente, su participación en el entrenamiento no
                                                        crea ningún tipo de relación laboral subordinada con Sanofi.
                                                    </td>
                                                    <td width="20" bgcolor="#ecedef">&nbsp;</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </center>
                </td>
            </tr>
        </table>
    </body>
</html>
