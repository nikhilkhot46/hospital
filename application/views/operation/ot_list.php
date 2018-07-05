<div class="row">
    <!--  table area -->
    <div class="col-sm-12">
        <div  class="panel panel-default thumbnail">
 
            <div class="panel-heading no-print">
                <div class="btn-group">
                    <a class="btn btn-success" href="<?php echo base_url("operation/operation/add_theater") ?>"> <i class="fa fa-plus"></i>  <?php echo display('add_ot') ?> </a> 
                </div>
            </div> 
            <div class="panel-body">
                <table class="datatable table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th><?php echo display('serial') ?></th>
                            <th><?php echo display('ot_id') ?></th>
                            <th><?php echo display('name') ?></th>
                            <th><?php echo display('description') ?></th>
                            <th><?php echo display('status') ?></th>
                            <th><?php echo display('action') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($ot)) { ?>
                            <?php $sl = 1; ?>
                            <?php foreach ($ot as $opth) { ?>
                                <tr class="<?php echo ($sl & 1)?"odd gradeX":"even gradeC" ?>">
                                    <td><?php echo $sl; ?></td>
                                    <td><?php echo $opth->ot_id; ?></td>
                                    <td><?php echo $opth->ot_name; ?></td>
                                    <td><?php echo character_limiter($opth->ot_description, 60); ?></td>
                                    <td><?php echo (($opth->status==1)?display('active'):display('inactive')); ?></td>
                                    <td class="center" width="80">
                                        <!-- <a href="<?php echo base_url("operation/operation/details/$opth->ot_id") ?>" class="btn btn-xs btn-success"><i class="fa fa-eye"></i></a> -->
                                        <a href="<?php echo base_url("operation/operation/update_theater/$opth->ot_id") ?>" class="btn btn-xs  btn-primary"><i class="fa fa-edit"></i></a> 
                                    </td>
                                </tr>
                                <?php $sl++; ?>
                            <?php } ?> 
                        <?php } ?> 
                    </tbody>
                </table>  <!-- /.table-responsive -->
            </div>
        </div>
    </div>
</div>
