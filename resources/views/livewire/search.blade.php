<div class="presenter-page">

    @if($step === 'search')
        <div class="author_search">
            <div class="title">
                <h1>Newpapers List</h1>
                <p>Search by author name and choose your newpapers.</p>
            </div>

            <!-- Search input -->
            <div class="search_box">
                <label for="author-search">Search Author:</label>
                <input type="text" wire:model="keyword" id="author-search" placeholder="Enter author name" @change="$wire.search()">
            </div>



            <!-- Data table -->
            <form action="{{url('/author-info')}}" method="" enctype="multipart/form-data">
                @csrf
                <table>
                    <thead>
                    <tr>
                        <th>POSTID</th>
                        <th>Author</th>
                        <th>Title</th>
                        <th>Email</th>
                        <th>Choose to Purchase</th>
                    </tr>
                    </thead>
                    <tbody id="author-data">
                    <!-- Sample Data -->
                    @foreach($posts as $post)
                        <tr>
                            <td>{{$post['id']}}</td>
                            <td>{{$post['author_name']}}</td>
                            <td>{{$post['title']}}</td>
                            <td>{{$post['author']['email'] ?? null}}</td>
                            <td>
                                <input type="checkbox" name="purchase"
                                       value="{{$post['id']}}"
                                       wire:click="onCheckPost({{$post['id']}})"
                                >
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <div class="error_box">
                    <span>{{$errorMessages}}</span>
                </div>

                <button type="submit" value="Continue" wire:click.prevent="continue">Continue</button>
            </form>
        </div>


    @elseif($step === 'provide_info')
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
                                <span>{{ $post['title'] }}</span>
                                <input wire:model="extra_page{{$index}}" type="text" placeholder="Extra page" name="{{'extra'.$post['id']}}}">
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="author_section">
                    <div class="info_group">
                        <span>Your name: </span>
                        <p>{{$posts[0]['author_name']}}</p>
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
            <div class="button_container">
                <button type="button" wire:click.prevent="checkout">Show bill</button>
            </div>

        </div>

    @elseif($step === 'checkout')
        <div class="author_bill">
            <h2>Your Bill</h2>
            <div class="bill_content">
                <div class="bill_content_group">
                    <span>Atendance fee: </span>
                    <p>{{$atendance_fee}}$</p>
                </div>
                <div class="bill_content_group">
                    <span>Extra page fee: </span>
                    <p>{{$extra_page_fee}}$</p>
                </div>
                <div class="bill_content_group">
                    <span>Total: </span>
                    <p>{{$total_fee}}$</p>
                </div>
                <p>Click purchase button, we will send to you an email to confirm.</p>
            </div>
            <button type="button" wire:click.prevent="purchase">Purchase</button>
        </div>
    @elseif($step === 'email_success')
        <div class="success_container">
            <div class="author_email_success">
                <h2>Thank you for your purchase!</h2>
                <p>We have sent an email to you. Please check your email to confirm.</p>
                <a href="https://mail.google.com">Email</a>
            </div>
        </div>
    @endif
</div>
