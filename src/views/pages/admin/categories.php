<?php $render('admin/header', ['pageActive' => $pageActive, 'user'=>$user]); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Lista de Categorias
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?=$base;?>/admin"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active"><a href="<?=$base;?>/admin/categories">Categorias</a></li>
  </ol>
</section>

<!-- Main content -->
<section class="content">

  <div class="row">
  	<div class="col-md-12">
  		<div class="box box-primary">
            
            <div class="box-header">
              <a href="<?=$base;?>/admin/categories/create" class="btn btn-success">Cadastrar Categoria</a>
            </div>

            <div class="box-body no-padding">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th style="width: 10px">#</th>
                    <th>Nome da Categoria</th>
                    <th style="width: 240px">&nbsp;</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($categories as $category): ?>
                    <tr>
                      <td><?=$category->idcategory;?></td>
                      <td><?=$category->descategory;?></td>
                      <td>
                        <a href="<?=$base;?>/admin/categories/<?=$category->idcategory;?>/products" class="btn btn-default btn-xs"><i class="fa fa-edit"></i> Produtos</a>
                        <a href="<?=$base;?>/admin/categories/<?=$category->idcategory;?>" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i> Editar</a>
                        <a href="<?=$base;?>/admin/categories/<?=$category->idcategory;?>/delete" onclick="return confirm('Deseja realmente excluir este registro?')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Excluir</a>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
  	</div>
  </div>

</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php $render('admin/footer');?>