
<script src="<?php echo base_url()?>my-assets/js/admin_js/json/product.js" type="text/javascript"></script>
<!-- Add Product Start -->
        <!-- Alert Message -->
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

        <div class="row">
            <div class="col-sm-12">
                
                  <a href="<?php echo base_url('dashboard_pharmacist/hospital_activities/Cproduct/add_product_csv')?>" class="btn btn-info m-b-5 m-r-2"><i class="ti-plus"> </i> <?php echo display('add_product_csv')?> </a>

                  <a href="<?php echo base_url('dashboard_pharmacist/hospital_activities/Cproduct/manage_product')?>" class="btn btn-primary m-b-5 m-r-2"><i class="ti-align-justify"> </i>  <?php echo display('manage_product')?> </a>

            </div>
        </div>

        <!-- Add Product -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('new_product') ?></h4>
                        </div>
                    </div>
                    <?php echo form_open_multipart('dashboard_pharmacist/hospital_activities/Cproduct/insert_product',array('class' => 'form-vertical', 'id' => 'insert_product','name' => 'insert_product'))?>
                    <div class="panel-body">
                           <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="product_name" class="col-sm-4 col-form-label"><?php echo display('product_name') ?> <i class="text-danger">*</i></label>
                                    <div class="col-sm-8">
                                        <input class="form-control" name="product_name" type="text" id="product_name" placeholder="<?php echo display('product_name') ?>" required="">
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                               <div class="form-group row">
                                    <label for="generic_name" class="col-sm-4 col-form-label"><?php echo display('generic_name') ?> </label>
                                    <div class="col-sm-8">
                                        <input class="form-control" name="generic_name" type="text" id="generic_name" placeholder="<?php echo display('generic_name') ?>">
                                    </div>
                                </div> 
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="box_size" class="col-sm-4 col-form-label"><?php echo display('box_size') ?></label>
                                    <div class="col-sm-8">
                                        <input class="form-control" name="box_size" type="text" id="box_size" placeholder="<?php echo display('box_size') ?>" min="0">
                                    </div>
                                </div>
                            </div>
                           <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="unit" class="col-sm-4 col-form-label"><?php echo display('unit') ?> </label>
                                    <div class="col-sm-8">
                                        <select class="form-control" id="unit" name="unit">
                                            <option value=""><?php echo display('select_one') ?></option>
                                            <option value="m"><?php echo display('meter_m') ?></option>
                                            <option value="Box"><?php echo display('box') ?></option>
                                            <option value="pc"><?php echo display('piece_pc') ?></option>
                                             <option value="Mg"><?php echo display('Mg') ?></option>
                                             <option value="ml"><?php echo display('ml') ?></option>
                                             <option value="Gm"><?php echo display('gram') ?></option>
                                              <option value="kg"><?php echo display('kilogram_kg') ?></option>
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
                                        <input class="form-control" name="product_location" type="text" id="product_location" placeholder="<?php echo display('product_location') ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                               <div class="form-group row">
                                    <label for="description" class="col-sm-4 col-form-label"><?php echo display('details') ?></label>
                                    <div class="col-sm-8">
                                        <textarea class="form-control" name="description" id="description" rows="3" placeholder="<?php echo display('details') ?>"></textarea>
                                    </div>
                                </div> 
                            </div>
                        </div>
                        <div class="row"><div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="product_model" class="col-sm-4 col-form-label"><?php echo display('model') ?> <i class="text-danger">*</i></label>
                                    <div class="col-sm-8">
                                         <input type="text" tabindex="" class="form-control" name="model" placeholder="<?php echo display('model') ?>"  required />
                                    </div>
                                </div>
                            </div><div class="col-sm-6">
                               <div class="form-group row">
                                    <label for="image" class="col-sm-4 col-form-label"><?php echo display('sell_price') ?> <i class="text-danger">*</i> </label>
                                    <div class="col-sm-8">
                                         <input class="form-control text-right" name="price" type="text" required="" placeholder="0.00" tabindex="5" min="0">
                                    </div>
                                </div> 
                            </div></div>


                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="category_id" class="col-sm-4 col-form-label"><?php echo display('category') ?></label>
                                    <div class="col-sm-8">
                                        <select class="form-control" id="category_id" name="category_id">
                                        <option value=""><?php echo display('select_one') ?></option>
                                        <?php
                                            if ($category_list) {
                                                foreach ($category_list as $cat) {
                                        ?>
                                            <option value="<?= $cat['category_id'] ?>"><?= $cat['category_name'] ?></option>
                                        <?php
                                                }
                                        ?>
                                        <?php
                                            }
                                        ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                               <div class="form-group row">
                                    <label for="image" class="col-sm-4 col-form-label"><?php echo display('image') ?> </label>
                                    <div class="col-sm-8">
                                        <input type="file" name="image" class="form-control" id="image">
                                    </div>
                                </div> 
                            </div>
                        </div>
                        <div class="row">
                           
                            
                             <div class="col-sm-6">
                               <div class="form-group row">
                                    <label for="tax" class="col-sm-4 col-form-label"><?php echo display('tax') ?> </label>
                                    <div class="col-sm-8">
                                       <select name="tax" class="form-control" tabindex="8">
                                                <option><?php echo display('select_one')?></option>
                                            <?php if ($tax_list){ 
                                                foreach ($tax_list as $tax) {
                                                   ?>
                                                   <option value="<?php echo $tax->tax ?>"><?php echo $tax->tax ?>%</option>
                                                   <?php
                                                }
                                                ?>
                                                
                                           
                                            <?php } ?>
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
                                    <tr class="">
                                       
                                        <td>

                                            <select name="supplier_id[]" class="form-control dont-select-me" required="" tabindex="8">
                                                <option value=""> Select Supplier</option>
                                            <?php if ($supplier){ 
                                                
                                                foreach ($supplier as $sup) {
                                                    ?>
                                                    <option value="<?php echo $sup->supplier_id ?>"><?php echo $sup->supplier_name ?></option>
                                                    <?php
                                                 }
                                                 ?>
                                            <?php } ?>
                                            </select>
                                        </td>
                                        <td class="">
                                            <input type="text" tabindex="6" class="form-control text-right" name="supplier_price[]" placeholder="0.00"  required  min="0"/>
                                        </td>
                                
                                        <td> <button type="button" id="add_purchase_item" class="btn btn-info" name="add-invoice-item" onClick="addpruduct('proudt_item');"  tabindex="9"/><i class="fa fa-plus-square" aria-hidden="true"></i></button> <button class="btn btn-danger red" type="button" value="<?php echo display('delete')?>" onclick="deleteRow(this)" tabindex="10"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <input type="submit" id="add-product" class="btn btn-primary btn-large" name="add-product" value="<?php echo display('save') ?>" tabindex="10"/>
                            </div>
                        </div>
                    </div>
                    <?php echo form_close()?>
                </div>
            </div>
        </div>
<!-- Add Product End -->



