<div class="author_search">
    <div class="title">
        <h1>The payment page for presenter.</h1>
        <p>Search by author name and select your posts.</p>
    </div>

    <!-- Search input -->
    <div class="search_box">
        <label for="author-search">Author's name:</label>
        <input type="text" wire:model="keyword" id="author-search" placeholder="Enter author name" @change="$wire.search()">
    </div>



    <!-- Data table -->
    <form action="{{url('/author-info')}}" enctype="multipart/form-data">
        @csrf
        <table>
            <thead>
            <tr>
                <th>POSTID</th>
                <th>Author</th>
                <th>Title</th>
                <th>Email</th>
                <th>Add to pay.</th>
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
