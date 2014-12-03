{% extends 'KellsBackBundle:Default:base2.php.twig' %}
{% block body %}
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Ver cr&eacute;dito</h1>
                </div>
            </div>            
		  	<div class="row">
				<form role="form">
                       <div class="col-md-12">
                        	<div class="well well-gris-claro">
                                <div class="row">
                                	<div class="col-sm-12">
                                        <div class="alert alert-titulo" role="alert">
                                            <h4 class="nomar text-uppercase"> usuario / concesionaria</h4>
                                        </div>
                                    </div> 
                                    <div class="col-sm-6">                                
                                        <div class="form-group">
                                            <label for="publicador-tipo">Tipo</label>
                                            <select name="publicador-tipo" id="publicador-tipo" class="form-control input-lg" disabled>
                                            	<option> Seleccion&aacute; un tipo</option>
                                                <option> Usuario </option>
                                                <option selected> Concesionaria </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6"> 
                                        <div class="form-group">
                                            <label for="publicador-nombre">Nombre</label>
                                            <input type="text" name="publicador-nombre" value="Autolatina S.A." id="publicador-nombre" class="form-control input-lg" disabled>
                                        </div>
                                    </div>
                                </div>
	                   		</div> 
                        </div>
                        <div id="solicitante-1">                   
                        <div class="col-md-12 topmar">
                        	<div class="well well-gris-claro">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="alert alert-titulo" role="alert">
                                            <h4 class="nomar text-uppercase">Datos del solicitante 1</h4>
                                        </div>
                                    </div> 
                                	<div class="col-sm-5"> 
                                        <div class="form-group">
                                            <label for="solicitante-nombre">Nombre</label>
                                          <input name="solicitante-nombre" type="text" autofocus disabled class="form-control input-lg" id="solicitante-nombre" tabindex="1" value="Juan Carlos">
                                        </div>
                                    </div>
                                    <div class="col-sm-5"> 
                                        <div class="form-group">
                                            <label for="solicitante-apellido">Apellido</label>
                                            <input name="solicitante-nombre" type="text" disabled class="form-control input-lg" id="solicitante-apellido" tabindex="2" value="Gimenez">
                                        </div>
                                    </div>
                                    <div class="col-sm-2"> 
                                        <div class="form-group">
                                            <label for="porcentaje">Porcentaje</label>
                                          <input type="number" name="porcentaje" id="porcentaje" min="1" max="100" disabled class="form-control input-lg" tabindex="1" value="100">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 nomar"><hr class="topmar10"></div>
                                  <div class="col-sm-4"> 
                                        <div class="form-group">
                                            <label for="solicitante-dni">DNI</label>
                                            <input name="solicitante-dni" type="number" disabled class="form-control" id="solicitante-dni" tabindex="3" value="25789552" maxlength="8">
                                        </div>
                                  </div>
                                    <div class="col-sm-4"> 
                                        <div class="form-group">
                                            <label for="solicitante-nacimiento">Fecha de nacimiento</label>
                                            <input name="solicitante-nacimiento" type="date" disabled class="form-control" id="solicitante-nacimiento" tabindex="4" value="1977-02-25">
                                        </div>
                                    </div>
                                    <div class="col-sm-4"> 
                                        <div class="form-group">
                                            <label for="solicitante-estado-civil">Estado civil</label>
                                            <select type="date" name="solicitante-estado-civil" id="solicitante-estado-civil" disabled class="form-control" tabindex="5">
                                            	<option>&nbsp;</option>
                                                <option>Soltero/a</option>
                                                <option selected>Casado/a</option>
                                                <option>Divorciado/a</option>
                                                <option>Viudo/a</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4"> 
                                        <div class="form-group">
                                            <label for="solicitante-domicilio">Domicilio</label>
                                            <input name="solicitante-domicilio" type="text" disabled class="form-control" id="solicitante-domicilio" tabindex="6" value="San Martin 485">
                                        </div>
                                    </div>
                                    <div class="col-sm-4"> 
                                        <div class="form-group">
                                            <label for="solicitante-provincia">Provincia</label>
                                            <select name="solicitante-provincia" id="solicitante-provincia" disabled class="form-control" tabindex="7">
                                            	<option>&nbsp;</option>
                                                <option selected="selected">Buenos Aires</option>
                                                <option>Capital Federal</option>
                                                <option>C&oacute;rdoba</option>
                                            </select>
                                        </div>
                                    </div>
                                  <div class="col-sm-4"> 
                                        <div class="form-group">
                                            <label for="solicitante-ciudad">Ciudad</label>
                                            <select name="solicitante-ciudad" id="solicitante-ciudad" disabled class="form-control" tabindex="8">
                                            	<option>&nbsp;</option>
                                                <option selected="selected">Ciudad 1</option>
                                                <option>Ciudad 2</option>
                                            </select>
                                        </div>
                                  </div>
                                    <div class="col-sm-4"> 
                                        <div class="form-group">
                                            <label for="solicitante-celular">Tel&eacute;fono celular</label>
                                            <input name="solicitante-celular" type="tel" disabled class="form-control" id="solicitante-celular" tabindex="9" value="15-5487-6625">
                                        </div>
                                    </div>
                                    <div class="col-sm-4"> 
                                        <div class="form-group">
                                            <label for="solicitante-telefono">Tel&eacute;fono fijo</label>
                                            <input name="solicitante-telefono" type="tel" disabled class="form-control" id="solicitante-telefono" tabindex="10" value="2579-8856">
                                        </div>
                                    </div>
                                    <div class="col-sm-4"> 
                                        <div class="form-group">
                                            <label for="solicitante-email">Email</label>
                                            <input name="solicitante-email" type="email" disabled class="form-control" id="solicitante-email" tabindex="11" value="mgimenez@gmail.com">
                                        </div>
                                    </div>     
                                    <div class="col-sm-4"> 
                                        <div class="form-group">
                                            <label for="solicitante-laboral">Actividad laboral</label>
                                          <input name="solicitante-laboral" type="text" disabled class="form-control" id="solicitante-laboral" tabindex="12" value="Gerente de Marketing">
                                        </div>
                                    </div>
                                    <div class="col-sm-4"> 
                                        <div class="form-group">
                                            <label for="solicitante-telefono-trabajo">Tel&eacute;fono del trabajo</label>
                                            <input name="solicitante-telefono-trabajo" type="tel" disabled class="form-control" id="solicitante-telefono-trabajo" tabindex="13" value="4588-8426">
                                        </div>
                                    </div> 
                                    <div class="col-sm-12 nomar"><hr class="topmar10"></div>
                                  <div class="col-sm-6"> 
                                        <div class="form-group">
                                            <label for="solicitante-fotocopia-servicio">Fotocopia de un servicio</label><br>
                                            <a href="#" target="_blank">Ver archivo</a>
                                        </div>
                                    </div> 
                                    <div class="col-sm-6"> 
                                        <div class="form-group">
                                          <label for="solicitante-fotocopia-dni">Fotocopia del DNI</label><br>
                                            <a href="#" target="_blank">Ver archivo</a>
                                        </div>
                                    </div> 
                                    <div class="col-sm-6"> 
                                        <div class="form-group">
                                          <label for="solicitante-fotocopia-recibo">Fotocopia del recibo de sueldo</label><br>
                                            <a href="#" target="_blank">Ver archivo</a>
                                        </div>
                                    </div> 
                                    <div class="col-sm-6"> 
                                        <div class="form-group">
                                          <label for="solicitante-fotocopia-ingresos">Fotocopia de comprobante de ingresos</label><br>
                                            <a href="#" target="_blank">Ver archivo</a>
                                        </div>
                                    </div>
                                    <div class="col-sm-6"> 
                                        <div class="form-group">
                                            <label for="solicitante-fotocopia-otra-1">Otra fotocopia</label><br>
                                            <a href="#" target="_blank">Ver archivo</a>
                                        </div>
                                    </div> 
                                    <div class="col-sm-6"> 
                                        <div class="form-group">
                                          <label for="solicitante-fotocopia-otra-2">Otra fotocopia</label><br>
                                            <a href="#" target="_blank">Ver archivo</a>
                                        </div>
                                    </div> 


							<div id="conyuge-1">
                                   <div class="col-sm-12 topmar">
                                   	<div class="alert alert-titulo" role="alert">
                                        <h4 class="nomar text-uppercase">Datos del c&oacute;nyuge 1</h4>
                                    </div>
                                   </div> 
                                     
								<div class="col-sm-6"> 
                                        <div class="form-group">
                                            <label for="conyuge-nombre">Nombre</label>
                                          <input name="conyuge-nombre" type="text" autofocus disabled class="form-control input-lg" id="conyuge-nombre" tabindex="20" value="Mariana">
                                        </div>
                                </div>
                                    <div class="col-sm-6"> 
                                        <div class="form-group">
                                            <label for="conyuge-apellido">Apellido</label>
                                            <input name="conyuge-nombre" type="text" disabled class="form-control input-lg" id="conyuge-apellido" tabindex="21" value="Pedraza">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 nomar"><hr class="topmar10"></div>
                                    <div class="col-sm-4"> 
                                        <div class="form-group">
                                            <label for="conyuge-dni">DNI</label>
                                            <input name="conyuge-dni" type="number" autofocus disabled class="form-control" id="conyuge-dni" tabindex="22" value="28689587" maxlength="8">
                                        </div>
                                    </div>
									<div class="col-sm-4"> 
                                      <div class="form-group">
                                            <label for="conyuge-estado-civil">Estado civil</label>
                                            <select type="date" name="conyuge-estado-civil" id="conyuge-estado-civil" disabled class="form-control" tabindex="23">
                                            	<option>&nbsp;</option>
                                                <option>Soltero/a</option>
                                                <option selected="selected">Casado/a</option>
                                                <option>Divorciado/a</option>
                                                <option>Viudo/a</option>
                                            </select>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
									<div class="col-sm-4"> 
                                        <div class="form-group">
                                            <label for="conyuge-domicilio">Domicilio</label>
                                          <input name="conyuge-domicilio" type="text" disabled class="form-control" id="conyuge-domicilio" tabindex="24" value="San Martin 485">
                                        </div>
                                    </div>
                                    <div class="col-sm-4"> 
                                        <div class="form-group">
                                          <label for="conyuge-provincia">Provincia</label>
                                          <select name="conyuge-provincia" id="conyuge-provincia" disabled class="form-control" tabindex="25">
                                            	<option>&nbsp;</option>
                                                <option selected="selected">Buenos Aires</option>
                                                <option>Capital Federal</option>
                                                <option>C&oacute;rdoba</option>
                                            </select>
                                        </div>
                                    </div>
                                <div class="col-sm-4"> 
                                        <div class="form-group">
                                          <label for="conyuge-ciudad">Ciudad</label>
                                          <select name="conyuge-ciudad" id="conyuge-ciudad" disabled class="form-control" tabindex="26">
                                            	<option>&nbsp;</option>
                                                <option selected="selected">Ciudad 1</option>
                                                <option>Ciudad 2</option>
                                            </select>
                                        </div>
                                </div>
                                    <div class="col-sm-4"> 
                                        <div class="form-group">
                                          <label for="conyuge-celular">Tel&eacute;fono celular</label>
                                            <input name="conyuge-celular" type="tel" disabled class="form-control" id="conyuge-celular" tabindex="27" value="15-5575-8552">
                                      </div>
                                </div>
                                <div class="col-sm-4"> 
                                        <div class="form-group">
                                            <label for="conyuge-telefono">Tel&eacute;fono fijo</label>
                                            <input type="tel" name="conyuge-telefono" id="conyuge-telefono" class="form-control" tabindex="28" disabled value="2579-8856">
                                        </div>
                                  </div>    
                                  <div class="clearfix"></div>
                                <div class="col-sm-4"> 
                                        <div class="form-group">
                                            <label for="conyuge-laboral">Actividad laboral</label>
                                          <input name="conyuge-laboral" type="text" disabled class="form-control" id="conyuge-laboral" tabindex="29" value="Docente">
                                        </div>
                                </div>
                                <div class="col-sm-4"> 
                                        <div class="form-group">
                                            <label for="conyuge-telefono-trabajo">Tel&eacute;fono del trabajo</label>
                                          <input name="conyuge-telefono-trabajo" type="tel" disabled class="form-control" id="conyuge-telefono-trabajo" tabindex="30" value="4578-5523">
                                        </div>
                                </div>
                                 <div class="col-sm-12 nomar"><hr class="topmar10"></div>
                                    <div class="col-sm-6"> 
                                        <div class="form-group">
                                          <label for="conyuge-fotocopia-dni">Fotocopia del DNI</label><br>
                                            <a href="#" target="_blank">Ver archivo</a>
                                        </div>
                                    </div> 
                                    <div class="col-sm-6"> 
                                        <div class="form-group">
                                            <label for="conyuge-fotocopia-otra-1">Otra fotocopia</label><br>
                                            <a href="#" target="_blank">Ver archivo</a>
                                        </div>
                                    </div> 
                                    <div class="col-sm-6"> 
                                        <div class="form-group">
                                          <label for="conyuge-fotocopia-otra-2">Otra fotocopia</label><br>
                                            <a href="#" target="_blank">Ver archivo</a>
                                        </div>
                                    </div> 
                                    <div class="col-sm-6"> 
                                        <div class="form-group">
                                            <label for="conyuge-fotocopia-otra-3">Otra fotocopia</label><br>
                                            <a href="#" target="_blank">Ver archivo</a>
                                        </div>
                                    </div> 
                                    </div>
                                </div>
	                   		</div> 
                        </div>
                        </div>
                       

						<div id="garante-1">
                        <div class="col-md-12 topmar">
                        	<div class="well well-gris-claro">
                              <div class="row">
                              		<div class="col-sm-12">
                                        <div class="alert alert-titulo" role="alert">
                                            <h4 class="nomar text-uppercase">Datos del garante 1</h4>
                                        </div>
                                    </div> 
									<div class="col-sm-6"> 
                                        <div class="form-group">
                                            <label for="garante-nombre">Nombre</label>
                                          <input name="garante-nombre" type="text" autofocus disabled class="form-control input-lg" id="garante-nombre" tabindex="40" value="Miguel Angel">
                                        </div>
                                </div>
                                    <div class="col-sm-6"> 
                                        <div class="form-group">
                                            <label for="garante-apellido">Apellido</label>
                                            <input name="garante-nombre" type="text" disabled class="form-control input-lg" id="garante-apellido" tabindex="41" value="Ortigoza">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 nomar"><hr class="topmar10"></div>
                                    <div class="col-sm-4"> 
                                        <div class="form-group">
                                            <label for="garante-dni">DNI</label>
                                            <input name="garante-dni" type="number" autofocus disabled class="form-control" id="garante-dni" tabindex="42" value="28547365" maxlength="8">
                                        </div>
                                    </div>
									<div class="col-sm-4"> 
                                      <div class="form-group">
                                            <label for="garante-estado-civil">Estado civil</label>
                                            <select type="date" name="garante-estado-civil" id="garante-estado-civil" class="form-control" tabindex="43" disabled>
                                            	<option>&nbsp;</option>
                                                <option selected>Soltero/a</option>
                                                <option selected>Casado/a</option>
                                                <option>Divorciado/a</option>
                                                <option>Viudo/a</option>
                                            </select>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
									<div class="col-sm-4"> 
                                        <div class="form-group">
                                            <label for="garante-domicilio">Domicilio</label>
                                            <input name="garante-domicilio" type="text" disabled class="form-control" id="garante-domicilio" tabindex="44" value="Corrientes 523 5&ordm;A">
                                        </div>
                                    </div>
                                    <div class="col-sm-4"> 
                                        <div class="form-group">
                                            <label for="garante-provincia">Provincia</label>
                                            <select name="garante-provincia" id="garante-provincia" disabled class="form-control" tabindex="45">
                                            	<option>&nbsp;</option>
                                                <option>Buenos Aires</option>
                                                <option selected="selected">Capital Federal</option>
                                                <option>C&oacute;rdoba</option>
                                            </select>
                                        </div>
                                    </div>
                                  <div class="col-sm-4"> 
                                        <div class="form-group">
                                            <label for="garante-ciudad">Ciudad</label>
                                            <select name="garante-ciudad" id="garante-ciudad" disabled class="form-control" tabindex="46">
                                            	<option>&nbsp;</option>
                                                <option>Ciudad 1</option>
                                                <option selected="selected">Ciudad 2</option>
                                            </select>
                                        </div>
                                </div>
                                    <div class="col-sm-4"> 
                                        <div class="form-group">
                                            <label for="garante-celular">Tel&eacute;fono celular</label>
                                            <input name="garante-celular" type="tel" disabled class="form-control" id="garante-celular" tabindex="47" value="15-8547-5524">
                                      </div>
                                </div>
                                <div class="col-sm-4"> 
                                        <div class="form-group">
                                            <label for="garante-telefono">Tel&eacute;fono fijo</label>
                                            <input name="garante-telefono" type="tel" disabled class="form-control" id="garante-telefono" tabindex="48" value="5485-5577">
                                        </div>
                                </div>    
                                  <div class="clearfix"></div>
                                <div class="col-sm-4"> 
                                        <div class="form-group">
                                            <label for="garante-laboral">Actividad laboral</label>
                                            <input name="garante-laboral" type="text" disabled class="form-control" id="garante-laboral" tabindex="49" value="Comerciante">
                                        </div>
                                </div>
                                      <div class="col-sm-4"> 
                                        <div class="form-group">
                                            <label for="garante-telefono-trabajo">Tel&eacute;fono del trabajo</label>
                                            <input name="garante-telefono-trabajo" type="tel" disabled class="form-control" id="garante-telefono-trabajo" tabindex="50" value="8547-5524">
                                        </div>
                                    </div>
									<div class="col-sm-12 nomar"><hr class="topmar10"></div>
                                    <div class="col-sm-6"> 
                                        <div class="form-group">
                                            <label for="garante-fotocopia-servicio">Fotocopia de un servicio</label><br>
                                            <a href="#" target="_blank">Ver archivo</a>
                                        </div>
                                    </div> 
                                    <div class="col-sm-6"> 
                                        <div class="form-group">
                                            <label for="garante-fotocopia-dni">Fotocopia del DNI</label><br>
                                            <a href="#" target="_blank">Ver archivo</a>
                                        </div>
                                    </div> 
                                    <div class="col-sm-6"> 
                                        <div class="form-group">
                                            <label for="garante-fotocopia-recibo">Fotocopia del recibo de sueldo</label><br>
                                            <a href="#" target="_blank">Ver archivo</a>
                                        </div>
                                    </div> 
                                    <div class="col-sm-6"> 
                                        <div class="form-group">
                                            <label for="garante-fotocopia-ingresos">Fotocopia de comprobante de ingresos</label><br>
                                            <a href="#" target="_blank">Ver archivo</a>
                                        </div>
                                    </div> 
                                    <div class="col-sm-6"> 
                                        <div class="form-group">
                                            <label for="garante-fotocopia-otra-1">Otra fotocopia</label><br>
                                            <a href="#" target="_blank">Ver archivo</a>
                                        </div>
                                    </div> 
                                    <div class="col-sm-6"> 
                                        <div class="form-group">
                                          <label for="garante-fotocopia-otra-2">Otra fotocopia</label><br>
                                            <a href="#" target="_blank">Ver archivo</a>
                                        </div>
                                    </div> 
                              </div>
	                   		</div> 
                        </div>
                        </div>

	                    <div class="col-md-12 topmar">
                        	<div class="well well-gris-claro">
                              <div class="row">
                              		<div class="col-sm-12">
                                        <div class="alert alert-titulo" role="alert">
                                            <h4 class="nomar text-uppercase">Unidad a adquirir</h4>
                                        </div>
                                    </div> 
                                    <div class="col-sm-5">                                
                                        <div class="form-group">
                                            <label for="marca">Marca</label>
                                            <select name="marca" id="marca" class="form-control input-lg" disabled tabindex="60">
                                            	<option> &nbsp; </option>
                                                <option value="MLA6039"> Alfa Romeo </option>
                                                <option value="MLA10356"> Asia </option>
                                                <option value="MLA5782"> Audi </option>
                                                <option value="MLA5783"> BMW </option>
                                                <option value="MLA42429"> Chery </option>
                                                <option value="MLA3185"> Chevrolet </option>
                                                <option value="MLA4357"> Chrysler </option>
                                                <option value="MLA5779"> Citro�n </option>
                                                <option value="MLA5680"> Daewoo </option>
                                                <option value="MLA6619"> Daihatsu </option>
                                                <option value="MLA6671"> Dodge </option>
                                                <option value="MLA97714"> Ferrari </option>
                                                <option value="MLA3174"> Fiat </option>
                                                <option value="MLA3180"> Ford </option>
                                                <option value="MLA5791"> Honda </option>
                                                <option value="MLA8509"> Hummer </option>
                                                <option value="MLA5683"> Hyundai </option>
                                                <option value="MLA6599"> Isuzu </option>
                                                <option value="MLA83415"> Jaguar </option>
                                                <option value="MLA6600"> Jeep </option>
                                                <option value="MLA7079"> Kia </option>
                                                <option value="MLA7219"> Lada </option>
                                                <option value="MLA8125"> Land Rover </option>
                                                <option value="MLA5681"> Mazda </option>
                                                <option value="MLA6038"> Mercedes Benz </option>
                                                <option value="MLA8480"> Mini </option>
                                                <option value="MLA5743"> Mitsubishi </option>
                                                <option value="MLA6173"> Nissan </option>
                                                <option value="MLA4100"> Peugeot </option>
                                                <option value="MLA8503"> Porsche </option>
                                                <option value="MLA99993"> Ram </option>
                                                <option value="MLA3205"> Renault </option>
                                                <option value="MLA6041"> Rover </option>
                                                <option value="MLA6109"> Seat </option>
                                                <option value="MLA106929"> Smart </option>
                                                <option value="MLA11927"> Ssangyong </option>
                                                <option value="MLA7078"> Subaru </option>
                                                <option value="MLA6583"> Suzuki </option>
                                                <option value="MLA11807"> Tata </option>
                                                <option value="MLA5753"> Toyota </option>
                                                <option value="MLA3196" selected> Volkswagen </option>
                                                <option value="MLA7080"> Volvo </option>
                                                <option value="MLA1939"> Otras Marcas </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-5"> 
                                      <div class="form-group">
                                            <label for="modelo">Modelo</label>
                                            <select name="modelo" id="modelo" class="form-control input-lg" disabled tabindex="61">
                                            	<option>&nbsp;</option>
                                                <option> 1500 </option>
                                                <option> 2000 </option>
                                                <option selected> Gol </option>
                                                <option> Golf </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">                                
                                        <div class="form-group">
                                          <label for="ano">A�o</label>
                                          <select name="ano" id="ano" disabled class="form-control input-lg" tabindex="62">
                                            	<option>&nbsp;</option>
                                            <option selected>2014</option>
                                            <option>2013</option>
                                            <option>2012</option>
                                          </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-3"> 
                                        <div class="form-group">
                                            <label for="valor">Valor</label>
                                            <input type="text" name="valor" id="valor" disabled class="form-control" tabindex="63" value="150000">
                                        </div>
                                	</div>
                                    <div class="col-sm-3"> 
                                        <div class="form-group">
                                            <label for="tipo">Tipo</label>
                                            <select name="tipo" id="tipo" disabled class="form-control" tabindex="64">
                                            	<option>&nbsp;</option>
                                                <option>Sedan</option>
                                                <option>Sedan 2 puertas</option>
                                                <option>Sedan 3 puertas</option>
                                                <option selected>Sedan 4 puertas</option>
                                                <option>Sedan 5 puertas</option>
                                                <option>Rural</option>
                                                <option>Rural 4 puertas</option>
                                                <option>Rural 5 puertas</option>
                                                <option>Familiar</option>
                                                <option>Coupe</option>
                                                <option>Microcoupe</option>
                                                <option>Todo terreno</option>
                                                <option>Pick up</option>
                                                <option>Pick up cabina simple</option>
                                                <option>Pick up cabina dobble</option>
                                                <option>Autom&oacute;vil</option>
                                                <option>Berlina</option>
                                                <option>Chasis con cabina</option>
                                                <option>Cami&oacute;n</option>
                                                <option>Tractor de carretera</option>
                                                <option>Semi remolque</option>
                                                <option>Furgon</option>
                                                <option>Furgoneta</option>
                                                <option>Combi</option>
                                                <option>&Oacute;mnibus</option>
                                                <option>Minibus</option>
                                            </select>
                                        </div>
                                	</div>
                                    <div class="col-sm-3"> 
                                        <div class="form-group">
                                            <label for="dominio">Dominio</label>
                                            <input type="text" name="dominio" id="dominio" class="form-control" tabindex="65" disabled value="TRI523">
                                        </div>
                                	</div>
                                    <div class="col-sm-3">                                
                                        <div class="form-group">
                                          <label for="combustible">Combustible</label>
                                          <select name="combustible" id="combustible" disabled class="form-control" tabindex="66">
                                            	<option>&nbsp;</option>
                                            <option>Diesel</option>
                                            <option selected>Nafta</option>
                                            <option>Nafta/Gnc</option>
                                          </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 nomar"><hr class="topmar10"></div>
                                    <div class="col-sm-4"> 
                                        <div class="form-group">
                                            <label for="seguro">Seguro</label>
                                            <input type="text" name="seguro" id="seguro" disabled class="form-control" tabindex="67" value="La Caja contra terceros">
                                        </div>
                                	</div>
                                    <div class="col-sm-4"> 
                                        <div class="form-group">
                                            <label for="tarjeta">D&eacute;bito en tarjeta</label>
                                            <input type="text" name="tarjeta" id="tarjeta" class="form-control" tabindex="68" disabled value="Visa">
                                        </div>
                                	</div>
                                    <div class="col-sm-4"> 
                                        <div class="form-group">
                                            <label for="tarjeta-numero">N&uacute;mero de tarjeta</label>
                                            <input type="text" name="tarjeta-numero" id="tarjeta-numero" class="form-control" tabindex="69" disabled value="4546 1245 1222 6723">
                                        </div>
                                	</div>
                                    <div class="col-sm-4"> 
                                        <div class="form-group">
                                            <label for="tarjeta-codigo">C&oacute;digo de seguridad</label>
                                            <input type="text" name="tarjeta-codigo" id="tarjeta-codigo" class="form-control" tabindex="70" disabled value="352">
                                        </div>
                                	</div>
                                    <div class="col-sm-4"> 
                                        <div class="form-group">
                                            <label for="tarjeta-vencimiento">Vencimiento</label>
                                            <input type="text" name="tarjeta-vencimiento" id="tarjeta-vencimiento" class="form-control" tabindex="71" disabled value="10/04/2020">
                                        </div>
                                	</div>
                                    <div class="col-sm-12 nomar"><hr class="topmar10"></div>
                                    <div class="col-sm-6"> 
                                        <div class="form-group">
                                            <label for="unidad-fotocopia-1">Fotocopia referente a la unidad</label><br>
                                            <a href="#" target="_blank">Ver archivo</a>
                                        </div>
                                    </div> 
                                    <div class="col-sm-6"> 
                                        <div class="form-group">
                                          <label for="unidad-fotocopia-2">Fotocopia referente a la unidad</label><br>
                                            <a href="#" target="_blank">Ver archivo</a>
                                        </div>
                                    </div> 
                                    <div class="col-sm-6"> 
                                        <div class="form-group">
                                            <label for="unidad-fotocopia-3">Fotocopia referente a la unidad</label><br>
                                            <a href="#" target="_blank">Ver archivo</a>
                                        </div>
                                    </div> 
                                    <div class="col-sm-6"> 
                                        <div class="form-group">
                                          <label for="unidad-fotocopia-4">Fotocopia referente a la unidad</label><br>
                                            <a href="#" target="_blank">Ver archivo</a>
                                        </div>
                                    </div> 
                                </div>
	                   		</div> 
                        </div>                        
                                        
 
                        <div class="col-md-12 topmar">
                        	<div class="well well-gris-claro">
                              <div class="row">
                              		<div class="col-sm-12">
                                        <div class="alert alert-titulo" role="alert">
                                            <h4 class="nomar text-uppercase">Cr&eacute;dito prendario</h4>
                                        </div>
                                    </div> 
                                    <div class="col-sm-6">                                
                                        <div class="form-group">
                                            <label for="monto">Monto solicitado</label>
                                          	<input type="text" name="monto" id="monto" disabled class="form-control input-lg" tabindex="80" value="$50000">
                                        </div>
                                    </div>
                                    <div class="col-sm-6"> 
                                      <div class="form-group">
                                            <label for="cuotas">Cuotas</label>
                                            <select name="cuotas" id="cuotas" class="form-control input-lg" disabled tabindex="81">
												<option>&nbsp;</option>
                                                <option>2</option>
                                                <option>4</option>
                                                <option>6</option>
                                                <option>8</option>
                                                <option selected>10</option>
                                                <option>12</option>
                                                <option>14</option>
                                                <option>18</option>
                                                <option>22</option>
                                                <option>24</option>
                                                <option>26</option>
                                                <option>28</option>
                                                <option>30</option>
                                                <option>32</option>
                                                <option>34</option>
                                                <option>36</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                    	<h5 class="nomar"><strong>Valor de la cuota</strong></h5>
                                        <h1 class="topmar10">$2580</h1>
                                    </div>
                                    <div class="col-sm-3">
                                    	<h5 class="nomar"><strong>Tasa</strong></h5>
                                        <h1 class="topmar10">4,20%</h1>
                                    </div>
                                    <div class="col-sm-3">
                                    	<h5 class="nomar"><strong>TEA</strong></h5>
                                        <h1 class="topmar10">62</h1>
                                    </div>
                                    <div class="col-sm-12 nomar"><hr class="topmar10"></div>
                                    <div class="col-sm-6"> 
                                        <div class="form-group">
                                            <label for="gastos">Gastos de otorgamiento</label>
                                            <input type="text" name="gastos" id="gastos" disabled class="form-control" tabindex="82" value="$150">
                                        </div>
                                	</div>
                                    <div class="col-sm-6"> 
                                        <div class="form-group">
                                            <label for="vencimiento">Primer vencimiento</label>
                                            <input type="date" name="vencimiento" id="vencimiento" disabled class="form-control" tabindex="83" value="2014-12-09">
                                        </div>
                                	</div>
                                    <div class="col-sm-12 nomar"><hr class="topmar10"></div>
                                    <div class="col-sm-12">
                                   	  	<label for="comentarios">Introduzca un comentario, consulta o indicaci&oacute;n que quiera hacernos llegar</label>
                                    	<textarea name="comentarios" id="comentarios" class="form-control" rows="8" tabindex="90" disabled>Tengan en cuenta que es el segundo cr&eacute;dito que saco con ustedes, gracias.</textarea>
                                    </div>
                                </div>
	                   		</div> 
                        </div>  
                        <div class="col-md-12 toppad botpad"> 
                        	<input type="button" value="&laquo; Volver" class="btn btn-primary" onClick="location.href='creditos.php'">
                        </div>
                    </form>  
            </div>
        </div>
    </div>
{% endblock %}