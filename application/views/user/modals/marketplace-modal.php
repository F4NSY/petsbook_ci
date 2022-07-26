<div class="modal fade" id="marketplaceModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="registerModalLabel">Create new listing </h5>
                <button type="button" class="btn-close" data-mdb-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <?php $attribute = array('id' => 'registerForm', 'novalidate' => 'novalidate');
                    echo form_open('', $attribute); ?>
                    <div id="registerError" class="mb-3"></div>
                    <div class="btn-group mb-3" role="group" style="width:100%;">
                        <input type="radio" class="btn-check" name="btnradio" id="forSale" value="Buy" autocomplete="off" checked>
                        <label class="btn btn-outline-primary" for="forSale">Selling</label>

                        <input type="radio" class="btn-check" name="btnradio" id="forRent" value="Rent" autocomplete="off">
                        <label class="btn btn-outline-primary" for="forRent">Buying</label>
                    </div>
                    <div class="mb-3">
                        <input type="text" name="passwordRegister" id="passwordRegister" class="form-control" placeholder="Title" required>
                    </div>
                    <div class="mb-3">
                        <input type="number" name="confirmPasswordRegister" id="confirmPasswordRegister" class="form-control" placeholder="Price" required>
                    </div>
                    <div class="mb-3">
                        <input type="text" name="passwordRegister" id="passwordRegister" class="form-control" placeholder="Description" required>
                    </div>
                    <div class="mb-3">
                        <label for="picProp" class="form-label">Add Photos</label>
                        <input type="file" multiple class="form-control" id="picProp" name="picProp[]" accept="image/*">
                    </div>
                    <div class="d-grid mb-3">
                        <button id="registerButton" type="submit" class="btn btn-primary"><span>Submit</span></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>