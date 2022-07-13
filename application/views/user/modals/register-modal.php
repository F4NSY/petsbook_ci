<div class="modal fade" id="registerModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="registerModalLabel">Register</h5>
                <button type="button" class="btn-close" data-mdb-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <?php $attribute = array('id' => 'registerForm', 'novalidate' => 'novalidate');
                    echo form_open('', $attribute); ?>
                    <div id="registerError" class="mb-3"></div>
                    <div class="d-flex mb-3 gap-2">
                        <input type="text" name="firstNameRegister" id="firstNameRegister" class="form-control" placeholder="First Name" required>
                        <input type="text" name="lastNameRegister" id="lastNameRegister" class="form-control" placeholder="Last Name" required>
                    </div>
                    <div class="mb-3">
                        <input type="email" name="emailRegister" id="emailRegister" class="form-control" placeholder="Email" required>
                    </div>
                    <div class="mb-3">
                        <input type="password" name="passwordRegister" id="passwordRegister" class="form-control" placeholder="Password" required>
                    </div>
                    <div class="mb-3">
                        <input type="password" name="confirmPasswordRegister" id="confirmPasswordRegister" class="form-control" placeholder="Confirm Password" required>
                    </div>
                    <div class="mb-3">
                        <label for="birthdayRegister">Birthday</label>
                        <input type="date" id="birthdayRegister" name="birthdayRegister" placeholder="" class="form-control"/>
                    </div>
                    <div class="mb-3">
                        <label>Gender</label>
                        <div>
                            <!-- Default radio -->
                            <div class="form-check form-check-inline">
                            <input
                                class="form-check-input"
                                type="radio"
                                name="genderRegister"
                                id="maleRegister"
                                value="Male"
                            />
                            <label class="form-check-label" for="maleRegister"> Male </label>
                            </div>

                                <!-- Default checked radio -->
                            <div class="form-check form-check-inline">
                            <input
                                class="form-check-input"
                                type="radio"
                                name="genderRegister"
                                id="femaleRegister"
                                value="Female"
                            />
                            <label class="form-check-label" for="female"> Female </label>
                            </div>
                        </div>
                    </div>
                    <div class="d-grid mb-3">
                        <button id="registerButton" type="submit" class="btn btn-primary"><span>Sign up</span></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="<?= base_url(); ?>assets/js/register.js"></script>