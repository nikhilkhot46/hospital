<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-bd">

            <div class="panel-heading no-print row">
                <div class="btn-group col-xs-4"> 
                    <button onclick="printContent('printMe')" type="button" class="btn btn-danger"><i class="fa fa-print"></i> <?php echo display("print") ?></button>
                </div>
                <h2 class="col-xs-8 text-left text-success"><?php echo display('bill_details') ?></h2>
            </div>  

            <div class="panel-body" id="printMe">
                <div class="row">
                    <div class="col-xs-6 logo_bar">
                        <img src="<?php echo base_url("$website->logo") ?>" class="img-responsive" alt=""></br>
                        <?php echo display('phone') ?>: <?php echo $website->phone; ?></br>
                        <?php echo display('email') ?>: <?php echo $website->email; ?>
                        <br>
                    </div>
                    <div class="col-xs-6 address_bar">
                        <div class="address_inner">
                            <address>
                                <strong><?php echo display('address') ?></strong><br>
                                <strong><?php echo $website->title; ?></strong><br>
                                <?php echo $website->description; ?>
                            </address>
                        </div>
                    </div>
                </div> <hr>
                <!-- Patient Info -->
                <div class="row patient_info">
                    <table class="info">
                        <tbody>
                            <tr>
                                <td><?php echo display('Appointment_id'); ?>:</td>
                                <td><?php echo $apid; ?></td>
                                <td><?php echo display('bill_date'); ?>:</td>
                                <td><?php echo $bill->bill_date; ?></td>
                            </tr>
                            <tr>
                                <td><?php echo display('patient_id'); ?>:</td>
                                <td><?php echo $bill->patient_id; ?></td>
                                <td><?php echo display('date_of_birth'); ?>:</td>
                                <td><?php echo $bill->date_of_birth; ?></td>
                            </tr>
                            <tr>
                                <td><?php echo display('patient_name'); ?>:</td>
                                <td><?php echo $bill->patient_name; ?></td>
                                <td><?php echo display('sex'); ?>:</td>
                                <td><?php echo $bill->sex ?></td>
                            </tr>
                            <tr>
                                <td><?php echo display('address'); ?>:</td>
                                <td><?php echo $bill->address; ?></td>
                                <td><?php echo display('doctor_name'); ?>:</td>
                                <td><?php echo $bill->doctor_name; ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- Patient Package -->
                
                <?php
                $CI =& get_instance();
                $presc = $this->db->select('*')->from('pr_prescription')->where('status', 0)->where('appointment_id', $apid)->get()->row();
                $visiting_fees = $presc->visiting_fees;
                $bdcharge = 0;
                echo $result = "<div class='alert bg-primary'><div class='text-center'>" . display('visiting_fees') . " : " . $visiting_fees . "</div></div>";
                $bdcharge = $bdcharge + number_format((float)$visiting_fees, 2, '.', '');
                $total_charge = number_format((float)($bdcharge), 2, '.', '');;
                ?>

                <!-- Patient Charge -->
                <div class="patient_charge">
                
                    <table class="charge">
                        <thead>
                            <tr>
                                <th><?php echo display('serial'); ?></th>
                                <th><?php echo display('service_name'); ?></th>
                                <th><?php echo display('quantity'); ?></th>
                                <th><?php echo display('rate'); ?></th>
                                <th><?php echo display('subtotal'); ?></th> 
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                        $subtotal = "0.00"; 
                        $sl = 1; 
                        foreach($services as $service)
                        {  
                            $subtotal+=($service->quantity*$service->amount);
                        ?>
                        <tr>
                            <td class="description">
                                <p><?php echo $sl++; ?></p> 
                            </td>
                            <td class="description">
                                <p><?php echo $service->name; ?></p> 
                            </td>
                            <td class="charge">
                                <p><?php echo $service->quantity; ?></p> 
                            </td>
                            <td class="discount">
                                <p><?php echo $service->amount; ?></p> 
                            </td>
                            <td class="ballance">
                                <p><?php echo ($service->quantity*$service->amount); ?></p> 
                            </td>
                        </tr>
                        <?php
                        } 
                        ?> 
                        </tbody> 
                    </table>
                </div>
                
                <div class="row">
                    <div class="col-xs-4">
                        
                    </div>
                    <div class="col-xs-4">
                        <table class="payment">
                            <thead>
                                <tr>
                                    <th><?php echo display('payment_method'); ?></th>
                                    <th><?php echo $bill->payment_method ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?php echo display('card_cheque_no'); ?></td>
                                    <td><?php echo $bill->card_cheque_no ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo display('receipt_no'); ?></td>
                                    <td><?php echo $bill->receipt_no ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-xs-4">
                        <table class="payment">
                            <thead>
                                <tr>
                                    <td><?php echo display('total'); ?></td>
                                    <?php $subtotal = $subtotal + $total_charge;?>
                                    <th><?php echo  @sprintf("%.2f", (isset($subtotal)?$subtotal:"0.00")) ?></th>
                                </tr>
                            </thead>
                            <tbody> 
                                <tr> 
                                    <td><?php echo display('discount'); ?> (<?php echo  @sprintf("%.2f", (($bill->discount/$subtotal)*100)) ?>%)</td>
                                    <td><?php echo  @sprintf("%.2f", $bill->discount) ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo display('tax'); ?> (<?php echo  @sprintf("%.2f", (($bill->tax/$subtotal)*100)) ?>%)</td>
                                    <td><?php echo  @sprintf("%.2f", $bill->tax) ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo display('pay_advance'); ?></td>
                                    <td><?php echo  @sprintf("%.2f", (isset($pay_advance)?$pay_advance:"0.00")) ?></td>
                                </tr> 
                            </tbody>
                            <thead>
                                <tr>
                                    <td><?php echo display('payable'); ?></td>
                                    <th><?php echo  @sprintf("%.2f", ($subtotal-$bill->discount+$bill->tax-$pay_advance),2) ?></th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <div class="my_sign">
                    <span>___________________________</span>
                    <p><?php echo display('signature'); ?></p>
                </div>
            </div> 
        </div>
    </div>
</div>
