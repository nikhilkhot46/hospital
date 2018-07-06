<div class="row">
    <!--  table area -->
    <div class="col-sm-12">
        <div class="panel panel-default thumbnail">

            <div class="panel-heading">
                <div class="btn-group">
                    <a class="btn btn-success" href="<?php echo base_url("lab_manager/test/form") ?>"> <i class="fa fa-plus"></i>  <?php echo display('add_test') ?> </a>  
                </div>
            </div>

            <div class="panel-body">
                <table class="datatable table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th><?php echo display('serial') ?></th>
                            <th><?php echo display('test_name') ?></th>
                            <th><?php echo display('test_short_name') ?></th>
                            <th><?php echo display('test_description') ?></th>
                            <th><?php echo display('test_price') ?></th>
                            <th><?php echo display('status') ?></th>
                            <th><?php echo display('action') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($tests)) { ?>
                            <?php $sl = 1; ?>
                            <?php foreach ($tests as $tests) { ?>
                                <tr class="<?php echo ($sl & 1)?"odd gradeX":"even gradeC" ?>">
                                    <td><?php echo $sl; ?></td>
                                    <td><?php echo $tests->test_name; ?></td>
                                    <td><?php echo $tests->test_short_name; ?></td>
                                    <td><?php echo character_limiter($tests->test_description, 60); ?></td>
                                    <td><?php echo number_format($tests->test_price,2); ?></td>
                                    <td><?php echo (($tests->status==1)?display('active'):display('inactive')); ?></td>
                                    <td class="center">
                                        <a href="<?php echo base_url("lab_manager/test/form/$tests->test_id") ?>" class="btn btn-xs  btn-primary"><i class="fa fa-edit"></i></a> 
                                        <!-- <a href="<?php echo base_url("lab_manager/test/delete/$tests->test_id") ?>" onclick="return confirm('<?php echo display("are_you_sure") ?>')" class="btn btn-xs  btn-danger"><i class="fa fa-trash"></i></a>  -->
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
