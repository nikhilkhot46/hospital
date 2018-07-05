<div class="row">
    <!--  table area -->
    <div class="col-sm-12">
        <div class="panel panel-default thumbnail">

            <div class="panel-heading">
                <div class="btn-group">
                    <a class="btn btn-success" href="<?php echo base_url("purchase_manager/item/add") ?>"> <i class="fa fa-plus"></i>  <?php echo display('add_item') ?> </a>  
                </div>
                <div class="btn-group">
                    <a class="btn btn-success" href="<?php echo base_url("purchase_manager/item/purchase") ?>"> <i class="fa fa-plus"></i>  <?php echo display('add_purchase') ?> </a>  
                </div>
                <div class="btn-group">
                    <a class="btn btn-success" href="<?php echo base_url("purchase_manager/item/manage_purchase") ?>"> <i class="fa fa-plus"></i>  <?php echo display('manage_purchase') ?> </a>  
                </div>
            </div>

            <div class="panel-body">
                <table class="datatable table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th><?php echo display('serial') ?></th>
                            <th><?php echo display('item_id') ?></th>
                            <th><?php echo display('item_name') ?></th>
                            <th><?php echo display('description') ?></th>
                            <th><?php echo display('action') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($items)) { ?>
                            <?php $sl = 1; ?>
                            <?php foreach ($items as $item) { ?>
                                <tr class="<?php echo ($sl & 1)?"odd gradeX":"even gradeC" ?>">
                                    <td><?php echo $sl; ?></td>
                                    <td><?php echo $item->item_id; ?></td>
                                    <td><?php echo $item->item_name; ?></td>
                                    <td><?php echo character_limiter($item->item_desc, 60); ?></td>
                                    <td class="center">
                                        <a href="<?php echo base_url("purchase_manager/item/add/$item->item_id") ?>" class="btn btn-xs  btn-primary"><i class="fa fa-edit"></i></a> 
                                        <!-- <a href="<?php echo base_url("purchase_manager/item/delete/$item->item_id") ?>" onclick="return confirm('<?php echo display("are_you_sure") ?>')" class="btn btn-xs  btn-danger"><i class="fa fa-trash"></i></a>  -->
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
