<div class="author_provide_info">
    <div class="title">
        <h1>Checkout</h1>
    </div>
    <div class="body-content">
        <div class="selected_post_section">
            <h2>Your Post list:</h2>
            <ul>
                <?php $index = 0; ?>
                @foreach($selectedPosts as $post)
                    <li>
                            <?php $index++; ?>
                        <span>{{$index}}</span>
                        <span class="post_title">{{ $post['title'] }}</span>
                        <input wire:model="extra_page{{$index}}" type="text" placeholder="Extra page" name="{{'extra'.$post['id']}}}">
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="author_section">
            <div class="info_group">
                <span>Your name: </span>
                <p>{{ \App\Models\Post::where('author_id', $author->id)->value('author_name') }}</p>
            </div>
            <div class="info_group">
                <span>Your email: </span>
                <p>{{$author->email}}</p>
            </div>
            <div class="info_group">
                <span>Number of newpaper: </span>
                <p>{{$totalPosts}}</p>
            </div>

            <div class="form-group">
                <label for="type_member">Choose your role:</label>
                <select wire:model="type_member" name="type_member" id="type_member">
                    <option value="">Choose your role</option>
                    <option value="ADM">Member</option>
                    <option value="AD">Non-member</option>
                    <option value="ADSM">Student-member</option>
                    <option value="ADS">Student-non-member</option>
                    <option value="SVNE">Vietnamese Student</option>
                </select>
            </div>
        </div>
    </div>

    <div class="error_box">
        <span>{{$errorMessages}}</span>
    </div>

    <div class="button_container">
        <button type="button" wire:click.prevent="showbill">Show bill</button>
    </div>

</div>