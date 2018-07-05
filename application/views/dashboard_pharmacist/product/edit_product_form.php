<script src="<?php echo base_url()?>my-assets/js/admin_js/json/product.js" type="text/javascript"></script>

        <?php
            $message = $this->session->userdata('message');
            if (isset($message)) {
        ?>
        <div class="alert alert-info alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <?php echo $message ?>                    
        </div>
        <?php 
            $this->session->unset_userdata('message');
            }
            $error_message = $this->session->userdata('error_message');
            if (isset($error_message)) {
        ?>
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <?php echo $error_message ?>                    
        </div>
        <?php 
            $this->session->unset_userdata('error_message');
            }
        ?>
        <!-- Purchase report -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('product_edit') ?> </h4>
                        </div>
                    </div>
                    <?php echo form_open_multipart('dashboard_pharmacist/hospital_activities/Cproduct/product_update',array('class' => 'form-vertical', 'id' => 'product_update','name' => 'product_update'))?>
                 <div class="panel-body">
                    <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="product_name" class="col-sm-4 col-form-label"><?php echo display('product_name') ?> <i class="text-danger">*</i></label>
                                    <div class="col-sm-8">
                                        <input class="form-control" name="product_name" type="text" id="product_name" placeholder="<?php echo display('product_name') ?>" value="<?= $product_name?>" required="">

                                        <input type="hidden" name="product_id" value="<?= $product_id ?>"/>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                               <div class="form-group row">
                                    <label for="generic_name" class="col-sm-4 col-form-label"><?php echo display('generic_name') ?> </label>
                                    <div class="col-sm-8">
                                         <input class="form-control" name="generic_name" type="text" id="generic_name" placeholder="<?php echo display('generic_name') ?>" value="<?= $generic_name ?>">
                                    </div>
                                </div> 
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="box_size" class="col-sm-4 col-form-label"><?php echo display('box_size') ?></label>
                                    <div class="col-sm-8">
                                        <input class="form-control" name="box_size" type="text" id="box_size" placeholder="<?php echo display('box_size') ?>" value="<?= $box_size ?>" min="0">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="unit" class="col-sm-4 col-form-label"><?php echo display('unit') ?> </label>
                                    <div class="col-sm-8">
                                        <select class="form-control" id="unit" name="unit">
                                            <option value=""><?php echo display('select_one') ?></option>
                                            <option value="m" <?php if($unit=='m'){
                                                echo 'selected';
                                            } ?>><?php echo display('meter_m') ?></option>
                                            <option value="Box" <?php if($unit=='Box'){
                                                echo 'selected';
                                            } ?>><?php echo display('box') ?></option>
                                            <option value="pc" <?php if($unit=='pc'){
                                                echo 'selected';
                                            } ?>><?php echo display('piece_pc') ?></option>
                                             <option value="Mg" <?php if($unit=='Mg'){
                                                echo 'selected';
                                            } ?>><?php echo display('Mg') ?></option>
                                             <option value="ml" <?php if($unit=='ml'){
                                                echo 'selected';
                                            } ?>><?php echo display('ml') ?></option>
                                             <option value="Gm" <?php if($unit=='Gm'){
                                                echo 'selected';
                                            } ?>><?php echo display('gram') ?></option>
                                              <option value="kg" <?php if($unit=='kg'){
                                                echo 'selected';
                                            } ?>><?php echo display('kilogram_kg') ?></option>
                                            
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                           <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="product_location" class="col-sm-4 col-form-label"><?php echo display('product_location') ?></label>
                                    <div class="col-sm-8">
                                        <input class="form-control" name="product_location" type="text" id="product_location" placeholder="<?php echo display('product_location') ?>" value="<?= $product_location?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                               <div class="form-group row">
                                    <label for="description" class="col-sm-4 col-form-label"><?php echo display('details') ?></label>
                                    <div class="col-sm-8">
                                        <textarea class="form-control" name="description" id="description" rows="3" ><?= $product_details ?></textarea>
                                    </div>
                                </div> 
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                               <div class="form-group row">
                                    <label for="description" class="col-sm-4 col-form-label"><?php echo display('category') ?></label>
                                    <div class="col-sm-8">
                                        <select name="category_id" class="form-control">
                                            
                                            <?php
                                                foreach ($category_list as $category) {
                                            ?>
                                                <option <?php if ($category['category_id'] == $category_selected) {echo "selected"; }?> value="<?= $category['category_id'] ?>"><?= $category['category_name'] ?></option>
                                            
                                            <?php
                                                }
                                            if (!$category_selected) {   
                                            ?>
                                           <option selected value="0"><?php echo display('category_not_selected')?></option>
                                            <?php
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div> 
                            </div>
                            <div class="col-sm-6">
                               <div class="form-group row">
                                    <label for="description" class="col-sm-4 col-form-label"><?php echo display('image') ?></label>
                                    <div class="col-sm-8">
                                        <input type="file" name="image" class="form-control" tabindex="4">
                                         <img class="img img-responsive text-center" src="<?= $image ?>" height="80" width="80" style="padding: 5px;">
                                         <input type="hidden" value="<?= $image ?>" name="old_image">
                                    </div>
                                </div> 
                            </div>
                        </div>
                        <div class="row">
                             <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="product_model" class="col-sm-4 col-form-label"><?php echo display('model') ?> <i class="text-danger">*</i></label>
                                    <div class="col-sm-8">
                                         <input type="text" tabindex="" class="form-control" name="model" placeholder="<?php echo display('model') ?>"  required  value="<?= $product_model?>"/>
                                    </div>
                                </div>
                            </div>
                             <div class="col-sm-6">
                               <div class="form-group row">
                                    <label for="image" class="col-sm-4 col-form-label"><?php echo display('sell_price') ?> <i class="text-danger">*</i> </label>
                                    <div class="col-sm-8">
                                         <input class="form-control text-right" name="price" type="text" required="" placeholder="0.00" tabindex="5" min="0" value="<?= $price?>">
                                    </div>
                                </div> 
                            </div>
                        </div>
                        <div class="row">
                            
                        </div>
                        <div class="row">
                           
                            
                             <div class="col-sm-6">
                               <div class="form-group row">
                                    <label for="image" class="col-sm-4 col-form-label"><?php echo display('tax') ?> </label>
                                    <div class="col-sm-8">
                                        
                                       <select name="tax" class="form-control dont-select-me" required="" tabindex="8">
                                                  <option>Select Tax</option>
                                                <?php foreach ($tax_list as $batch) {?>
                                                <option value="<?php echo $batch->tax; ?>" <?php if ($batch->tax == $tax_selecete) {echo "selected"; }?>><?php echo $batch->tax; ?>%</option>
                                                <?php }?>
                                               

                                            </select>
                                 
                                    </div>
                                </div> 
                            </div>
                        </div> 

                        <div class="table-responsive" style="margin-top: 10px">
                            <table class="table table-bordered table-hover"  id="product_table">
                                <thead>
                                    <tr>
                                        <th class="text-center"><?php echo display('supplier') ?> <i class="text-danger">*</i></th>
                                        <th class="text-center"><?php echo display('supplier_price') ?> <i class="text-danger">*</i></th>
                                       
                                        
                                         <th class="text-center"><?php echo display('action') ?> <i class="text-danger"></i></th>
                                    </tr>
                                </thead>
                                <tbody id="proudt_item">
                                <?php 
                                    foreach ($supplier_product_data as $supplier_product_data) {
                                ?>
                                    
                                    <tr class="">
                                       
                                        <td>
                                            <select name="supplier_id[]" class="form-control dont-select-me" required="" tabindex="8">
                                                
                                                <?php foreach ($supplier_list as  $supplier) {
                                                ?>
                                                    <option <?php if ($supplier->supplier_id == $supplier_selected) {echo "selected"; }?> value="<?php echo $supplier->supplier_id?>"><?php echo $supplier->supplier_name ?> </option>
                                                <?php }?>
                                                <?php
                                                    if (!$supplier_selected) {
                                                ?>
                                                <option selected value="0"><?php echo display('supplier_not_selected')?></option>
                                                <?php
                                                    }
                                                ?>
                                            </select>
                                           <!--  <input type="text" name="supplier_id" value="{supplier_name}"> -->
                                        </td>
                                        <td class="">
                                            <input type="text" tabindex="6" class="form-control text-right" name="supplier_price[]" placeholder="0.00"  required  min="0" value="<?= $supplier_product_data['supplier_price'] ?>"/>
                                        </td>
                                                  
                                        <td> <button type="button" id="add_purchase_item" class="btn btn-info" name="add-invoice-item" onClick="addpruduct('proudt_item');"  tabindex="9"/><i class="fa fa-plus-square" aria-hidden="true"></i></button> <button class="btn btn-danger red" type="button" value="<?php echo display('delete')?>" onclick="deleteRow(this)" tabindex="10"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                        </td>
                                    </tr>
                                    <?php 
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                             <div class="col-sm-12">
                                 <center><label for="description" class="col-form-label"><?php echo display('product_details') ?></label></center>
                                        <textarea class="form-control" name="description" id="description" rows="3" placeholder="<?php echo display('product_details') ?>" tabindex="2"><?= $product_details?></textarea>
                                    </div>
                        </div><br>
                        <div class="form-group row">
                            <div class="col-sm-6">

                                <input type="submit" id="add-product" class="btn btn-primary btn-large" name="add-product" value="<?php echo display('save_changes') ?>" tabindex="10"/>
                                
                            </div>
                        </div>
                    </div>
                    <?php echo form_close()?>
                </div>
            </div>
        </div>