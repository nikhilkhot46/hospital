<div class="row">
    <div class="col-sm-12">
        <div  class="panel panel-default">
            <div class="panel-body">

                <form class="form-inline" action="<?php echo base_url('dashboard_doctor/appointment/report/assign_to_me') ?>">

                    <div class="form-group">
                        <label class="sr-only" for="start_date"><?php echo display('start_date') ?></label>
                        <input type="text" name="start_date" class="form-control datepicker" id="start_date" placeholder="<?php echo display('start_date') ?>" value="<?php echo $user->start_date ?>">
                    </div>  
                    <div class="form-group">
                        <label class="sr-only" for="end_date"><?php echo display('end_date') ?></label>
                        <input type="text" name="end_date" class="form-control datepicker" id="end_date" placeholder="<?php echo display('end_date') ?>" value="<?php echo $user->end_date ?>">
                    </div>  

                    <button type="submit" class="btn btn-success"><?php echo display('filter') ?></button>

                </form>

            </div>
        </div>
    </div>


    <!--  table area -->
    <div class="col-sm-12">
        <div  class="panel panel-default">
            <div class="panel-body">
                <table width="100%" class="datatable table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th><?php echo display('serial') ?></th>
                            <th><?php echo display('appointment_id') ?></th>
                            <th><?php echo display('patient_id') ?></th>
                            <th><?php echo display('department') ?></th>
                            <th><?php echo display('serial_no') ?></th>
                            <th><?php echo display('problem') ?></th>
                            <th><?php echo display('date') ?></th>
                            <th><?php echo display('food_allergies') ?></th>
                            <th><?php echo display('tendency_bleed') ?></th>
                            <th><?php echo display('heart_disease') ?></th>
                            <th><?php echo display('high_blood_pressure') ?></th>
                            <th><?php echo display('diabetic') ?></th>
                            <th><?php echo display('surgery') ?></th>
                            <th><?php echo display('accident') ?></th>
                            <th><?php echo display('others') ?></th>
                            <th><?php echo display('family_medical_history') ?></th>
                            <th><?php echo display('current_medication') ?></th>
                            <th><?php echo display('female_pregnancy') ?></th>
                            <th><?php echo display('breast_feeding') ?></th>
                            <th><?php echo display('health_insurance') ?></th>
                            <th><?php echo display('low_income') ?></th>
                            <th><?php echo display('reference') ?></th>
                            <th><?php echo display('status') ?></th> 
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($appointments)) { ?>
                            <?php $sl = 1; ?>
                            <?php foreach ($appointments as $appointment) { ?>
                                <tr class="<?php echo ($sl & 1)?"odd gradeX":"even gradeC" ?>">
                                    <td><?php echo $sl; ?></td>
                                    <td><?php echo $appointment->appointment_id; ?></td>
                                    <td><?php echo $appointment->patient_id; ?></td>
                                    <td><?php echo $appointment->name; ?></td>
                                    <td><?php echo $appointment->serial_no; ?></td>
                                    <td><?php echo $appointment->problem; ?></td>
                                    <td><?php echo $appointment->date; ?></td>
                                    <?php 
                                    $CI =& get_instance();
                                    $CI->load->model('dashboard_doctor/prescription/case_study_model');
                                    $data = $CI->case_study_model->read_by_patient_id($appointment->patient_id);
                                    ?>
                                    <td><?php echo !empty($data->food_allergies)?$data->food_allergies:""; ?></td>
                                    <td><?php echo !empty($data->tendency_bleed)?$data->tendency_bleed:""; ?></td>
                                    <td><?php echo !empty($data->heart_disease)?$data->heart_disease:""; ?></td>
                                    <td><?php echo !empty($data->high_blood_pressure)?$data->high_blood_pressure:""; ?></td>
                                    <td><?php echo !empty($data->diabetic)?$data->diabetic:""; ?></td>
                                    <td><?php echo !empty($data->surgery)?$data->surgery:""; ?></td>
                                    <td><?php echo !empty($data->accident)?$data->accident:""; ?></td>
                                    <td><?php echo !empty($data->others)?$data->others:""; ?></td>
                                    <td><?php echo !empty($data->family_medical_history)?$data->family_medical_history:""; ?></td>
                                    <td><?php echo !empty($data->current_medication)?$data->current_medication:""; ?></td>
                                    <td><?php echo !empty($data->female_pregnancy)?$data->female_pregnancy:""; ?></td>
                                    <td><?php echo !empty($data->breast_feeding)?$data->breast_feeding:""; ?></td>
                                    <td><?php echo !empty($data->health_insurance)?$data->health_insurance:""; ?></td>
                                    <td><?php echo !empty($data->low_income)?$data->low_income:""; ?></td>
                                    <td><?php echo !empty($data->reference)?$data->reference:""; ?></td>
                                    <td><?php echo (($appointment->status==1)?display('active'):display('inactive')); ?></td>
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