<div class="row">
    <!--  table area -->
    <div class="col-sm-12">
        <div class="panel panel-default thumbnail">

            <div class="panel-heading">
                <div class="btn-group">
                    <a class="btn btn-success" href="<?php echo base_url("blood_bank/blood/sell_blood") ?>"> <i class="fa fa-plus"></i>  <?php echo display('sell_blood') ?> </a>  
                </div>
            </div>

            <div class="panel-body">
                <table class="datatable table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th><?php echo display('serial') ?></th>
                            <th><?php echo display('sell_id') ?></th>
                            <th><?php echo display('patient_id') ?></th>
                            <th><?php echo display('blood_group') ?></th>
                            <th><?php echo display('quantity') ?></th>
                            <th><?php echo display('charge') ?></th>
                            <th><?php echo display('action') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($sell)) { ?>
                            <?php $sl = 1; ?>
                            <?php foreach ($sell as $sell) { ?>
                                <tr class="<?php echo ($sl & 1)?"odd gradeX":"even gradeC" ?>">
                                    <td><?php echo $sl; ?></td>
                                    <td><?php echo $sell->sell_id; ?></td>
                                    <td><?php echo $sell->patient_id ?></td>
                                    <td><?php echo $this->config->item('blood_group')[$sell->blood_type]; ?></td>
                                    <td><?php echo $sell->qty ?></td>
                                    <td><?php echo $sell->charge ?></td>
                                    <td class="center">
                                        <a href="<?php echo base_url("blood_bank/blood/sell_blood/$sell->sell_id") ?>" class="btn btn-xs  btn-primary"><i class="fa fa-edit"></i></a> 
                                        <!-- <a href="<?php echo base_url("bed_manager/bed/delete/$sell->sell_id") ?>" onclick="return confirm('<?php echo display("are_you_sure") ?>')" class="btn btn-xs  btn-danger"><i class="fa fa-trash"></i></a>  -->
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
