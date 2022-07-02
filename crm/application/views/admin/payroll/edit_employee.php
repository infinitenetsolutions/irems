<link href="<?=base_url();?>assets/plugins/select2/dist/css/select2.min.css" rel="stylesheet"/>
        <div id="content" class="content">

            <ol class="breadcrumb float-xl-right">
                <li class="breadcrumb-item"><a href="javascript:;">Home</a></li>f
                <li class="breadcrumb-item"><a href="javascript:;">Edit Employee</a></li>
            </ol>


            <h1 class="page-header">Edit Employee</h1>

            <form id="TypeValidation" class="form-horizontal" action="<?php echo base_url();?>Payroll/edit_employee_page/<?php echo $employee_item['id'] ?>" method="post" enctype="multipart/form-data">
                <div class="card card-navy card-outline">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="employeeCategory"><strong>Employee Type:</strong></label>
                                    <select name="employee_type" class="form-control" data-title="Select" data-style="btn-default btn-outline" data-menu-style="dropdown-blue">
                                <option value="Vendor Employee" <?php if(!empty($employee_item) && $employee_item['employee_type']=='Vendor Employee'){echo 'selected';} ?>>Vendor Employee </option>
                                <option value="On Payroll" <?php if(!empty($employee_item) && $employee_item['employee_type']=='On Payroll'){echo 'selected';} ?>>On Payroll  </option>					
                                </select>
                                </div>
                            </div>
                              <div class="col-md-4">
                                <div class="form-group">
                             <label for=""><strong>Store Name:</strong></label>
                                 <select class="form-control" name="emp_store_name" id="emp_store_name" style="" required="">
                                        <option value="" selected="" disabled="">Select Store Name</option>
                                        <?php
                                            foreach ($store as $sRow) { 
                                             echo "<option value=".$sRow['str_id']." ".($employee_item['emp_store_name']==$sRow['str_id']?'selected':'')." >".$sRow['str_name']."</option>";   
                                            }  ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="panel panel-inverse" data-sortable-id="form-plugins-4">

                    <div class="panel-heading">
                        <h4 class="panel-title">Personal Details</h4>
                    </div>
                    <div class="panel-body panel-form">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div id="response" class="form-group">
                                        <label class="control-label"><strong>First Name:</strong></label>
                                        <input class="form-control" type="hidden" value="<?php echo $employee_item['id'] ?>" id="emp_id" required="true">
                                        <input class="form-control" type="text" value="<?php echo $employee_item['first_name'] ?>" name="first_name" id="first_name" required="true">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div id="response" class="form-group">
                                        <label class="control-label"><strong>Last Name:</strong></label>
                                        <input class="form-control" type="text" value="<?php echo $employee_item['last_name'] ?>" name="last_name" id="last_name" required="true">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div id="response" class="form-group">
                                        <label class="control-label"><strong>Employee ID:</strong></label>
                                        <input class="form-control" type="text" value="<?php echo $employee_item['employee_id'] ?>" name="employee_id" id="employee_id" required="true">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div id="response" class="form-group">
                                        <label class="control-label"><strong>Mobile:</strong></label>
                                        <input class="form-control" type="number" value="<?php echo $employee_item['mobile'] ?>" name="mobile" id="mobile" required="true">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label"><strong>Email ID: <span id="empemail_msg"></span></strong></label>
                                            <input class="form-control" type="email" name="other_email" id="other_email" value="<?php echo $employee_item['email'] ?>">
                                        </div>
                                    </div>
                                <div class="col-md-4">
                                    <div id="response" class="form-group">
                                        <label class="control-label"><strong>Date of Birth:</strong></label>
                                        <input type="date" class="form-control" id="date_of_birth" value="<?php echo $employee_item['date_of_birth'] ?>" name="date_of_birth" placeholder="Select Date" required="true">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="empGender"><strong>Gender:</strong></label>
                                       <select name="gender" class="form-control" data-style="btn-default btn-outline" data-menu-style="dropdown-blue">
										<option value="male" <?php if(!empty($employee_item) && $employee_item['gender']=='male'){echo 'selected';} ?>>Male</option>
										<option value ="female" <?php if(!empty($employee_item) && $employee_item['gender']=='female'){echo 'selected';} ?>>Female</option>
										</select>
                                    </div>
                                </div>
                                  <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label"><strong>Employee Account Password: </strong></label>
                                            <input class="form-control" type="password" name="password" id="password" value="<?php echo $employee_item['password'] ?>">
                                        </div>
                                    </div>
                            </div>
                        </div>

                    </div>


                    <div class="panel panel-inverse" data-sortable-id="form-plugins-4">

                        <div class="panel-heading">
                            <h4 class="panel-title">Work Details</h4>

                        </div>
          

                        <div class="panel-body panel-form">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="department"><strong>Department: </strong></label>
                                            <select name="department" id='department' class="form-control" class="selectpicker" data-title="Select" data-style="btn-default btn-outline" data-menu-style="dropdown-blue">

                                                 <option value="">Select Department</option>
                                                <?php
                                               
                                                if(!empty($department))
                                                { 
                                                    foreach($department as $value)
                                                    {
                                                ?>
                                                <option value="<?php echo $value['id']; ?>" <?php echo ($value['id']==$employee_item['department'])?'selected':'';?>><?php echo $value['department_name']; ?></option>
                                                <?php
                                                        }
                                                    }
                                                    else{
                                                        ?>
                                                    <option value="">No Data</option>
                                                 <?php 
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                     <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="designation"><strong>Designation:</strong></label>
                                            <select name="designation" id='designation' class="form-control" data-style="btn-default btn-outline" data-menu-style="dropdown-blue">

                                                 <option value="">Select Designation</option>
                                                <?php
                                               
                                                if(!empty($designation))
                                                { 
                                                    foreach($designation as $value)
                                                    {
                                                ?>
                                                <option value="<?php echo $value['id']; ?>" <?php echo ($value['id']==$employee_item['designation'])?'selected':'';?>><?php echo $value['designation']; ?></option>
                                                <?php
                                                        }
                                                    }
                                                    else{
                                                        ?>
                                                    <option value="">No Data</option>
                                                 <?php 
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label"><strong>Date of Joining:</strong></label>
                                            <input type="date" class="form-control" id="date_of_hire" name="date_of_hire" placeholder="Select Date" value="<?php echo $employee_item['date_of_hire'] ?>">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for=""><strong>Source of Hire:</strong></label>
                                            <input class="form-control" name="source_of_hire" id="source_of_hire" type="text" value="<?php echo $employee_item['source_of_hire'] ?>" >

                                        </div>
                                    </div>
                                      <div class="col-md-4">
                                        <div id="empReportTo" class="form-group">
                                            <label for=""><strong>Reporting To:</strong></label>
                                            <select class="default-select2 form-control" name="reporting_to" id="reporting_to"><option value="">Select Employee</option></select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="empStatus"><strong>Employee Status:</strong></label>
                                            <select name="emp_status" class="form-control"  data-style="btn-default btn-outline" data-menu-style="dropdown-blue">
											<option value="Active" <?php if(!empty($employee_item) && $employee_item['emp_status']=='Active'){echo 'selected';} ?> >Active</option>
											<option value ="Inactive" <?php if(!empty($employee_item) && $employee_item['emp_status']=='Inactive'){echo 'selected';} ?> >Inactive</option>									   
											</select>
										</div>
                                    </div>

                                    <div class="col-md-4">
                                        <div id="empWorkPhone" class="form-group">
                                            <label for=""><strong>Work Phone:</strong></label>
                                            <input class="form-control" name="work_phone_no" id="work_phone_no" type="number" value="<?php echo $employee_item['work_phone_no'] ?>" maxlength="10">

                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="empType"><strong>Employee Type:</strong></label>
                                            <select name="emp_type" class="form-control" data-title="Select" data-style="btn-default btn-outline" data-menu-style="dropdown-blue">
                                                <option value="Full Time" <?php if(!empty($employee_item) && $employee_item['emp_type']=='Full Time'){echo 'selected';} ?> >Full Time</option>
                                                <option value="Part Time" <?php if(!empty($employee_item) && $employee_item['emp_type']=='Part Time'){echo 'selected';} ?> >Part Time</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="panel panel-inverse" data-sortable-id="form-plugins-4">

                        <div class="panel-heading">
                            <h4 class="panel-title">Contact Details</h4>
                        </div>
          
                        <div class="panel-body panel-form">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div id="" class="form-group">
                                            <label class="control-label"><strong>Address 1:</strong></label>
                                            <input class="form-control" type="text" name="address1"  value="<?php echo $employee_item['address1'] ?>" id="address1" required="true">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div id="" class="form-group">
                                            <label class="control-label"><strong>Address 2:</strong></label>
                                            <input class="form-control" type="text" name="address2"  value="<?php echo $employee_item['address2'] ?>" id="address2">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="country"><strong>Country:</strong></label>
                                            <select name="country" class="form-control" data-style="btn-default btn-outline" data-menu-style="dropdown-blue">
												<option value="India" <?php if(!empty($employee_item) && $employee_item['country']=='India'){echo 'selected';} ?> >India</option>
												<option value ="Others" <?php if(!empty($employee_item) && $employee_item['country']=='Others'){echo 'selected';} ?> >Others</option>																 
												</select> 
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="state"><strong>State:</strong></label>
                                            <select name="state" class="form-control" data-title="Select"  data-style="btn-default btn-outline" data-menu-style="dropdown-blue">
                                                <option value="Jharkhand" <?php if(!empty($employee_item) && $employee_item['state']=='Jharkhand'){echo 'selected';} ?>>Jharkhand</option>
                                                <option value="Others" <?php if(!empty($employee_item) && $employee_item['state']=='Others'){echo 'selected';} ?>>Others</option>
                                            </select>

                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="city"><strong>City:</strong></label>
                                            <select name="city" class="form-control" data-title="Select"  data-style="btn-default btn-outline" data-menu-style="dropdown-blue">
                                                <option value="Jamshedpur" <?php if(!empty($employee_item) && $employee_item['city']=='Jamshedpur'){echo 'selected';} ?>>Jamshedpur</option>
                                                <option value="Others" <?php if(!empty($employee_item) && $employee_item['city']=='Others'){echo 'selected';} ?>>Others</option>
                                            </select>

                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label"><strong>Postal Code:</strong></label>
                                            <input class="form-control" type="number" name="postal_code" value="<?php echo $employee_item['postal_code'] ?>" id="postal_code" required="true">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label"><strong>Alternate Mobile No:</strong></label>
                                            <input class="form-control" type="number" name="other_mobile" value="<?php echo $employee_item['other_mobile'] ?>" id="other_mobile">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label"><strong>Driving License:</strong></label>
                                            <input class="form-control" type="text" name="driving_license" value="<?php echo $employee_item['driving_license'] ?>" id="driving_license">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="nationality"><strong>Nationality:</strong></label>
                                            <select name="nationality" class="form-control" data-title="Select" data-style="btn-default btn-outline" data-menu-style="dropdown-blue">
                                                <option value="Indian" <?php if(!empty($employee_item) && $employee_item['nationality']=='Indian'){echo 'selected';} ?>>Indian</option>
                                                <option value="Others" <?php if(!empty($employee_item) && $employee_item['nationality']=='Others'){echo 'selected';} ?>>Others</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="marital_status"><strong>Marital Status:</strong></label>
                                            <select name="marital_status" class="form-control" data-title="Select" data-style="btn-default btn-outline" data-menu-style="dropdown-blue">
                                                <option value="Married" <?php if(!empty($employee_item) && $employee_item['marital_status']=='Married'){echo 'selected';} ?>>Married</option>
                                                <option value="Single" <?php if(!empty($employee_item) && $employee_item['marital_status']=='Single'){echo 'selected';} ?>>Single</option>
                                                <option value="Others" <?php if(!empty($employee_item) && $employee_item['marital_status']=='Others'){echo 'selected';} ?>>Others</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for=""><strong>Hobbies:</strong></label>
                                            <input class="form-control" name="hobbies" id="hobbies" value="<?php echo $employee_item['hobbies'] ?>" type="text">

                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="panel panel-inverse" data-sortable-id="form-plugins-4">
                        <div class="panel-heading">
                            <h4 class="panel-title">Financial Details</h4>
                        </div>
                        <div class="panel-body panel-form">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="basic_salary"><strong>Basic Salary: </strong></label>
                                            <input class="form-control" name="basic_salary" id="basic_salary" type="number" value="<?php echo $employee_item['basic_salary'] ?>"  onkeyup="cal();" required="true">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="fooding_allowance"><strong>Fooding Allowance:</strong></label>
                                            <input class="form-control" name="fooding_allowance" id="fooding_allowance" type="number" value="<?php echo $employee_item['fooding_allowance'] ?>" onkeyup="cal();" required="true">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div id="" class="form-group">
                                            <label for="hra"><strong>House Rent Allowance:</strong></label>
                                            <input class="form-control" name="hra" id="hra" onkeyup="cal();" type="number" value="<?php echo $employee_item['hra'] ?>" required="true">
                                        </div>
                                    </div>
                                     <div class="col-md-4">
                                        <div id="" class="form-group">
                                            <label for="hra"><strong>Mobile Allowance:</strong></label>
                                            <input class="form-control" name="mobile_allowance" id="mobile_allowance" onkeyup="cal();" type="number" value="<?php echo $employee_item['mobile_allowance'] ?>" required="true">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="transbortation_allowance"><strong>Transpotation Allowance:</strong></label>
                                            <input class="form-control" name="transbortation_allowance" id="transbortation_allowance" type="number" value="<?php echo $employee_item['transbortation_allowance'] ?>" onkeyup="cal();" required="true">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="medical_allownce"><strong>Medical Allowance:</strong></label>
                                            <input class="form-control" name="medical_allownce" id="medical_allownce" type="number" value="<?php echo $employee_item['medical_allownce'] ?>" onkeyup="cal();" required="true">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div id="response" class="form-group">
                                            <label for="accomodation"><strong>Accomodation:</strong></label>
                                            <input class="form-control" name="accomodation" id="accomodation" type="number" value="<?php echo $employee_item['accomodation'] ?>" onkeyup="cal();" required="true">
                                        </div>
                                    </div> <div class="col-md-4">
                                        <div class="form-group">
                                            <label for=""><strong>Deduct from:</strong></label>
                                            <select name="cut_from" id="cut_from" class="form-control" data-title="Select" data-style="btn-default btn-outline" data-menu-style="dropdown-blue" onkeyup="cal_pf_amount();" >
                                                <option value="basic_salary" <?php echo ($employee_item['cut_from']=='basic_salary')?'selected':''; ?> >Basic Salary</option>
                                                <option value="total_salary" <?php echo ($employee_item['cut_from']=='total_salary')?'selected':''; ?> >Gross Salary</option>
                                            </select>
                                        </div>
                                    </div>
                                     <div class="col-md-4">
                                        <div id="response" class="form-group">
                                            <label for=""><strong>Employee PF Contribution (in %):</strong></label>
                                        <div class="input-group mb-3">
                                          <input class="form-control" name="pf_emp" id="pf_emp" type="number" step=".001" value="<?php echo $employee_item['pf_emp'] ?>" min="1" max="100" required onkeyup="cal_pf_amount()">
                                           <input class="form-control ml-3" name="pf_emp_amt" id="pf_emp_amt"  readonly="">
                                        </div>
                                        </div>
                                    </div>
                                     <div class="col-md-4">
                                        <div id="response" class="form-group">
                                            <label for=""><strong>Company PF Contribution (in %):</strong></label>
                                            <div class="input-group mb-3">
                                          <input class="form-control" name="pf_cmp" id="pf_cmp" type="number" step=".001" value="<?php echo $employee_item['pf_cmp'] ?>"  onkeyup="cal_pf_amount()" required>
                                        <input class="form-control ml-3" name="pf_cmp_amt" id="pf_cmp_amt"  readonly="">
                                        </div>
                                        </div>
                                    </div>
                                     <div class="col-md-4">
                                        <div id="response" class="form-group">
                                            <label for=""><strong>Employee ESIC Contribution (in %):</strong></label>
                                            <div class="input-group mb-3">
                                          <input class="form-control" name="esic_emp" id="esic_emp" type="number" step=".001" value="<?php echo $employee_item['esic_emp'] ?>" onkeyup="cal_pf_amount()"  required>
                                        <input class="form-control ml-3" name="esic_emp_amt" id="esic_emp_amt" readonly="">
                                        </div>
                                        </div>
                                    </div>
                                     <div class="col-md-4">
                                        <div id="response" class="form-group">
                                            <label for=""><strong>Company ESIC Contribution (in %):</strong></label>
                                            <div class="input-group mb-3">
                                          <input class="form-control" name="esic_cmp" id="esic_cmp" type="number" step=".001" value="<?php echo $employee_item['esic_cmp'] ?>" onkeyup="cal_pf_amount()" required>
                                        <input class="form-control ml-3" name="esic_cmp_amt" id="esic_cmp_amt"  readonly="">
                                        </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div id="response" class="form-group">
                                            <label for="empTotalSalary"><strong>Total Salary:</strong></label>
                                            <input class="form-control" name="total_salary" id="total_salary" onkeyup="cal();" type="text" step=".001" value="<?php echo $employee_item['total_salary'] ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div id="response" class="form-group">
                                            <label for="empTotalSalary"><strong>Net Salary:</strong></label>
                                            <input class="form-control" name="net_salary" id="net_salary" step=".001" type="text" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="panel panel-inverse" data-sortable-id="form-plugins-4">
                        <div class="panel-heading">
                            <h4 class="panel-title">Bank Account Details</h4>
                        </div>
               

                        <div class="panel-body panel-form">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div id="" class="form-group">
                                            <label for="account_holder_name"><strong>Account Holder Name:</strong></label>
                                            <input class="form-control" name="account_holder_name" id="account_holder_name" type="text" value="<?php echo $employee_item['account_holder_name'] ?>" required="true">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div id="" class="form-group">
                                            <label for="bank_name"><strong>Bank Name:</strong></label>
                                            <input class="form-control" name="bank_name" id="bank_name" type="text" value="<?php echo $employee_item['bank_name'] ?>" required="true">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div id="" class="form-group">
                                            <label for="account_no"><strong>Account No:</strong></label>
                                            <input class="form-control" name="account_no" id="account_no" type="text" value="<?php echo $employee_item['account_no'] ?>" required="true">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div id="branch" class="form-group">
                                            <label for=""><strong>Bank Branch:</strong></label>
                                            <input class="form-control" name="branch" id="branch" type="text" value="<?php echo $employee_item['branch'] ?>" >
                                        </div>
                                    </div>
                                     <div class="col-md-4">
                                        <div class="form-group">
                                            <label for=""><strong>PF Account:</strong></label>
                                            <input class="form-control" name="pf_ac" id="pf_ac" type="text" value="<?php echo $employee_item['pf_ac'] ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for=""><strong>ESIC Account:</strong></label>
                                            <input class="form-control" name="esic_ac" id="esic_ac" type="text" value="<?php echo $employee_item['esic_ac'] ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="panel panel-inverse" data-sortable-id="form-plugins-4">
                        <div class="panel-heading">
                            <h4 class="panel-title">Image Upload</h4>
                        </div>

                        <div class="panel-body panel-form">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div id="response" class="form-group">
                                            <label for="image"><strong>Profile Image:</strong></label>
                                            <!--<span class="input-group-addon"><i class="fa fa-edit" aria-hidden="true"></i></span>-->
											<img src="<?php echo base_url();?>upload/employee/<?php echo $employee_item['image']; ?>"  style="width:80px;height:80px;" />
                                             <input class="form-control" name="image" value="<?php echo $employee_item['image'] ?>" id="image" type="file" selected>
                                        </div>
                                    </div>
                                </div><br><br><br>
                                <button type="submit" id="submit" name="submit" class="btn btn-info" style="margin-left:5px;">Save Changes</button>

                            </div>
                        </div>
                    </div>
                </div>

                <div id="billing_form_error_section"></div><br />

        </div>
        </form>

    </div>

    </div>

    <a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>

    </div>
 <?php include($view_path.'admin/include/footer.php')  ?>
<script src="<?=base_url();?>assets/plugins/select2/dist/js/select2.min.js" type="text/javascript"></script>
    <script language=Javascript>
         $(".default-select2").select2();

function cal() {
    var basic_salary = document.getElementById('basic_salary').value;
      var fooding_allowance = document.getElementById('fooding_allowance').value;
      var hra = document.getElementById('hra').value;
      var mobile_allowance = document.getElementById('mobile_allowance').value;
      var transbortation_allowance = document.getElementById('transbortation_allowance').value;
      var medical_allownce = document.getElementById('medical_allownce').value;
      var accomodation = document.getElementById('accomodation').value;
      var result = parseInt(basic_salary) + parseInt(hra) + parseInt(medical_allownce) +  parseInt(fooding_allowance) +  parseInt(transbortation_allowance) +  parseInt(accomodation) +  parseInt(mobile_allowance);
      if (!isNaN(result)) {
         document.getElementById('total_salary').value = result;
      }
}
</script>
<script>
$(document).ready(function(){
     showReportToEmployeeList();
    cal_pf_amount();
 $('#department').change(function(){
  var dept_id = $('#department').val();
  if(dept_id != '')
  {
   $.ajax({
    url:"<?php echo base_url(); ?>Payroll/fetch_designation",
    method:"POST",
    data:{"dept_id":dept_id},
    success:function(data)
    {
       $('#designation').html(data);
    }
   });
  }
  else
  {
   $('#designation').html('<option value="">Select Designation</option>');
  }
 });

   $('#cut_from').change(function(event) { 
        cal_pf_amount();
    });

});
$('#other_email').keyup(function(event) { 
        // alert('You released a key'); 
        //$('#empid_msg').html('You released a key');
          other_email=$('#other_email').val();
          //alert(other_email);
                    $.ajax({
                          url:"<?php echo base_url();?>Payroll/employee_email_exist/",
                          method:"POST",
                          data:{"other_email":other_email},
                          success:function(data)
                          {
                             $('#empemail_msg').html(data);
                          }
                   })
    }); 

function cal_pf_amount()
{
   var cut_from=$('#cut_from').val();
   var basic_salary=$('#basic_salary').val();
   var total_salary=$('#total_salary').val();
   var pf_emp_basic=0;
var esic_emp_basic=0;
   if(cut_from=='basic_salary')
   {
                if($('#pf_emp').val()!='')
                {
                    pf_emp_basic=$('#basic_salary').val()*($('#pf_emp').val())*0.01;
                    $('#pf_emp_amt').val(pf_emp_basic);
                }
                if($('#pf_cmp').val()!='')
                {      pf_cmp_basic=$('#basic_salary').val()*($('#pf_cmp').val())*0.01;
                     $('#pf_cmp_amt').val(pf_cmp_basic);        
                }
                if($('#esic_emp').val()!='')
                {    esic_emp_basic=$('#basic_salary').val()*($('#esic_emp').val())*0.01;
                        $('#esic_emp_amt').val(esic_emp_basic);  
                }
                if($('#esic_cmp').val()!='')
                {    esic_cmp_basic=$('#basic_salary').val()*($('#esic_cmp').val())*0.01;
                        $('#esic_cmp_amt').val(esic_cmp_basic);   
                }

                    cal_amt=(parseInt(pf_emp_basic) + parseInt(esic_emp_basic));
                    net_amt=parseInt($('#basic_salary').val())+parseInt($('#fooding_allowance').val())+parseInt($('#hra').val())+parseInt($('#mobile_allowance').val())+parseInt($('#transbortation_allowance').val())+parseInt($('#medical_allownce').val())+parseInt($('#accomodation').val())-cal_amt;
                 $('#net_salary').val(net_amt);   

   }
  if(cut_from=='total_salary'){
            if($('#pf_emp').val()!='')
            {
                pf_emp_basic=$('#total_salary').val()*($('#pf_emp').val())*0.01;
                $('#pf_emp_amt').val(pf_emp_basic);
            }
            if($('#pf_cmp').val()!='')
            {       pf_cmp_basic=$('#total_salary').val()*($('#pf_cmp').val())*0.01;
                 $('#pf_cmp_amt').val(pf_cmp_basic);        
            }
            if($('#esic_emp').val()!='')
            {    esic_emp_basic=$('#total_salary').val()*($('#esic_emp').val())*0.01;
                    $('#esic_emp_amt').val(esic_emp_basic);  
            }
            if($('#esic_cmp').val()!='')
            {    esic_cmp_basic=$('#total_salary').val()*($('#esic_cmp').val())*0.01;
                    $('#esic_cmp_amt').val(esic_cmp_basic);   
            }

            cal_amt=(parseInt(pf_emp_basic) + parseInt(esic_emp_basic));
                    net_amt=parseInt($('#basic_salary').val())+parseInt($('#fooding_allowance').val())+parseInt($('#hra').val())+parseInt($('#mobile_allowance').val())+parseInt($('#transbortation_allowance').val())+parseInt($('#medical_allownce').val())+parseInt($('#accomodation').val())-cal_amt;                   
                 $('#net_salary').val(net_amt);
                 console.log('cal_amt='+cal_amt+' net_amt='+net_amt);
   }
}


  $('#department').change(function(){
     showReportToEmployeeList();
     });

     function showReportToEmployeeList(){
           var dept_id = $('#department').val(); 
           var emp_id = $('#emp_id').val(); 
              if(dept_id != '')
              {
               $.ajax({
                url:"<?php echo base_url(); ?>Payroll/fetch_depart_report_employee",
                method:"POST",
                data:{"dept_id":dept_id,"emp_id":emp_id},
                success:function(data)
                {
                   $('#reporting_to').html(data);
                }
               });
              }
              else
              {
               $('#reporting_to').html('<option value="">Select Employee</option>');
              }
     }
</script>