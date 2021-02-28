<div class="row">
    <!-- left column -->
    <div class="col-md-3">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
                
            </div><!-- /.box-header -->
            <!-- form start -->
            <form role="form" id="formProcurarStatusProposta" action="" name="formProcurarStatusProposta" method="post" onsubmit="return false">
                <input type="hidden" name="codstatus" id="codstatus" value="<?= $_GET["codstatus"] ?>"/>
                <div class="box-body">

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="sexo">Nome</label>
                            <input type="text" class="form-control" name="nome" id="nome" value=""/>
                        </div>
                        <!-- /.form-group -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="sexo">Dt Inicio</label>
                            <input type="date" class="form-control" name="data1" id="data1" value=""/>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="sexo">Dt. Fim</label>
                            <input type="date" class="form-control" name="data2" id="data2" value=""/>
                        </div>
                    </div>                                     

                </div><!-- /.box-body -->
                <div class="box-footer">
                    <button class="btn btn-primary" onclick="procurarStatus(false)">Procurar</button>
                </div>
            </form>
        </div><!-- /.box -->
    </div><!--/.col (left) -->
    <!--/.col (right) -->
    <div id="listagemStatusProposta" class="col-md-12"></div>
</div>   <!-- /.row -->