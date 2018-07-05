<div class="row">
    <!--  table area -->
    <div class="col-sm-12">
        <div class="panel panel-default thumbnail">

            <div class="panel-heading">
                <div class="btn-group">
                    <a class="btn btn-success" href="<?php echo base_url("blood_bank/blood/add_wastage") ?>"> <i class="fa fa-plus"></i>  <?php echo display('add_wastage') ?> </a>  
                </div>
            </div>

            <div class="panel-body">
                <table class="datatable table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th><?php echo display('serial') ?></th>
                            <th><?php echo display('blood_group') ?></th>
                            <th><?php echo display('wastage') ?></th>
                            <th><?php echo display('action') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($wastage)) { ?>
                            <?php $sl = 1; ?>
                            <?php foreach ($wastage as $waste) { ?>
                                <tr class="<?php echo ($sl & 1)?"odd gradeX":"even gradeC" ?>">
                                    <td><?php echo $sl; ?></td>
                                    <td><?php echo $this->config->item('blood_group')[$waste->blood_type] ?></td>
                                    <td><?php echo $waste->qty; ?></td>
                                    <td class="center">
                                        <a href="<?php echo base_url("blood_bank/blood/wastage_report/$waste->blood_type") ?>" class="btn btn-xs btn-primary"><i class="fa fa-eye"></i></a>
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
