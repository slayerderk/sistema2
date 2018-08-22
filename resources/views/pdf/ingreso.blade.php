<!DOCTYPE>
<html>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte de Ingreso</title>
    <style>
        body {
        /*position: relative;*/
        /*width: 16cm;  */
        /*height: 29.7cm; */
        /*margin: 0 auto; */
        /*color: #555555;*/
        /*background: #FFFFFF; */
        font-family: Arial, sans-serif; 
        font-size: 14px;
        /*font-family: SourceSansPro;*/
        }

        #logo{
        float: left;
        margin-top: 1%;
        margin-left: 2%;
        margin-right: 2%;
        }

        #imagen{
        width: 100px;
        }

        #datos{
        float: left;
        margin-top: 0%;
        margin-left: 2%;
        margin-right: 2%;
        /*text-align: justify;*/
        }

        #encabezado{
        text-align: center;
        margin-left: 10%;
        margin-right: 35%;
        font-size: 15px;
        }

        #fact{
        /*position: relative;*/
        float: right;
        margin-top: 2%;
        margin-left: 2%;
        margin-right: 2%;
        font-size: 20px;
        }

        section{
        clear: left;
        }

        #cliente{
        text-align: left;
        }

        #facliente{
        width: 40%;
        border-collapse: collapse;
        border-spacing: 0;
        margin-bottom: 15px;
        }

        #fac, #fv, #fa{
        color: #FFFFFF;
        font-size: 15px;
        }

        #facliente thead{
        padding: 20px;
        background: #2183E3;
        text-align: left;
        border-bottom: 1px solid #FFFFFF;  
        }

        #facvendedor{
        width: 100%;
        border-collapse: collapse;
        border-spacing: 0;
        margin-bottom: 15px;
        }

        #facvendedor thead{
        padding: 20px;
        background: #2183E3;
        text-align: center;
        border-bottom: 1px solid #FFFFFF;  
        }

        #facarticulo{
        width: 100%;
        border-collapse: collapse;
        border-spacing: 0;
        margin-bottom: 15px;
        }

        #facarticulo thead{
        padding: 20px;
        background: #2183E3;
        text-align: center;
        border-bottom: 1px solid #FFFFFF;  
        }

        #gracias{
        text-align: center; 
        }
    </style>
    <body>
        @foreach ($ingreso as $i)
        <header>            
            <div id="fact">
                <p>{{$i->tipo_comprobante}}<br>
                {{$i->serie_comprobante}}-{{$i->num_comprobante}}</p>
            </div>
        </header>
        <br>
        <section>
            <div>
                <!--<th> es para celdas cabecera y <td> para celdas normales,
                    tan solo se diferencian en que la letra de <th> es negrita y la de <td> no. -->
                <table id="facliente">
                    <thead>                        
                        <tr>
                            <th id="fac">Proveedor</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th><p id="cliente">
                            Sr(a). {{$i->nombre}}<br>
                            {{$i->tipo_documento}}: {{$i->num_documento}}<br>
                            Dirección: {{$i->direccion}}<br>
                            Teléfono: {{$i->telefono}}<br>
                            Email: {{$i->email}}</p></th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
        @endforeach
        <br>
        <section>
            <div>
                <table id="facvendedor">
                    <thead>
                        <tr id="fv">
                            <th>REGISTRADO POR</th>
                            <th>FECHA DE REGISTRO</th>
                            <th>IMPUESTO</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{$i->usuario}}</td>
                            <td align="center">{{$i->created_at}}</td>
                            <td align="center" >{{$i->impuesto}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
        <br>
        <section>
            <div>
                <table id="facarticulo">
                    <thead>
                        <tr id="fa">
                            <th>CANT</th>
                            <th>DESCRIPCION</th>
                            <th>PRECIO UNIT</th>
                            <th></th>
                            <th>PRECIO TOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($detalles as $det)
                        <tr>
                            <td align="center">{{$det->cantidad}}</td>
                            <td>{{$det->articulo}}</td>
                            <td align="center">{{$det->precio}}</td> 
                            <td></td>                              
                            <td align="right">{{$det->cantidad*$det->precio}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        @foreach ($ingreso as $i)
                        <tr>
                            <th colspan="5" align="right" >---------------</th>
                        </tr>                        
                        <tr>
                            <th></th>
                            <th></th>
                            <th align="right">SUBTOTAL</th>
                            <td align="right">S/</td>
                            <td align="right">{{round($i->total-($i->total*$i->impuesto),2)}}</td>
                        </tr>
                        <tr>
                            <th></th>
                            <th></th>
                            <th align="right">IGV</th>
                            <td align="right">S/</td>
                            <td align="right">{{round($i->total*$i->impuesto,2)}}</td>
                        </tr>
                        <tr>
                            <th></th>
                            <th></th>
                            <th align="right">TOTAL</th>
                            <th align="right">S/</th>
                            <th align="right">{{$i->total}}</th>
                        </tr>
                        @endforeach
                    </tfoot>
                </table>
            </div>
        </section>
        <br>
        <br>
        <footer>
            <div id="gracias">
                <p><b>***********************************</b></p>
            </div>
        </footer>
    </body>
</html>