<div class="audience_form">
    <h1>Audience Registration Form</h1>

    <span>{{$errMessage}}</span>

    <div class="form_regis">
        <div class="form-group">
            <label for="email">Email: </label>
            <input wire:model="email" type="email" name="email" id="email" placeholder="Enter your email">
        </div>


        <div class="form-group">
            <label for="type_member">Choose your role:</label>
            <select wire:model="role_member" name="type_member" id="type_member">
                <option value="">Chose role member</option>
                <option value="ADM">Member</option>
                <option value="AD">Non-member</option>
                <option value="ADSM">Student-member</option>
                <option value="ADS">Student-non-member</option>
                <option value="SVNE">Vietnamese Student</option>
            </select>
        </div>
        <input wire:click.prevent="handleInfoRegistration" class="btn" type="submit" value="Confirm">
    </div>
</div>
