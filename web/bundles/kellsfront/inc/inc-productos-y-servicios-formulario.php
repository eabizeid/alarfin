<div class="col-xs-12 productos-contacto">
    <form role="form" name="form" id="form" action="productos-y-servicios-formulario-enviar.php" method="post">
        <div class="well">
            <div class="row">
                <div class="col-xs-12">
                    <h3 class="text-uppercase nomar">M&aacute;s informaci&oacute;n sobre este producto</h3>
                </div>
            </div>
            <div class="row topmar20">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="nombre">Nombre y Apellido *</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" tabindex="1" pattern="[A-Za-z ñÑáéíóúüÑÁÉÍÓÚÜ]+" required>
                    </div>
                    <div class="form-group">
                        <label for="telefono">Tel&eacute;fono</label>
                        <input type="tel" class="form-control" id="telefono" name="telefono" tabindex="2" pattern="[0-9 .-]{7,}">
                    </div>  
                    <div class="form-group">
                        <label for="email">Email *</label>
                        <input type="email" class="form-control" id="email" name="email" tabindex="3" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" required>
                    </div>    
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="consulta">Consulta o comentario *</label>
                        <textarea name="consulta" rows="6" required class="form-control" id="consulta" tabindex="4"></textarea>
                    </div> 
                    <div class="text-right">
                        <input type="submit" name="submit" id="submit" value="Enviar" tabindex="5" class="btn btn-form" />
                        <input type="hidden" name="producto" value="<?php echo $seccion ?>" />
                        <input type="hidden" name="action" value="send" />
                    </div>  
                </div>  
            </div>                              
        </div>
    </form>
</div>