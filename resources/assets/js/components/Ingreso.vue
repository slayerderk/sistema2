<template>
            <main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Escritorio</a></li>
            </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Ingresos
                        <button type="button" @click="mostrarDetalle()" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>
                    <!-- Listado-->
                    <template v-if="listado==1">
                        <div class="card-body">
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <!--    Elementos de buscar  -->
                                    <div class="input-group">
                                        <select class="form-control col-md-4" v-model="criterio">
                                            <option value="tipo_comprobante">Tipo Comprobante</option>    <!--    nombre y descripcion son los CRITERIOS  -->
                                            <option value="num_comprobante">N° Comprobante</option>
                                            <option value="fecha_hora">Fecha-Hora</option>
                                        </select>
                                        <input type="text" v-model="buscar" @keyup.enter="listarIngreso(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                        <button type="submit" @click="listarIngreso(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>Opciones</th>
                                            <th>Usuario</th>
                                            <th>Proveedor</th>
                                            <th>Tipo Comprobante</th>
                                            <th>Serie</th>
                                            <th>N° Comprobante</th>
                                            <th>Fecha-Hora</th>
                                            <th>Total</th>
                                            <th>Impuesto</th>
                                            <th>Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="ingreso in arrayIngreso" :key="ingreso.id">
                                            <td>
                                                <button type="button" @click="verIngreso(ingreso.id)" class="btn btn-success btn-sm">
                                                    <i class="icon-eye"></i>
                                                </button> &nbsp;
                                                <!-- muestra mensaje de Elimniar (si esta activo la categoria) -->
                                                <template v-if="ingreso.estado=='Registrado'">
                                                    <button type="button" class="btn btn-danger btn-sm" @click="desactivarIngreso(ingreso.id)">
                                                        <i class="icon-trash"></i>
                                                    </button>
                                                </template>
                                            </td>
                                            <td v-text="ingreso.usuario"></td>
                                            <td v-text="ingreso.nombre"></td>
                                            <td v-text="ingreso.tipo_comprobante"></td>
                                            <td v-text="ingreso.serie_comprobante"></td>
                                            <td v-text="ingreso.num_comprobante"></td>
                                            <td v-text="ingreso.fecha_hora"></td>
                                            <td v-text="ingreso.total"></td>
                                            <td v-text="ingreso.impuesto"></td>
                                            <!--<td v-text="ingreso.estado"></td>-->
                                            <td>
                                                <div v-if="ingreso.estado=='Registrado'">
                                                    <span class="badge badge-pill badge-success">Registrado</span>
                                                </div>
                                                <div v-else>
                                                    <span class="badge badge-pill badge-danger">Anulado</span>
                                                </div>                                                
                                            </td> 
                                        </tr>                                
                                    </tbody>
                                </table>
                            </div>
                            <nav>
                                <ul class="pagination">
                                    <li class="page-item" v-if="pagination.current_page > 1">
                                        <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1,buscar,criterio)">Ant</a>
                                    </li>
                                    <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                        <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar,criterio)" v-text="page"></a>
                                    </li>
                                    <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                        <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1,buscar,criterio)">Sig</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </template>
                    <!--Fin Listado-->
                    <!-- Detalle-->
                    <template v-else-if="listado==0">
                        <div class="card-body">
                            <div class="form-group row border">
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <label for="">Proveedor(*)</label>
                                        <v-select
                                            :on-search="selectProveedor"
                                            label="nombre"
                                            :options="arrayProveedor"
                                            placeholder="Buscar Proveedores..."
                                            :onChange="getDatosProveedor"                                        
                                        >
                                        </v-select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label for="">Impuesto(*)</label>
                                    <input type="text" class="form-control" style="color:blue;" v-model="impuesto">
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Tipo Comprobante(*)</label>
                                        <select class="form-control" v-model="tipo_comprobante">
                                            <option value="0" disabled>Seleccione</option>
                                            <option value="BOLETA">Boleta</option>
                                            <option value="FACTURA">Factura</option>
                                            <option value="TICKET">Ticket</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Serie Comprobante</label>
                                        <input type="text" class="form-control" v-model="serie_comprobante" placeholder="00x">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Número Comprobante(*)</label>
                                        <input type="text" class="form-control" v-model="num_comprobante" placeholder="000xx">
                                    </div>
                                </div>
                                <!-- Aqui se muestran los errores-->
                                <div class="col-md-12">
                                    <div v-show="errorIngreso" class="form-group row div-error">
                                        <div class="text-center text-error">
                                            <div v-for="error in errorMostrarMsjIngreso" :key="error" v-text="error">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row border">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Artículo <span style="color:red;" v-show="idarticulo==0">(*Seleccione)</span></label>
                                        <!-- BUsqueda por codigo de barras --> 
                                        <div class="form-inline"> 
                                            <button @click="abrirModal()" class="btn btn-primary fa fa-book" ></button>
                                            <input type="text" class="form-control" v-model="codigo" @keyup.enter="buscarArticulo()" placeholder="Ingrese Codigo">
                                            <!-- Muestra el nombre del producto --> 
                                            <input type="text" readonly class="form-control" v-model="articulo">
                                        </div>    
                                        <!-- Fin** -->                                     
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Precio <span style="color:red;" v-show="precio==0">(*Ingrese)</span></label>
                                        <input type="number" value="0" step="any" class="form-control" v-model="precio" min="0">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Cantidad <span style="color:red;" v-show="cantidad==0">(*Ingrese)</span></label>
                                        <input type="number" value="0" class="form-control" v-model="cantidad" min="0">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <!--desactivar el boton si esta vacio los campos -->
                                    <div class="form-group" v-show="cantidad==0 || precio==0 ||idarticulo==0">
                                        <button class="btn btn-success form-control btnagregar" disabled><i class="icon-plus"></i> Agregar</button>
                                    </div>
                                    <!--Activar el boton si los campos !=0 -->
                                    <div class="form-group" v-show="idarticulo!=0 && precio!=0 && cantidad!=0">
                                        <button @click="agregarDetalle()" class="btn btn-success form-control btnagregar"><i class="icon-plus"></i> Agregar</button>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="table-responsive col-md-12">
                                    <table class="table table-bordered table-striped table-sm">
                                        <thead>
                                            <tr>
                                                <th>Opciones</th>
                                                <th>Artículo</th>
                                                <th>Precio</th>
                                                <th>Cantidad</th>
                                                <th>Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody v-if="arrayDetalle.length">
                                            <!-- Si se tiene mas de un array, muestra los detalles del ingreso  -->
                                            <tr v-for="(detalle,index) in arrayDetalle" :key="detalle.id">
                                                <td>
                                                    <button @click="eliminarDetalle(index)" type="button" class="btn btn-danger btn-sm">
                                                        <i class="icon-close"></i>
                                                    </button>
                                                </td>
                                                <!-- Articulo-->
                                                <td v-text="detalle.articulo">
                                                </td>
                                                <td>
                                                    <!-- Precio-->
                                                    <input v-model="detalle.precio" type="number" value="3" class="form-control" min="0">
                                                </td>
                                                <td>
                                                    <!-- Cantidad-->
                                                    <input v-model="detalle.cantidad" type="number" value="2" class="form-control" min="0">
                                                </td>
                                                <!-- Sub Total-->
                                                <td>S/ 
                                                    {{(detalle.precio*detalle.cantidad).toFixed(2)}}    <!-- toFixed, sirve para redondear-->                                                  
                                                </td>
                                            </tr>
                                            <tr style="background-color: #CEECF5;">
                                                <td colspan="4" align="right"><strong>Total Parcial:</strong></td>
                                                <td>S/ {{totalParcial=(total-totalImpuesto).toFixed(2)}}</td>
                                            </tr>
                                            <tr style="background-color: #CEECF5;">
                                                <td colspan="4" align="right"><strong>Total Impuesto:</strong></td>
                                                <td>S/ {{totalImpuesto=((total*impuesto)/(1+impuesto)).toFixed(2)}}</td>
                                            </tr>
                                            <tr style="background-color: #CEECF5;">
                                                <td colspan="4" align="right"><strong>Total Neto:</strong></td>
                                                <td >
                                                    <span style="color:blue;"><h6>S/ {{total=calcularTotal.toFixed(2)}}</h6></span >
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tbody v-else>
                                            <tr>
                                                <td colspan="5">
                                                    NO hay artículos agregados
                                                </td>
                                            </tr>
                                        </tbody>                                    
                                    </table>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12" align="center">
                                    <button type="button" @click="ocultarDetalle()" class="btn btn-secondary">Cerrar</button>
                                    <button type="button" class="btn btn-warning" v-show="arrayDetalle==0" disabled>Registrar Compra</button>
                                    <button type="button" class="btn btn-warning" @click="registrarIngreso()" v-show="arrayDetalle!=0"><b>Registrar Compra</b></button>
                                </div>
                            </div>
                        </div>
                    </template>
                    <!-- Fin Detalle-->

                    <!-- Ver detalles Ingreso -->
                    <template v-else-if="listado==2">
                        <div class="card-body"><h5 class="box-title" align="center">Detalle de Ingreso</h5>
                            <!-- Cabecera -->
                            <div class="form-group row border">
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <b for="">Proveedor</b>
                                        <p v-text="proveedor"></p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <b for="">Impuesto</b>
                                    <p v-text="impuesto"></p>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <b>Tipo Comprobante</b>
                                        <p v-text="tipo_comprobante"></p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <b>Serie Comprobante</b>
                                        <p v-text="serie_comprobante"></p> 
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <b>Número Comprobante</b>
                                        <p v-text="num_comprobante"></p>   
                                    </div>
                                </div>
                            </div>
                            <!-- Cuerpo -->
                            <div class="form-group row">
                                <div class="table-responsive col-md-12">
                                    <table class="table table-bordered table-striped table-sm">
                                        <thead>
                                            <tr>
                                                <th>Artículo</th>
                                                <th>Precio</th>
                                                <th>Cantidad</th>
                                                <th>Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody v-if="arrayDetalle.length">
                                            <tr v-for="detalle in arrayDetalle" :key="detalle.id">
                                                <!-- Articulo-->
                                                <td v-text="detalle.articulo">
                                                </td>
                                                <!-- Precio-->
                                                <td v-text="detalle.precio">
                                                </td>
                                                <!-- Cantidad-->
                                                <td v-text="detalle.cantidad">
                                                </td>
                                                <!-- Sub Total-->
                                                <td>S/ 
                                                    {{(detalle.precio*detalle.cantidad).toFixed(2)}}
                                                </td>
                                            </tr>
                                            <!-- MOntos totales-->
                                            <tr style="background-color: #CEECF5;">
                                                <td colspan="3" align="right"><strong>Total Parcial:</strong></td>
                                                <td>S/ {{totalParcial=(total-totalImpuesto).toFixed(2)}}</td>
                                            </tr>
                                            <tr style="background-color: #CEECF5;">
                                                <td colspan="3" align="right"><strong>Total Impuesto:</strong></td>
                                                <td>S/ {{totalImpuesto=((total*impuesto)).toFixed(2)}}</td>
                                            </tr>
                                            <tr style="background-color: #CEECF5;">
                                                <td colspan="3" align="right"><strong>Total Neto:</strong></td>
                                                <td >
                                                    <span style="color:blue;">
                                                        <h6>S/ {{total}}</h6>
                                                    </span >
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tbody v-else>
                                            <tr>
                                                <td colspan="4">
                                                No hay articulos agregados***
                                                </td>
                                            </tr>
                                        </tbody>                                    
                                    </table>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12" align="center">
                                    <button type="button" @click="ocultarDetalle()" class="btn btn-secondary">Cerrar</button>
                                    
                                </div>
                            </div>
                        </div>
                    </template>
                    <!-- Fin ** -->
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
            <!--Inicio del modal agregar/actualizar-->
            <div class="modal fade" tabindex="-1" :class="{'mostrar' : modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="tituloModal"></h4>
                            <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- Formulario de busqueda MODAL-->
                            <div class="form-group row">
                                <div class="col-md-7">
                                    <div class="input-group">
                                        <select class="form-control col-md-4" v-model="criterioA">
                                            <option value="nombre">Nombre</option>
                                            <option value="descripcion">Descripción</option>
                                            <option value="codigo">Código</option>
                                        </select>
                                        <input type="text" v-model="buscarA" @keyup.enter="listarArticulo(buscarA,criterioA)" class="form-control" placeholder="Texto a buscar">
                                        <button type="submit" @click="listarArticulo(buscarA,criterioA)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>Opciones</th>
                                            <th>Código</th>
                                            <th>Nombre</th>
                                            <th>Categoría</th>
                                            <th>Precio Venta</th>
                                            <th>Stock</th>
                                            <th>Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="articulo in arrayArticulo" :key="articulo.id">
                                            <td>
                                                <!--<button type="button" @click="agregarDetalleModal(articulo)" class="btn btn-success btn-sm">
                                                    <i class="icon-plus"></i>
                                                </button>-->
                                                <div v-show="articulo.stock==0" v-if="articulo.condicion==0">
                                                    <button type="button" class="btn  btn-sm" disabled>Desactivado                                                                                                                                
                                                    </button>
                                                </div>
                                                <div v-show="articulo.stock!=0" v-if="articulo.condicion==0">
                                                    <button type="button" class="btn  btn-sm" disabled>Desactivado                                                                                                                                
                                                    </button>
                                                </div>
                                                <div v-show="articulo.stock==0" v-if="articulo.condicion!=0">
                                                   <button type="button" @click="agregarDetalleModal(articulo)" class="btn btn-danger btn-sm">Agotado                    
                                                    </button> 
                                                </div>      
                                                <div v-show="articulo.stock!=0" v-if="articulo.condicion!=0">
                                                   <button type="button" @click="agregarDetalleModal(articulo)" class="btn btn-success btn-sm">
                                                        <i class="icon-plus"></i>                                              
                                                    </button> 
                                                </div>
                                                
                                            </td>
                                            <td v-text="articulo.codigo"></td>
                                            <td v-text="articulo.nombre"></td>
                                            <td v-text="articulo.nombre_categoria"></td>
                                            <td v-text="articulo.precio_venta"></td>
                                            <td v-text="articulo.stock" v-if="articulo.stock==0" style="color:red;">
                                            <td v-text="articulo.stock" v-else> </td>
                                            <td>
                                                <div v-if="articulo.condicion">
                                                    <span class="badge badge-pill badge-success">Activo</span>
                                                </div>
                                                <div v-else>
                                                    <span class="badge badge-pill badge-danger">Desactivado</span>
                                                </div>
                                                
                                            </td>
                                        </tr>                                
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarPersona()">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarPersona()">Actualizar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!--Fin del modal-->
        </main>
