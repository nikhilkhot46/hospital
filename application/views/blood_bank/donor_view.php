<div class="row">
    <!--  table area -->
    <div class="col-sm-12">
        <div class="panel panel-default thumbnail">

            <div class="panel-heading">
                <div class="btn-group">
                    <a class="btn btn-success" href="<?php echo base_url("blood_bank/blood/blood_doners") ?>"> <i class="fa fa-plus"></i>  <?php echo display('add_doner') ?> </a>  
                </div>
            </div>

            <div class="panel-body">
                <table class="datatable table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th><?php echo display('serial') ?></th>
                            <th><?php echo display('donor_id') ?></th>
                            <th><?php echo display('donar_name') ?></th>
                            <th><?php echo display('blood_group') ?></th>
                            <th><?php echo display('email') ?></th>
                            <th><?php echo display('mobile') ?></th>
                            <th><?php echo display('action') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($donor_list)) { ?>
                            <?php $sl = 1; ?>
                            <?php foreach ($donor_list as $donor) { ?>
                                <tr class="<?php echo ($sl & 1)?"odd gradeX":"even gradeC" ?>">
                                    <td><?php echo $sl; ?></td>
                                    <td><?php echo $donor->donor_id; ?></td>
                                    <td><?php echo $donor->donar_name ?></td>
                                    <td><?php echo $donor->blood_type; ?></td>
                                    <td><?php echo $donor->email ?></td>
                                    <td><?php echo $donor->mobile ?></td>
                                    <td class="center">
                                        <a href="<?php echo base_url("blood_bank/blood/blood_doners/$donor->donor_id") ?>" class="btn btn-xs  btn-primary"><i class="fa fa-edit"></i></a> 
                                        <!-- <a href="<?php echo base_url("bed_manager/bed/delete/$donor->donor_id") ?>" onclick="return confirm('<?php echo display("are_you_sure") ?>')" class="btn btn-xs  btn-danger"><i class="fa fa-trash"></i></a>  -->
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
