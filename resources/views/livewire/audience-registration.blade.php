<div class="container">
    @if($step === 'registration-form')
        <div class="audience_form">
            <h1>Audience Registration Form</h1>
            <div class="form_regis">
                <div class="form-group">
                    <label for="email">Email: </label>
                    <input wire:model="email" type="email" name="email" id="email" placeholder="Enter your email">
                    <span>{{$errMessage}}</span>
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
    @elseif($step === 'show-bill')
        <div class="show_bill">
            <h1>Billing</h1>
            <div class="bill_container">
                <div class="bill_info">
                    <span>Your email:</span> <p>{{$email}}</p>
                </div>
                <div class="bill_info">
                    <span>Total Price:</span> <p>{{$total_price}}$</p>
                </div>
                <div class="bill_info">
                    <span>Role:</span> <p>{{$role_member}}</p>
                </div>
            </div>
            <div class="button_wrapper">
                <button wire:click.prevent="verify_bill" >Confirm</button>
                <button wire:click.prevent="cancel_bill">Cancel</button>
            </div>
        </div>
    @elseif($step === 'input-code')
        <div class="verify_by_code">
            <h3>Check your email and fill confirm code here!</h3>
            <div class="verify_code_container">
                <input wire:model="user_code_input" type="text">
                <span>{{$errMessage}}</span>
                <button wire:click.prevent="checkCode">Submit</button>
            </div>
        </div>

    @elseif($step === 'payment')
        <div class="payment_port">
            <h1>Payment</h1>
            <div class="email_anouncement_content">
                <p>Thank you for your registration. Please fill in infomation to pay yourbill.</p>
            </div>
            <div class="pay_info">
                <div class="pay_info_item">
                    <span>Full name:</span>
                    <input wire:model="full_name" type="text">
                </div>
                <div class="pay_info_item">
                    <span>Phone number:</span>
                    <input wire:model="phone_number" type="text">
                </div>
                <div class="pay_info_item">
                    <span>Card number:</span>
                    <input wire:model="card_number" type="text">
                </div>
                <div class="pay_info_item">
                    <span>Expiration date:</span>
                    <input wire:model="expiration_date" type="text">
                </div>
                <div class="pay_info_item">
                    <span>CVV:</span>
                    <input wire:model="cvv" type="text">
                </div>
                <div class="error_box">
                    <span>{{$errMessage}}</span>
                </div>
                <button wire:click="testPaySuccess">Purchase</button>
            </div>
        </div>

    @elseif($step === 'success')
        <div class="success">
            <h1>Thank you for your registration!</h1>
            <div class="success_content">
                <p>Your registration is successful. Please check your email for more information.</p>
            </div>
        </div>

    @endif
</div>