</template>

<script>
    import vSelect from 'vue-select';
    export default {
        data (){
            return {
                ingreso_id: 0,
                idproveedor:0,
                proveedor:'',
                nombre : '',
                tipo_comprobante : 'FACTURA',
                serie_comprobante : '',
                num_comprobante : '',
                impuesto: 0.18,
                total:0.0,
                totalImpuesto: 0.0,
                totalParcial: 0.0,
                arrayIngreso : [],
                arrayProveedor: [],
                arrayDetalle : [],
                listado:1,
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorIngreso : 0,
                errorMostrarMsjIngreso : [],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                criterio : 'num_comprobante',   //inicia con el texto (en el comboBox)
                buscar : '',
                criterioA:'nombre',
                buscarA: '',
                arrayArticulo: [],
                idarticulo: 0,
                codigo: '',
                articulo: '',
                precio: 0,
                cantidad:0
            }
        },
        components: {
            vSelect
        },
        computed:{
            isActived: function(){
                return this.pagination.current_page;
            },
            //Calcula los elementos de la paginación
            pagesNumber: function() {
                if(!this.pagination.to) {
                    return [];
                }
                
                var from = this.pagination.current_page - this.offset; 
                if(from < 1) {
                    from = 1;
                }

                var to = from + (this.offset * 2); 
                if(to >= this.pagination.last_page){
                    to = this.pagination.last_page;
                }  

                var pagesArray = [];
                while(from <= to) {
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;
            },
            calcularTotal: function(){
                var resultado=0.0;
                for(var i=0;i<this.arrayDetalle.length;i++){
                    resultado=resultado+(this.arrayDetalle[i].precio*this.arrayDetalle[i].cantidad)
                }
                return resultado;
            }
        },
        methods : {
            listarIngreso (page,buscar,criterio){
                let me=this;
                var url= '/ingreso?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayIngreso = respuesta.ingresos.data;  //muestra todos los registros de la tabla categorias
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            selectProveedor(search,loading){
                let me=this;
                loading(true)
                var url= '/proveedor/selectProveedor?filtro='+search;
                axios.get(url).then(function (response) {
                    let respuesta = response.data;
                    q: search
                    me.arrayProveedor=respuesta.proveedores;
                    loading(false)
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            getDatosProveedor(val1){
                let me = this;
                me.loading = true;
                me.idproveedor = val1.id;
            },
            buscarArticulo(){
                let me=this;
                var url= '/articulo/buscarArticulo?filtro=' + me.codigo;

                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayArticulo = respuesta.articulos;

                    if (me.arrayArticulo.length>0){
                        me.articulo=me.arrayArticulo[0]['nombre'];
                        me.idarticulo=me.arrayArticulo[0]['id'];
                    }
                    else{
                        me.articulo='No existe artículo';
                        me.idarticulo=0;
                    }
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            cambiarPagina(page,buscar,criterio){
                let me = this;
                //Actualiza la página actual
                me.pagination.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.listarIngreso(page,buscar,criterio);
            },
            encuentra(id){
                var sw=0;
                for(var i=0;i<this.arrayDetalle.length;i++){
                    if(this.arrayDetalle[i].idarticulo==id){
                        sw=true;
                    }
                }
                return sw;
            },
            eliminarDetalle(index){
                let me = this;
                me.arrayDetalle.splice(index, 1);
            },
            agregarDetalle(){
                let me=this;
                if(me.idarticulo==0 || me.cantidad==0 || me.precio==0){
                }
                else{
                    if(me.encuentra(me.idarticulo)){
                        swal({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Ese artículo ya se encuentra agregado!',
                            })
                    }
                    else{
                        me.arrayDetalle.push({
                            idarticulo: me.idarticulo,
                            articulo: me.articulo,
                            cantidad: me.cantidad,
                            precio: me.precio
                        });
                        me.codigo="";
                        me.idarticulo=0;
                        me.articulo="";
                        me.cantidad=0;
                        me.precio=0; 
                    }
                    
                }

                

            },
            agregarDetalleModal(data =[]){
                let me=this;
                if(me.encuentra(data['id'])){
                        swal({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Ese artículo ya se encuentra agregado!',
                            })
                    }
                    else{
                       me.arrayDetalle.push({
                            idarticulo: data['id'],
                            articulo: data['nombre'],
                            cantidad: 1,
                            precio: 1
                        }); 
                    }
            },
            listarArticulo (buscar,criterio){
                let me=this;
                var url= '/articulo/listarArticulo?buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayArticulo = respuesta.articulos.data;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            registrarIngreso(){
                //esto funciona si hay un error
                if (this.validarIngreso()){
                    return; 
                }
                //fin--                
                let me = this;

                axios.post('/ingreso/registrar',{
                    'idproveedor': this.idproveedor,
                    'tipo_comprobante': this.tipo_comprobante,
                    'serie_comprobante' : this.serie_comprobante,
                    'num_comprobante' : this.num_comprobante,
                    'impuesto' : this.impuesto,
                    'total' : this.total,
                    'data': this.arrayDetalle

                }).then(function (response) {
                    //si se ejecuta de manera correcta
                    me.listado=1;
                    me.listarIngreso(1,'','num_comprobante');
                    //limpia las celdas, despues de guardar y los deja en limpio
                    me.idproveedor=0;
                    me.tipo_comprobante='FACTURA';
                    me.serie_comprobante='';
                    me.num_comprobante='';
                    me.impuesto=0.18;
                    me.total=0.0;
                    me.idarticulo=0;
                    me.articulo='';
                    me.cantidad=0;
                    me.precio=0;
                    me.arrayDetalle=[];
                    
                    swal({                        
                        type: 'success',
                        title: 'Compra registrada con éxito!',
                        showConfirmButton: false,
                        timer: 1800
                            })

                }).catch(function (error) {
                    console.log(error);
                });
            },
            validarIngreso(){
                this.errorIngreso=0;
                this.errorMostrarMsjIngreso =[];

                if (this.idproveedor==0) this.errorMostrarMsjIngreso.push("*Seleccione un Proveedor");
                if (this.tipo_comprobante==0) this.errorMostrarMsjIngreso.push("*Seleccione el comprobante");
                if (!this.num_comprobante) this.errorMostrarMsjIngreso.push("*Ingrese el número de comprobante");
                if (!this.impuesto) this.errorMostrarMsjIngreso.push("*Ingrese el impuesto de compra");
                if (this.arrayDetalle.length<=0) this.errorMostrarMsjIngreso.push("*Ingrese detalles");

                if (this.errorMostrarMsjIngreso.length) this.errorIngreso = 1;

                return this.errorIngreso;
            },
            mostrarDetalle(){
                let me=this;
                me.listado=0;

                me.idproveedor=0;
                me.tipo_comprobante='FACTURA';  //muestra datos iniciales al hacer clic en NUEVO
                me.serie_comprobante='';
                me.num_comprobante='';
                me.impuesto=0.18;
                me.total=0.0;
                me.idarticulo=0;
                me.articulo='';
                me.cantidad=0;
                me.precio=0;
                me.arrayDetalle=[];
            },
            ocultarDetalle(){
                this.listado=1;
            },
            verIngreso(id){
                let me=this;
                me.listado=2;
                
                //Obtener los datos del ingreso CABECERA
                var arrayIngresoT=[];
                var url= '/ingreso/obtenerCabecera?id=' + id;
                
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    arrayIngresoT = respuesta.ingreso;

                    me.proveedor = arrayIngresoT[0]['nombre'];
                    me.tipo_comprobante=arrayIngresoT[0]['tipo_comprobante'];
                    me.serie_comprobante=arrayIngresoT[0]['serie_comprobante'];
                    me.num_comprobante=arrayIngresoT[0]['num_comprobante'];
                    me.impuesto=arrayIngresoT[0]['impuesto'];
                    me.total=arrayIngresoT[0]['total'];
                })
                .catch(function (error) {
                    console.log(error);
                });

                //Obtener datos de los detalles COMPRA
                var urld= '/ingreso/obtenerDetalles?id=' + id;
                
                axios.get(urld).then(function (response) {
                    console.log(response);
                    var respuesta= response.data;
                    me.arrayDetalle = respuesta.detalles;
                })
                .catch(function (error) {
                    console.log(error);
                });               
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
            }, 
            abrirModal(){               
                this.arrayArticulo=[];
                this.modal = 1;
                this.tituloModal = 'Seleccione: Uno o varios artículos';  
            },
            desactivarIngreso(id){
               swal({
                title: '¿Esta seguro de anular este ingreso?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar!',
                cancelButtonText: 'Cancelar',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me = this;

                    axios.put('/ingreso/desactivar',{
                        'id': id
                    }).then(function (response) {
                        //si se logra desactivr, muestra este SMS
                        me.listarIngreso(1,'','num_comprobante');
                        swal({                            
                            type: 'success',
                            title: 'El ingreso ha sido anulado con éxito!',
                            showConfirmButton: false,
                            timer: 2500
                            /* otra forma de mensaje, con un buton de aceptar
                            'Anulado!',
                            'El ingreso ha sido anulado con éxito.',
                            'success'
                            */
                        })
                    }).catch(function (error) {
                        console.log(error);
                    });
                    
                    
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    
                }
                }) 
            },
        },
        mounted() {
            this.listarIngreso(1,this.buscar,this.criterio);
        }
    }
</script>
<style>    
    .modal-content{
        width: 100% !important;
        position: absolute !important;
    }
    .mostrar{
        display: list-item !important;
        opacity: 1 !important;
        position: absolute !important;
        background-color: #3c29297a !important;
    }
    .div-error{
        display: flex;
        justify-content: center;
    }
    .text-error{
        color: red !important;
        font-weight: bold;
    }
    @media (min-width: 600px) {
        .btnagregar {
            margin-top: 2rem;
        }
    }

</style>
