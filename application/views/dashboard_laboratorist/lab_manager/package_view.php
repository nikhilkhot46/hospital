<div class="row">
    <!--  table area -->
    <div class="col-sm-12">
        <div class="panel panel-default thumbnail">

            <div class="panel-heading">
                <div class="btn-group">
                    <a class="btn btn-success" href="<?php echo base_url("dashboard_laboratorist/lab_manager/package/form") ?>"> <i class="fa fa-plus"></i>  <?php echo display('add_package') ?> </a>  
                </div>
            </div>

            <div class="panel-body">
                <table class="datatable table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th><?php echo display('serial') ?></th>
                            <th><?php echo display('package_name') ?></th>
                            <th><?php echo display('description') ?></th>
                            <th><?php echo display('tests') ?></th>
                            <th><?php echo display('actual_price') ?></th>
                            <th><?php echo display('discount') ?></th>
                            <th><?php echo display('final_price') ?></th>
                            <th><?php echo display('status') ?></th>
                            <th><?php echo display('action') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($package)) { ?>
                            <?php $sl = 1; ?>
                            <?php foreach ($package as $pack) { ?>
                                <tr class="<?php echo ($sl & 1)?"odd gradeX":"even gradeC" ?>">
                                    <td><?php echo $sl; ?></td>
                                    <td><?php echo $pack->package_name; ?></td>
                                    <td><?php echo character_limiter($pack->package_description, 60); ?></td>
                                    <td>
                                        <?php
                                        $newarr = [];
                                        foreach ($tests_data as $td) {
                                            $newarr[$td->test_id] = $td->test_name;
                                        }
                                        $tests = explode(",",$pack->package_tests);
                                        $newtest = "";
                                        foreach ($tests as $value) {
                                            $newtest .=  $newarr[$value].",";
                                        } 
                                        echo rtrim($newtest,",");
                                        ?>
                                    </td>
                                    <td><?php echo $pack->actual_price; ?></td>
                                    <td><?php echo $pack->discount; ?>%</td>
                                    <td><?php echo $pack->final_price; ?></td>
                                    <td><?php echo (($pack->status==1)?display('active'):display('inactive')); ?></td>
                                    <td class="center">
                                        <a href="<?php echo base_url("dashboard_laboratorist/lab_manager/package/form/$pack->package_id") ?>" class="btn btn-xs  btn-primary"><i class="fa fa-edit"></i></a> 
                                        <!-- <a href="<?php echo base_url("dashboard_laboratorist/lab_manager/package/delete/$pack->package_id") ?>" onclick="return confirm('<?php echo display("are_you_sure") ?>')" class="btn btn-xs  btn-danger"><i class="fa fa-trash"></i></a>  -->
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
