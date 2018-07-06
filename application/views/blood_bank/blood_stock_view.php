<div class="row">
    <!--  table area -->
    <div class="col-sm-12">
        <div class="panel panel-default thumbnail">

            <div class="panel-heading">
                <div class="btn-group">
                    <a class="btn btn-success" href="<?php echo base_url("blood_bank/blood/form") ?>"> <i class="fa fa-plus"></i>  <?php echo display('purchase_blood') ?> </a>  
                </div>
            </div>

            <div class="panel-body">
                <table class="datatable table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th><?php echo display('serial') ?></th>
                            <th><?php echo display('blood_group') ?></th>
                            <th><?php echo display('quantity') ?></th>
                            <th><?php echo display('remaining') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($blood)) { ?>
                            <?php $sl = 1; ?>
                            <?php foreach ($blood as $blood) { ?>
                                <tr class="<?php echo ($sl & 1)?"odd gradeX":"even gradeC" ?>">
                                    <td><?php echo $sl; ?></td>
                                    <td><?php echo $this->config->item('blood_group')[$blood->blood_type]; ?></td>
                                    <td><?php echo $blood->qty ?></td>
                                    <td><?php echo $blood->remaining; ?></td>
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
