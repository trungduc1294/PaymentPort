<div class="audience_form">
    <h1>Audience Registration Page</h1>
    <p>Please enter your email to proceed with the registration.</p>

    <span>{{$errMessage}}</span>

    <div class="form_regis">
        <div class="form-group">
            <label for="email">Email: </label>
            <input wire:model="full_name" type="text" name="full_name" id="full_name" placeholder="Enter your full name">
        </div>
        <div class="form-group">
            <label for="email">Email: </label>
            <input wire:model="email" type="email" name="email" id="email" placeholder="Enter your email">
        </div>

        <input wire:click.prevent="handleInfoRegistration" class="btn" type="submit" value="Confirm">
    </div>
</div>
